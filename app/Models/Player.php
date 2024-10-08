<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function statsPlayer()
    {
        return $this->hasMany(StatsPlayer::class);
    }

    public function statsForGame($gameId)
    {
        return $this->statsPlayer->firstWhere('game_id', $gameId);
    }
    public function getRouteKeyName()
    {
        return 'id';
    }

}
