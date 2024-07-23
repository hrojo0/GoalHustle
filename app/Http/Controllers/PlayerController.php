<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Models\Article;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PlayerController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); //obtiene información del usuario loggeado
        $players = Player::orderBy('team_id', 'asc')
            ->orderBy('name','asc')
            ->paginate(30);

        return view('admin.players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::select('id', 'name')
                        ->orderBy('name')
                        ->get();
        return view('admin.players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerRequest $request)
    {
        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        //guardar solicitud de cliente
        $player = $request->all();

        //validar si hay un archivo, como un jpg, en el request
        if($request->hasFile('photo')){
            $player['photo'] = $request->file('photo')->store('players');
        }

        /*echo '<pre>';
        var_dump($article);
        echo '</pre>';
        exit;*/
        Player::create($player);

        return redirect()->action([PlayerController::class, 'index'])
        ->with('success-create', 'Player '.$request->name.' succesfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        $totalGoals = $player->statsPlayer()->sum('goals');

        $cardPlayers = Player::where('team_id', $player->team_id)
                        ->where('id', '!=', $player->id)
                        ->orderByRaw(
                            "CASE 
                                WHEN position = 'Goalkeeper' THEN 1 
                                WHEN position = 'Defense' THEN 2 
                                WHEN position = 'Midfielder' THEN 3 
                                WHEN position = 'Striker' THEN 4 
                                ELSE 5 
                            END")
                        ->get();
        
        return view('players.show', compact('player','totalGoals', 'cardPlayers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $this->authorize('view', $player);
        //Obtener categorías publicas
        $teams = Team::select('id', 'name')
                        ->orderBy('name')
                        ->get();
        return view('admin.players.edit', compact('teams', 'player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlayerRequest $request, Player $player)
    {
        $this->authorize('update', $player);
        //si usuario sube nueva imagen
        if($request->hasFile('photo')){//if para saber si ya existe una carpeta
            //Eliminar imagen anterior
            File::delete(public_path('storage/' . $player->photo));
        
            //Guarda nueva imagen
            $player['photo'] = $request->file('photo')->store('players');
        }

        //actualizar datos
        $player->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'number' => $request->number,
            'position' => $request->position,
            'team_id' => $request->team_id,
        ]);

        //redireccionar a articles index
        return redirect()->action([PlayerController::class, 'index'])
        ->with('success-update', 'Player '. $request->name .' succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $this->authorize('delete', $player);
        //eliminar la imagen del articulo
        if($player->photo){
            File::delete(public_path('storage/' . $player->photo));
        }

        //Eliminar el artículo
        $player->delete();
        return redirect()->action([PlayerController::class, 'index'], compact('player'))
        ->with('success-delete', 'Player '.$player->name.' deleted');
    }

    public function search(Request $request){
        $columns = ['name', 'team.name', 'number', 'position',];

        //Player::with('team') = Player::with('team');

        if ($request->input('search.value')) {
            Player::with('team')->where('name', 'like', '%' . $request->input('search.value') . '%');
        }

        $countData = Player::with('team')->count();

        $orderColumnIndex = $request->input('order.0.column');
        //$orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderColumn = $columns[$orderColumnIndex];
        $orderDir = $request->input('order.0.dir');

        if ($orderColumn == 'team.name') {
            Player::with('team')->join('teams', 'players.team_id', '=', 'teams.id')
                  ->orderBy('teams.name', $orderDir);
        } else {
            Player::with('team')->orderBy($orderColumn, $orderDir);
        }

        $players = Player::with('team')->offset($request->input('start'))
            ->limit($request->input('length'))
            //->orderBy($orderColumn, $orderDir)
            ->get(['players.*']);
        /*$players = Player::with('team')->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy('name', 'asc')
            ->get();*/

        $data = [];
        foreach ($players as $player) {
            $data[] = [
                'name' => $player->name,
                'team' => $player->team->name,
                'number' => $player->number,
                'position' => $player->position,
                'id' => $player->id,
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
