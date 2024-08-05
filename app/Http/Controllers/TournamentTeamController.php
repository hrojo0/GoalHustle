<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentTeamRequest;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentTeamController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index($tournament)
    {
        $user = Auth::user(); //obtiene información del usuario loggeado
        $tournament = Tournament::where('slug', $tournament)->firstOrFail();
        $teams = TournamentTeam::select('tournament_teams.*')
            ->join('teams', 'tournament_teams.team_id', '=', 'teams.id')
            ->where('tournament_teams.tournament_id', $tournament->id)
            ->orderBy('teams.name', 'asc')
            ->paginate(25);
        return view('admin.tournament_teams.index', compact('teams', 'tournament'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($tournament)
    {
        $tournament = Tournament::where('slug', $tournament)->firstOrFail();
        $teamsInTournament = TournamentTeam::where('tournament_id',$tournament->id)
            ->pluck('team_id')
            ->toArray();
        $teams = Team::whereNotIn('id',$teamsInTournament)->orderBy('name', 'asc')->get();
        return view('admin.tournament_teams.create', compact('teams','tournament','teamsInTournament'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', TournamentTeam::class);
        TournamentTeam::create([
            'tournament_id' => $request->tournament_id,
            'team_id' => $request->team_id,
        ]);
        
        $tournament = Tournament::where('id', $request->tournament_id)->firstOrFail();
        $team = Team::where('id', $request->team_id)->firstOrFail();
        //redireccionar a articles index
        return redirect()->route('tournamentTeam.index', $tournament->slug)
        ->with('success-update', 'Team '. $team->name .' succesfully updated to '.$tournament->name);
    }

    public function show(TournamentTeam $tournamentTeam){
        $teams = Team::orderBy('name', 'asc')->get();
        return view('admin.tournament_teams.edit', compact('teams', 'tournamentTeam'));
    }

    public function edit(TournamentTeam $tournamentTeam)
    {
        
        $teamsInTournament = TournamentTeam::where('tournament_id',$tournamentTeam->tournament_id)
            ->pluck('team_id')
            ->toArray();
        $teams = Team::whereNotIn('id',$teamsInTournament)->orderBy('name', 'asc')->get();
        return view('admin.tournament_teams.edit', compact('teams', 'tournamentTeam'));
    }

    public function update(TournamentTeamRequest $request, TournamentTeam $tournamentTeam)
    {
        $this->authorize('update', $tournamentTeam);


        //actualizar datos
        $tournamentTeam->update([
            'team_id' => $request->team_id
        ]);

        $tournamentSlug = $tournamentTeam->tournament->slug;
        //redireccionar a articles index
        return redirect()->route('tournamentTeam.index', $tournamentSlug)
        ->with('success-update', 'Tournament '. $request->name .' succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TournamentTeam $tournamentTeam)
    {
        $this->authorize('delete', $tournamentTeam);

        //Eliminar el artículo
        $tournamentSlug = $tournamentTeam->tournament->slug;
        $tournamentTeam->delete();
        return redirect()->route('tournamentTeam.index', $tournamentSlug)
        ->with('success-delete', 'Team '.$tournamentTeam->team->name.' deleted');
    }

    public function search(Request $request){

        $tournametTeam = TournamentTeam::select('teams.name', 'teams.slug','tournament_teams.id')
        ->join('teams', 'tournament_teams.team_id', '=', 'teams.id')
        ->where('tournament_teams.tournament_id', $request->input('tournament_id'));

        if ($request->input('search.value')) {
            //$tournametTeam->where('teams.name', 'like', '%' . $request->input('search.value') . '%');
            $tournametTeam->whereRaw('LOWER(teams.name) LIKE ?', ['%' . strtolower($request->input('search.value')) . '%']);
        }

        $countData = $tournametTeam->count();

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order.0.dir');

        $teams = $tournametTeam
            ->orderBy($orderColumn, $orderDir)
            ->offset($request->input('start'))
            ->limit($request->input('length'))
            ->get();

        $data = [];
        foreach ($teams as $team) {
            $data[] = [
                'id' => $team-> id,
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
