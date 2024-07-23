<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryPolicy
{
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category)
    {
        //Revisar si el usuario loggeado es el mismo que creó la categoría
        //return $user->id == $category->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category)
    {
        //revisar si el usuario loggeado fue el mismo que creo la categoría
        //return $user->id == $category->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category)
    {
        //revisar si el usuario loggeado le pertenece el articulo la categoría
        //return $user->id == $category->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }

    public function published(?User $user, Category $category)
    {
        /*if($article->status == 1){
            return true;
        } else {
            false;
        }*/
        return $category->status == 1;
    }
}
