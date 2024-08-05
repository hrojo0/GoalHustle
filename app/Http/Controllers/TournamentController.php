<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentRequest;
use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TournamentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$user = Auth::user(); //obtiene información del usuario loggeado
        $tournaments = Tournament::orderBy('name', 'asc')
            ->paginate(30);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*$teams = Team::select('id', 'name')
                        ->orderBy('name')
                        ->get();*/
        return view('admin.tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentRequest $request)
    {
        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        //guardar solicitud de cliente
        $tournament = $request->all();

        //validar si hay un archivo, como un jpg, en el request
        if($request->hasFile('logo')){
            $tournament['logo'] = $request->file('logo')->store('tournaments');
        }

        /*echo '<pre>';
        var_dump($article);
        echo '</pre>';
        exit;*/
        Tournament::create($tournament);

        return redirect()->action([TournamentController::class, 'index'])
        ->with('success-create', 'Tournament '.$request->name.' succesfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        //$this->authorize('published', $article);
        
        //ver detalles del articulo
        $games = Game::where('tournament_id',$tournament->id)
                        ->with('homeTeam','awayTeam')
                        ->orderBy('matchday','desc')->get();
        
        $teams = Team::with(['homeGames', 'awayGames'])->get();

        // Calculate team stats
        $teamStats = DB::table('teams')
        ->select('teams.name', 'teams.logo', 'teams.slug', DB::raw('
            COUNT(games.id) AS total_games,
            SUM(CASE WHEN games.home_team_id = teams.id THEN games.home_goals ELSE 0 END) +
            SUM(CASE WHEN games.away_team_id = teams.id THEN games.away_goals ELSE 0 END) AS total_goals,
            SUM(CASE WHEN games.home_team_id = teams.id THEN games.away_goals ELSE 0 END) +
            SUM(CASE WHEN games.away_team_id = teams.id THEN games.home_goals ELSE 0 END) AS total_goals_conceded,
            SUM(CASE WHEN (games.home_team_id = teams.id AND games.home_goals > games.away_goals) THEN 1 ELSE 0 END) +
            SUM(CASE WHEN (games.away_team_id = teams.id AND games.away_goals > games.home_goals) THEN 1 ELSE 0 END) AS total_wins,
            SUM(CASE WHEN (games.home_team_id = teams.id AND games.home_goals < games.away_goals) THEN 1 ELSE 0 END) +
            SUM(CASE WHEN (games.away_team_id = teams.id AND games.away_goals < games.home_goals) THEN 1 ELSE 0 END) AS total_loses,
            SUM(CASE WHEN ((games.home_team_id = teams.id OR games.away_team_id = teams.id) AND games.home_goals = games.away_goals) THEN 1 ELSE 0 END) AS total_draws,
            (SUM(CASE WHEN (games.home_team_id = teams.id AND games.home_goals > games.away_goals) THEN 1 ELSE 0 END) +
             SUM(CASE WHEN (games.away_team_id = teams.id AND games.away_goals > games.home_goals) THEN 1 ELSE 0 END)) * 3 +
            SUM(CASE WHEN ((games.home_team_id = teams.id OR games.away_team_id = teams.id) AND games.home_goals = games.away_goals) THEN 1 ELSE 0 END) AS total_points
        '))
        ->leftJoin('games', function($join) {
            $join->on('teams.id', '=', 'games.home_team_id')
                 ->orOn('teams.id', '=', 'games.away_team_id');
        })
        ->where('games.tournament_id', $tournament->id)
        ->groupBy('teams.name', 'teams.logo', 'teams.slug')
        ->orderByDesc('total_points')
        ->get();

        $topScorers = DB::table('stats_players')
            ->select('players.id', 'players.name', 'players.photo', 'teams.name as team_name', DB::raw('SUM(stats_players.goals) as total_goals'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->join('games', 'stats_players.game_id', '=', 'games.id')
            ->where('games.tournament_id', $tournament->id)
            ->groupBy('players.id', 'players.name', 'teams.name')
            ->orderByDesc('total_goals')
            ->limit(5)
            ->get();

        $topAssisters = DB::table('stats_players')
            ->select('players.id', 'players.name', 'players.photo', 'teams.name as team_name', DB::raw('SUM(stats_players.assists) as total_assists'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->join('games', 'stats_players.game_id', '=', 'games.id')
            ->where('games.tournament_id', $tournament->id)
            ->groupBy('players.id', 'players.name', 'teams.name')
            ->orderByDesc('total_assists')
            ->limit(5)
            ->get();

        $topYellowCards = DB::table('stats_players')
            ->select('players.id', 'players.name', 'players.photo', 'teams.name as team_name', DB::raw('SUM(stats_players.yellow_cards) as total_yellow_cards'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->join('games', 'stats_players.game_id', '=', 'games.id')
            ->where('games.tournament_id', $tournament->id)
            ->groupBy('players.id', 'players.name', 'teams.name')
            ->orderByDesc('total_yellow_cards')
            ->limit(5)
            ->get();

        $topRedCards = DB::table('stats_players')
            ->select('players.id', 'players.name', 'players.photo', 'teams.name as team_name', DB::raw('SUM(stats_players.red_card) as total_red_cards'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->join('games', 'stats_players.game_id', '=', 'games.id')
            ->where('games.tournament_id', $tournament->id)
            ->groupBy('players.id', 'players.name', 'teams.name')
            ->orderByDesc('total_red_cards')
            ->limit(5)
            ->get();
            
        return view('tournaments.show', compact('tournament', 'games', 'teamStats', 'topScorers', 'topAssisters', 'topYellowCards', 'topRedCards'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        $this->authorize('view', $tournament);
        //Obtener categorías publicas
        $teams = Team::select('id', 'name')
                        ->orderBy('name')
                        ->get();
        return view('admin.tournaments.edit', compact('teams', 'tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TournamentRequest $request, Tournament $tournament)
    {
        $this->authorize('update', $tournament);
        //si usuario sube nueva imagen
        if($request->hasFile('logo')){//if para saber si ya existe una carpeta
            //Eliminar imagen anterior
            File::delete(public_path('storage/' . $tournament->logo));
        
            //Guarda nueva imagen
            $tournament['logo'] = $request->file('logo')->store('tournaments');
        }

        //actualizar datos
        $tournament->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'season' => $request->season,
            'rounds' => $request->rounds,
            'is_featured' => $request->is_featured,
        ]);

        //redireccionar a articles index
        return redirect()->action([TournamentController::class, 'index'])
        ->with('success-update', 'Tournament '. $request->name .' succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $this->authorize('delete', $tournament);
        //eliminar la imagen del articulo
        if($tournament->logo){
            File::delete(public_path('storage/' . $tournament->logo));
        }

        //Eliminar el artículo
        $tournament->delete();
        return redirect()->action([TournamentController::class, 'index'], compact('tournament'))
        ->with('success-delete', 'Tournament '.$tournament->name.' deleted');
    }

    public function search(Request $request){

        //$query = Tournament::with('teams');

        if ($request->input('search.value')) {
            Tournament::where('name', 'like', '%' . $request->input('search.value') . '%');
        }

        $countData = Tournament::count();

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order.0.dir');

        $tournaments = Tournament::offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy($orderColumn, $orderDir)
            ->get();
        /*$tournaments = Tournament::offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy('name', 'asc')
            ->get();*/

        $data = [];
        foreach ($tournaments as $tournament) {
            $data[] = [
                'name' => $tournament->name,
                'season' => $tournament->season,
                'rounds' => $tournament->rounds,
                'featured' => $tournament->is_featured,
                'slug' => $tournament->slug,
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

}
