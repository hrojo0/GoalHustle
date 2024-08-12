<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\StatsPlayer;
use App\Models\Team;
use App\Models\TournamentTeam;
use App\Models\TournamentTeams;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); //obtiene información del usuario loggeado
        $teams = Team::orderBy('name', 'asc')
            ->paginate(30);

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        //guardar solicitud de cliente
        $team = $request->all();

        //validar si hay un archivo, como un jpg, en el request
        if($request->hasFile('logo')){
            $team['logo'] = $request->file('logo')->store('teams');
        }

        Team::create($team);

        return redirect()->action([TeamController::class, 'index'])
        ->with('success-create', 'Team '.$request->name.' succesfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $players = Player::where('team_id', $team->id)
            ->orderByRaw(
                "CASE 
                    WHEN position = 'Goalkeeper' THEN 1 
                    WHEN position = 'Defense' THEN 2 
                    WHEN position = 'Midfielder' THEN 3 
                    WHEN position = 'Striker' THEN 4 
                    ELSE 5 
                END")
            ->get();
        
        $topScorer = DB::table('stats_players')
            ->select('player_id', 'players.name', 'players.photo', DB::raw('SUM(goals) as total_goals'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->where('players.team_id', $team->id)
            ->groupBy('player_id','players.name','players.photo')
            ->orderBy('total_goals', 'desc')
            ->first();

        $topAssister = DB::table('stats_players')
            ->select('player_id', 'players.name', 'players.photo', DB::raw('SUM(assists) as total_assists'))
            ->join('players', 'stats_players.player_id', '=', 'players.id')
            ->where('players.team_id', $team->id)
            ->groupBy('player_id','players.name','players.photo')
            ->orderBy('total_assists', 'desc')
            ->first();

        $teamId = $team->id;
        $nextMatches = Game::where(function($query) use ($teamId) {
                    $query->where('home_team_id', $teamId)
                          ->orWhere('away_team_id', $teamId);
                })
            ->where('matchday', '>=', now())
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();

        $teamTournaments = TournamentTeams::where('team_id', $team->id)
            ->with('tournament')
            ->get();
        
        return view('teams.show', compact('team', 'players', 'topScorer', 'topAssister', 'nextMatches', 'teamTournaments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $this->authorize('view', $team);
        //Obtener categorías publicas
        $teams = Team::select('id', 'name')
                        ->orderBy('name')
                        ->get();
        return view('admin.teams.edit', compact('teams', 'team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team){
        //$this->authorize('update', $team);
        //si usuario sube nueva imagen
        if($request->hasFile('logo')){//if para saber si ya existe una carpeta
            //Eliminar imagen anterior
            File::delete(public_path('storage/' . $team->logo));
        
            //Guarda nueva imagen
            $team['logo'] = $request->file('logo')->store('tournaments');
        }

        //actualizar datos
        $team->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        //redireccionar a articles index
        return redirect()->action([TeamController::class, 'index'])
        ->with('success-update', 'Team '. $request->name .' succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->action([TeamController::class, 'index'], compact('game'))
        ->with('success-delete', $team->name.' deleted');
    }

    public function search(Request $request){
        $filter = Team::query();

        if ($request->input('search.value')) {
           // $filter->where('name', 'like', '%' . $request->input('search.value') . '%');
            $filter->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->input('search.value')) . '%']);
        }

        $countData = $filter->count();

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order.0.dir');

        $teams = $filter->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy($orderColumn, $orderDir)
            ->get();

        $data = [];
        foreach ($teams as $team) {
            $data[] = [
                'name' => $team->name,
                'slug' => $team->slug,
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
