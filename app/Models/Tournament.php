<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function teams() {
        return $this->belongsToMany(Team::class);
    }

    public function games() {
        return $this->hasMany(Game::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
