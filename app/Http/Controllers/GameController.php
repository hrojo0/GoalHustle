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
        //$tournament_id = $request->input('tournament_id');
        $tournament = Tournament::findOrFail($request->input('tournament_id'));

        Game::where('tournament_id', $tournament->id)->delete();

        $teams = TournamentTeam::where('tournament_id', $tournament->id)
            ->get();









            $gamesCreated = [];
            $roundsTournament = $tournament->rounds;
            $roundTeams = []; //$roundTeams[]
            for ($i = 1; $i <= $roundsTournament; $i++) {
                $roundTeams[$i] = []; //$roundTeams[1][]
            }
            
            $gamesTotal = count($teams) * $roundsTournament;
            $round = 1;
            $roundFlag = 0;
            $dateInitialRound = new DateTime();
            $dateInitialRound->modify('next friday');
            for ($i = 0; $i < $gamesTotal; $i++) {
                $homeTeam = $teams->random()->id;
                $awayTeam = $teams->random()->id;

                // Ensure home_team_id is not equal to away_team_id and not duplicated
                while ($homeTeam === $awayTeam || in_array([$homeTeam, $awayTeam], $gamesCreated) || in_array([$awayTeam, $homeTeam], $gamesCreated) ||
                in_array($homeTeam, $roundTeams[$round]) || in_array($awayTeam, $roundTeams[$round])) {
                    $homeTeam = $teams->random()->id;
                    $awayTeam = $teams->random()->id;
                }

                $gamesCreated[] = [$homeTeam, $awayTeam];
                $roundTeams[$round][] = $homeTeam; //$roundTeams[1]['homeTeam']
                $roundTeams[$round][] = $awayTeam; //$roundTeams[1]['homeTeam','awayTeam']

                $min = $dateInitialRound;
                $max = date_add($dateInitialRound, date_interval_create_from_date_string("3 days"));
                //$matchday = rand($min, $max);
                $matchday = $dateInitialRound;
                //Create game with these specific parameters and factory on the others
                Game::insert([
                    'tournament_id' => $tournament->id,
                    'home_team_id' => $homeTeam,
                    'away_team_id' => $awayTeam,
                    'matchday' => $matchday,
                    'round' => $round,
                    'home_goals' => 0,
                    'away_goals' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $roundGames = $gamesTotal / $roundsTournament;
                $roundFlag++;
                $round = $roundFlag == $roundGames ? $round++ : $round;
            }





























        
        // Your logic to generate games for the specific tournament
        // ...
    
        
        return redirect()->route('games.index')
            ->with('success-games', 'Games for ' . $tournament->name . ' successfully generated');
    }
}
