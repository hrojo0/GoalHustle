<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::orderBy('name','asc')
            ->get();
        return view('admin.games.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }

    public function gamesPerTournament(Request $request){
        
        $queryGames = Game::query();
        if ($request->input('tournament')) {
            $queryGames->where('tournament_id', $request->input('tournament'));
        }
        
        $countData = $queryGames->count();
        
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input('columns')[$orderColumnIndex]['data'];

        // Map the DataTables column to the actual database column
        $columnMap = [
            'tournament' => 'tournament_id',
            'homeTeam' => 'home_team_id',
            'awayTeam' => 'away_team_id'
        ];

        $orderColumn = $columnMap[$orderColumnName];
        $orderDir = $request->input('order.0.dir');
 
        $games = $queryGames->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy($orderColumn, $orderDir)
            ->get();

        $data = [];
        foreach ($games as $game) {
            $data[] = [
                'game' => $game->id,
                'tournament' => $game->tournament->name,
                'tournamentSlug' => $game->tournament->slug,
                'homeTeam' => $game->homeTeam->name,
                'homeTeamSlug' => $game->homeTeam->slug,
                'awayTeam' => $game->awayTeam->name,
                'awayTeamSlug' => $game->awayTeam->slug,
            ];
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($countData),
            "recordsFiltered" => intval($countData),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function generateGames(Request $request){
        $tournament = Tournament::findOrFail($request->input('tournament_id'));
    
        Game::where('tournament_id', $tournament->id)->delete();
    
        $teams = TournamentTeam::where('tournament_id', $tournament->id)->pluck('team_id')->toArray();
    
        $roundsTournament = count($teams) - 1;
        $gamesTotal = (count($teams) / 2) * $roundsTournament;
    
        $dateInitialRound = new DateTime();
        $dateInitialRound->modify('next friday');
        $generatedGames = [];
    
        for ($round = 1; $round <= $roundsTournament; $round++) {
            $shuffledTeams = $teams;
            shuffle($shuffledTeams);
    
            for ($i = 0; $i < count($shuffledTeams) / 2; $i++) {
                $homeTeam = $shuffledTeams[$i];
                $awayTeam = $shuffledTeams[count($shuffledTeams) - 1 - $i];
    
                while (in_array([$homeTeam, $awayTeam, $tournament->id], $generatedGames) ||
                in_array([$awayTeam, $homeTeam, $tournament->id], $generatedGames) || $homeTeam === $awayTeam) {
                    shuffle($shuffledTeams);
                    $homeTeam = $shuffledTeams[$i];
                    $awayTeam = $shuffledTeams[count($shuffledTeams) - 1 - $i];
                }
                    $generatedGames[] = [$homeTeam, $awayTeam, $tournament->id];
    
                    $randomPlusDays = mt_rand(0, 2);
                    $matchday = clone $dateInitialRound;
                    $matchday->modify("+{$randomPlusDays} days");
                    $matchday = $matchday->format('Y-m-d');
    
                    Game::create([
                        'tournament_id' => $tournament->id,
                        'home_team_id' => $homeTeam,
                        'away_team_id' => $awayTeam,
                        'matchday' => $matchday,
                        'round' => $round,
                        'home_goals' => 0,
                        'away_goals' => 0,
                    ]);
                
            }
            $dateInitialRound->modify('next friday');
        }
    
        return redirect()->route('games.index')
            ->with('success-games', $gamesTotal.' games for ' . $tournament->name . ' successfully generated');
    }
    
    
}
