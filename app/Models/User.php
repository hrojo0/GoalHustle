<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    //Crear perfil de usuario
    protected static function boot(){
        parent::boot();
        //asignar perfil al registrar usuario
        static::created(function($user){
            //$user->profile()->create();
            $user->profile()->save(Profile::factory()->make());
        });
    }

    //Relación uno a uno -> user-profile
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //Relación uno a muchos -> user-articles
    public function articles(){
        return $this->hasMany(Article::class);
    }

    //Relación uno a muchos -> user-comment
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function adminlte_image(){
        //esto realizará ruta storage/[IMAGEN]
        //return asset(Auth::user()->profile->photo);
        return asset(Auth::user()->profile->photo ? Auth::user()->profile->photo : 'img/user-default.png');
    }
}
