<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Team $team)
    {
        return $user->hasRole('Administrator');
    }

    public function create(User $user)
    {
        return $user->hasRole('Administrator');
    }

    public function update(User $user, Team $team)
    {
        return $user->hasRole('Administrator');
    }

    public function delete(User $user, Team $team)
    {
        return $user->hasRole('Administrator');
    }

    public function restore(User $user, Team $team)
    {
        //
    }

    public function forceDelete(User $user, Team $team)
    {
        //
    }
}
