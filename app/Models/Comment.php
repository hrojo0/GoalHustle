<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Releación uno a uno inversa comment-user
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Releación uno a uno inversa comment-article
    public function article(){
        return $this->belongsTo(Article::class);
    }
}
