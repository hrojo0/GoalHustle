<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function players()
    {
        return $this->hasManyThrough(
            Player::class,
            StatsPlayer::class,
            'game_id', // Foreign key on StatsPlayer table...
            'id', // Foreign key on Player table...
            'id', // Local key on Game table...
            'player_id' // Local key on StatsPlayer table...
        );
    }

}
