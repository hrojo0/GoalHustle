@extends('adminlte::page')

@section('title', 'Edit stats player')

@section('content_header')
    <h2>Edit Stats Player</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('stats_player.update', $statsPlayer) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" value="{{ $statsPlayer->id }}"></div>

            <div class="form-group">
                <label for="">{{ $statsPlayer->player->name }}</label>
            </div>

            <div class="form-group">
                <label for="">{{ $statsPlayer->player->team->name }}</label>
            </div>

            <div class="form-group">
                <label for="">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name='birthdate' placeholder="Player birthdate" value="{{ $player->birthdate }}" >

                <x-input-error :messages="$errors->get('birthdate')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label>Change photo</label>
                <input type="file" class="form-control-file mb-2" id="photo" name='photo'>

                <div class="rounded mx-auto d-block">
                    @if($player->photo)
                        <img src="{{ asset('storage/'.$player->photo) }}" style="width: 250px">
                    @else
                     <p>Player doesn't have a profile photo</p>
                    @endif
                </div>

                <x-input-error :messages="$errors->get('photo')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="number">Number</label>
                <input type="number" class="form-control" id="number" name='number' placeholder="Player number" value="{{ $player->number }}">

                <x-input-error :messages="$errors->get('number')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="position">Position</label>

                <select class="form-control" name="position" id="position">                    
                    <option value="Goalkeeper" {{ $player->position == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                    <option value="Defense" {{ $player->position == 'Defense' ? 'selected' : '' }}>Defense</option>
                    <option value="Midfielder" {{ $player->position == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                    <option value="Striker" {{ $player->position == 'Striker' ? 'selected' : '' }}>Striker</option>
                    
                </select>

                <x-input-error :messages="$errors->get('position')" class="mt-2 text-danger" />
            </div>
            
            <div class="form-group">
                <label for="team_id">Pick a team</label>
                <select class="form-control" name="team_id" id="team_id">                    
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ $player->team_id == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                    
                </select>

                
                <x-input-error :messages="$errors->get('team_id')" class="mt-2 text-danger" />
                
            </div>

            <input type="submit" value="Guardar cambios" class="btn btn-primary">    
        </form>

    </div>
</div>
@endsection