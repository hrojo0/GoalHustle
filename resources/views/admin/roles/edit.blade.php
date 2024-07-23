@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Edit Rol</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name='name'
                        placeholder="Nombre del rol" value="{{ $role->name }}">

                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />

            </div>
            <h3>Permissions list</h3>

            @foreach ($permissions as $permission)
                <div>
                    <label>
                        <input type="checkbox" name="permissions[]" id="" value="{{ $permission->id }}" {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}} class="mr-1">
                        {{ $permission->description }}
                    </label>
                </div>
            @endforeach

            <div>
                <label>
                    <input type="checkbox" name="permissions[]" id="" value="" 
                    class="mr-1">
                   
                </label>
            </div>

            <input type="submit" value="Save changes" class="btn btn-primary">
        </form>
    </div>
</div>

@endsection
