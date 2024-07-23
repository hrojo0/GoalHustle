<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatsPlayer extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function player(){
        return $this->belongsTo(Players::class);
    }
    public function getRouteKeyName()
    {
        return 'player_id';
    }
}
