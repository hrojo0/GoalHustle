<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($tournament)
    {
        $user = Auth::user(); //obtiene información del usuario loggeado
        $tournament = Tournament::where('slug', $tournament)->firstOrFail();
        $teams = TournamentTeams::select('tournament_teams.*')
            ->join('teams', 'tournament_teams.team_id', '=', 'teams.id')
            ->where('tournament_teams.tournament_id', $tournament->id)
            ->orderBy('teams.name', 'asc')
            ->paginate(25);
        return view('admin.tournament_teams.index', compact('teams', 'tournament'));
    }

    public function create(){
        //
    }


    public function store(Request $request){
        //
    }

    public function show(TournamentTeams $tournamentTeams){
        //
    }


    public function edit(TournamentTeams $tournamentTeams)
    {
        // Verify the received model
        dd($tournamentTeams); // Check what data is received

        $teams = Team::orderBy('name', 'asc')->get();
        return view('admin.tournament_teams.edit', compact('teams', 'tournamentTeams'));
    }

    public function update(Request $request, TournamentTeams $tournamentTeams){
        //
    }

    public function destroy(TournamentTeams $tournamentTeams){
        //
    }

    public function search(Request $request){

        $tournametTeams = TournamentTeams::select('teams.name', 'teams.slug','tournament_teams.id')
        ->join('teams', 'tournament_teams.team_id', '=', 'teams.id')
        ->where('tournament_teams.tournament_id', $request->input('tournament_id'));

        if ($request->input('search.value')) {
            $tournametTeams->where('teams.name', 'like', '%' . $request->input('search.value') . '%');
        }

        $countData = $tournametTeams->count();

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order.0.dir');

        $teams = $tournametTeams
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
