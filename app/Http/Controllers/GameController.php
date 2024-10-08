<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\StatsPlayer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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

    public function create()
    {
        $tournaments = Tournament::select('id', 'name')
            ->get();
        $teams = Team::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.games.create', compact('tournaments' ,'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request){

        $game = $request->all();

        $existingGame = Game::where('tournament_id', $game['tournament'])
            ->where(function ($query) use ($game) {
                $query->where([
                    ['home_team_id', '=', $game['home_team']],
                    ['away_team_id', '=', $game['away_team']]
                ])->orWhere([
                    ['home_team_id', '=', $game['away_team']],
                    ['away_team_id', '=', $game['home_team']]
                ]);
            })
            ->first();

        if ($existingGame) {
            $home_team = Team::where('id', $request->home_team)->first();
            $away_team = Team::where('id', $request->away_team)->first();
            return redirect()->back()->with('failed-duplicate', 'The game '.$home_team->name.' vs. '.$away_team->name.' is already store in the tournament');
        }

        $game['tournament_id'] = $request->tournament;
        $game['home_team_id'] = $request->home_team;
        $game['away_team_id'] = $request->away_team;
        // Set default values for home_goals and away_goals
        $game['home_goals'] = 0;
        $game['away_goals'] = 0;

        $game_created = Game::create($game);
        $home_team = Team::where('id', $request->home_team)->first();
        $away_team = Team::where('id', $request->away_team)->first();


        //Generate defeault stats for the game
        $home_players = Player::where('team_id', $request->home_team);
        $away_players = Player::where('team_id', $request->away_team);

        foreach($home_players as $player){
            StatsPlayer::create([
                'game_id' => $game_created->id,
                'player_id' => $player->id,
                'goals' => 0,
                'assists' => 0,
                'yellow_cards' => 0,
                'red_card' => 0,
            ]);
        }
        foreach($away_players as $player){
            StatsPlayer::create([
                'game_id' => $game_created->id,
                'player_id' => $player->id,
                'goals' => 0,
                'assists' => 0,
                'yellow_cards' => 0,
                'red_card' => 0,
            ]);
        }

        return redirect()->action([GameController::class, 'index'])
        ->with('success-create', 'Game '.$home_team->name.' vs. '.$away_team->name.' succesfully created');
    }

    public function show(Game $game){
        
    }

    public function edit(Game $game){
        //$this->authorize('view', $article);

        $tournaments = Tournament::select('id', 'name')
            ->get();
        $teams = Team::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
        $allow_stats = $game->matchday <= now() ? true : false;
        // Retrieve players from both teams and eager load their stats for this game
        $home_team_players = Player::where('team_id', $game->home_team_id)
            ->with(['statsPlayer' => function ($query) use ($game) {
                $query->where('game_id', $game->id);
            }])->orderBy('name')->get();

        $away_team_players = Player::where('team_id', $game->away_team_id)
            ->with(['statsPlayer' => function ($query) use ($game) {
                $query->where('game_id', $game->id);
            }])->orderBy('name')->get();

        return view('admin.games.edit', compact('game', 'tournaments', 'teams', 'allow_stats', 'home_team_players', 'away_team_players'));
}

    public function update(GameRequest $request, Game $game){
        
        //$this->authorize('update', $article);

        //actualizar datos
        $home_goals = isset($request->home_goals) ? $request->home_goals : 0;
        $away_goals = isset($request->away_goals) ? $request->away_goals : 0;
        try{
            $game->update([
                'tournament_id' => $request->tournament,
                'home_team_id' => $request->home_team,
                'away_team_id' => $request->away_team,
                'matchday' => $request->matchday,
                'round' => $request->round,
                'home_goals' => $home_goals,
                'away_goals' => $away_goals,
            ]);

            if ($request->has('player_stats')) {
                    foreach ($request->input('player_stats') as $player_id => $stats) {
                        $statsPlayer = StatsPlayer::updateOrCreate(
                            [
                                'game_id' => $game->id,
                                'player_id' => $player_id
                            ],
                            [
                                'goals' => $stats['goals'] ?? 0,
                                'assists' => $stats['assists'] ?? 0,
                                'yellow_cards' => $stats['yellow_cards'] ?? 0,
                                'red_card' => $stats['red_card'] ?? 0,
                            ]
                        );
                    }

            }

            
            return redirect()->action([GameController::class, 'index'])
            ->with('success-update', 'Game succesfully updated');
        } catch(QueryException $exception){
            return redirect()->back()
            ->with('error-update', 'There was a problem updating the game. Probably the game with the same teams already exists for this tournament.');
        }
    }

    public function destroy(Game $game){
        //$this->authorize('delete', $game);
        //Eliminar el artículo
        $game->delete();
        return redirect()->action([GameController::class, 'index'], compact('game'))
        ->with('success-delete', 'Game '.$game->homeTeam->name.' vs '.$game->awayTeam->name.' deleted');
    }

    public function gamesPerTournament(Request $request){
        $filter = Game::query()
            ->join('teams as home_teams', 'games.home_team_id', '=', 'home_teams.id')
            ->join('teams as away_teams', 'games.away_team_id', '=', 'away_teams.id');

        if ($request->input('tournament')) {
            $filter->where('tournament_id', $request->input('tournament'));
        }

        if ($request->input('search.value')) {
            $searchValue = strtolower($request->input('search.value'));
            $filter->where(function ($query) use ($searchValue) {
                $query->whereRaw('LOWER(home_teams.name) LIKE ?', ['%' . $searchValue . '%'])
                    ->orWhereRaw('LOWER(away_teams.name) LIKE ?', ['%' . $searchValue . '%']);
            });
        }

        // Get total and filtered records count
        $countTotal = Game::count();
        $countFiltered = $filter->count();

        // Determine order column and direction
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input('columns')[$orderColumnIndex]['data'];

        // Map DataTables column to database column
        $columnMap = [
            'tournament' => 'tournament_id',
            'homeTeam' => 'home_teams.name',
            'awayTeam' => 'away_teams.name',
            'round' => 'round',
        ];

        $orderColumn = $columnMap[$orderColumnName];
        $orderDir = $request->input('order.0.dir');

        // Get paginated and ordered games
        $games = $filter->offset($request->input('start'))
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
                'round' => $game->round,
            ];
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($countTotal),
            "recordsFiltered" => intval($countFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }



    public function search($filter, $request){
        $countData = $filter->count();
            
            $orderColumnIndex = $request->input('order.0.column');
            $orderColumnName = $request->input('columns')[$orderColumnIndex]['data'];
    
            // Map the DataTables column to the actual database column
            $columnMap = [
                'tournament' => 'tournament_id',
                'homeTeam' => 'home_teams.name',
                'awayTeam' => 'away_teams.name',
                'round' => 'round',
            ];

            $orderColumn = $columnMap[$orderColumnName];
            $orderDir = $request->input('order.0.dir'); 

            $games = $filter->offset($request->input('start'))
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
                    'round' => $game->round,
                ];
            }
    
            $json_data = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($countData),
                "recordsFiltered" => intval($countData),
                "data" => $data
            ];
    }

    public function generateGames(Request $request){
        //$request->tournament;
        try{
            $tournament = Tournament::findOrFail($request->input('tournament_id'));
        
            $games_deleted = Game::where('tournament_id', $tournament->id)->get();
            foreach($games_deleted as $game_deleted){
                StatsPlayer::where('game_id',$game_deleted->id)->delete();
            }
            
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
        
                        $game_created = Game::create([
                            'tournament_id' => $tournament->id,
                            'home_team_id' => $homeTeam,
                            'away_team_id' => $awayTeam,
                            'matchday' => $matchday,
                            'round' => $round,
                            'home_goals' => 0,
                            'away_goals' => 0,
                        ]);

                        //Generate defeault stats for the game
                        $home_players = Player::where('team_id', $homeTeam)->get();
                        $away_players = Player::where('team_id', $awayTeam)->get();

                        foreach($home_players as $player){
                            StatsPlayer::create([
                                'game_id' => $game_created->id,
                                'player_id' => $player->id,
                                'goals' => 0,
                                'assists' => 0,
                                'yellow_cards' => 0,
                                'red_card' => 0,
                            ]);
                        }
                        foreach($away_players as $player){
                            StatsPlayer::create([
                                'game_id' => $game_created->id,
                                'player_id' => $player->id,
                                'goals' => 0,
                                'assists' => 0,
                                'yellow_cards' => 0,
                                'red_card' => 0,
                            ]);
                        }
                    
                }
                $dateInitialRound->modify('next friday');
            }
        
            return redirect()->route('games.index')
            ->with('success-games', $gamesTotal.' games for ' . $tournament->name . ' successfully generated');
        } catch(ModelNotFoundException $e){
            return redirect()->route('games.index')
            ->with('failed-generate', 'Please select one team');
        }
    }

    
    
}
