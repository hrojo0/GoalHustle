@extends('adminlte::page')
@section('title', 'Add Player')

@section('content_header')
    <h2>Add new player</h2>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('players.store') }}" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name='name'
                        placeholder="Player's full name" minlength="5" maxlength="100" 
                        value="{{ old('name') }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name='birthdate' placeholder="Player birthdate" value="{{ old('birthdate') }}" >
                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Upload player's photo</label>
                    <input type="file" class="form-control-file" id="photo" name='photo'>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Number</label>
                    <input type="number" class="form-control" id="number" name='number' placeholder="Player's number" value="{{ old('number') }}" >
                    <x-input-error :messages="$errors->get('number')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
    
                    <select class="form-control" name="position" id="position">                    
                        <option>Pick a position</option>
                        <option value="Goalkeeper" {{ old('position') == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                        <option value="Defense" {{ old('position') == 'Defense' ? 'selected' : '' }}>Defense</option>
                        <option value="Midfielder" {{ old('position') == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                        <option value="Striker" {{ old('position') == 'Striker' ? 'selected' : '' }}>Striker</option>
                        
                    </select>
    
                    <x-input-error :messages="$errors->get('position')" class="mt-2 text-danger" />
                </div>


                <div class="form-group">
                    <label for="position">Team</label>
                    <select class="form-control" name="team_id" id="team_id">
                        <option>Pick a team</option>
                        
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('team_id')" class="mt-2 text-danger" />
                </div>

                <input type="submit" value="Save palyer" class="btn btn-primary">
            </form>
        </div>
    </div>
@stop
