@extends('adminlte::page')
@section('title', 'Add Game')

@section('content_header')
    <h2>Add new game</h2>
@stop


@section('content')
@if (session('failed-duplicate'))
    <div class="alert alert-info">
        {{ session('failed-duplicate') }}
    </div>

@endif
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
                @csrf 
                
                <div class="form-group">
                    <label for="tournament">Select tournament</label>
                    <select class="form-control" name="tournament" id="tournament">                    
                        <option value="" id="tournament_first">Pick a tournament</option>
                        @foreach ($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ old('tournament') == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}

                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tournament')" class="mt-2 text-danger" />
                </div>
             
                <div class="form-group">
                    <label for="tournament">Select home team</label>
                    <select class="form-control" name="home_team" id="home_team">                    
                        <option value="" id="team_first">Pick a team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ old('home_team') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('home_team')" class="mt-2 text-danger" />
                </div>
             
                <div class="form-group">
                    <label for="tournament">Select away team</label>
                    <select class="form-control" name="away_team" id="away_team">                    
                        <option value="" id="team_first">Pick a team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ old('away_team') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('away_team')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Matchday</label>
                    <input type="date" class="form-control" id="matchday" name='matchday' placeholder="Matchday" value="{{ old('matchday') }}" >
                    <x-input-error :messages="$errors->get('matchday')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label>Round</label>
                    <input type="number" class="form-control" id="round" name='round'
                        placeholder="Round"
                        value="{{ old('round') }}">


                    <x-input-error :messages="$errors->get('round')" class="mt-2 text-danger" />

                </div>

                <input type="submit" value="Save game" class="btn btn-primary">
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        setTimeout(function(){
            $('.alert-info').fadeOut(); 
        }, 10000);
    });
</script>
@stop