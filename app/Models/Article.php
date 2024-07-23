<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Releación uno a uno inversa article-user
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación uno a muchos -> article-comment
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //Releación uno a uno inversa category-article
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Utilizar slug en lugar de id
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
