<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function tournaments() {
        return $this->belongsToMany(Tournament::class);
    }

    public function players() {
        return $this->hasMany(Players::class);
    }

    public function homeGames() {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames() {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
