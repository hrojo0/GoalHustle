<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeams extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }

    public function getRouteKeyName()
    {
        return 'tournament_id';
    }
}
