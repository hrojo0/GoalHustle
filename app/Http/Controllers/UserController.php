<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lista de los usuarios
        $users = User::orderBy('id', 'asc')->simplePaginate(10); 

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //Recueprar listado de roles
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //Llenar la tabla indermedia
        $user->roles()->sync($request->role);

        //redirect se utiliza para que dirija al mismo formulario
        return redirect()->route('users.edit', $user)->with('success-update', 'The user '.$user->name.' now is '.$request->role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //Elimina el rol
        $user->delete();
        return redirect()->action([UserController::class, 'index'])->with('success-delete', 'Usuario eliminado con éxito');
    }
}
