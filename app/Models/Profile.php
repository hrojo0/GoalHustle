<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'user_id', 'created_at', 'updated_at'];

    //Relación de uno a uno inversa (profile-user)
    public function user(){
        return $this->belongsTo(User::class);
    }
}
