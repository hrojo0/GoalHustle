<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\StatsPlayer;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class StatsPlayerController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(StatsPlayer $statsPlayer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatsPlayer $statsPlayer)
    {
        $this->authorize('view', $statsPlayer);
        //Obtener categorías publicas
        $teams = Team::select('id', 'name')
            ->orderBy('name')
            ->get();
        $player = Player::where('player_id', $statsPlayer->id);
        return view('admin.stats_player.edit', compact('teams', 'statsPlayer','player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatsPlayer $statsPlayer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatsPlayer $statsPlayer)
    {
        //
    }
}
