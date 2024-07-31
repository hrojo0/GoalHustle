@extends('adminlte::page')
@section('title', 'Edit Game')

@section('content_header')
    <h2>Edit game</h2>
@stop



@section('content')
@if (session('success-create'))
    <div class="alert alert-info">
        {{ session('failed-duplicate') }}
    </div>
@elseif (session('error-update'))
    <div class="alert alert-info">
        {{ session('error-update') }}
    </div>
@endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('games.update', $game->id) }}" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="form-group">
                    <label for="tournament">Select tournament</label>
                    <select class="form-control" name="tournament" id="tournament">                    
                        <option value="" id="tournament_first">Pick a tournament</option>
                        @foreach ($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ $game->tournament_id == $tournament->id ? 'selected' : '' }}>
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
                            <option value="{{ $team->id }}" 
                                {{ $game->home_team_id == $team->id ? 'selected' : '' }}>
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
                            <option value="{{ $team->id }}" {{ $game->away_team_id == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('away_team')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Matchday</label>
                    <input type="date" class="form-control" id="matchday" name='matchday' placeholder="Matchday" value="{{ $game->matchday }}" >
                    <x-input-error :messages="$errors->get('matchday')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label>Round</label>
                    <input type="number" class="form-control" id="round" name='round'
                        placeholder="Round"
                        value="{{ $game->round }}">
                    <x-input-error :messages="$errors->get('round')" class="mt-2 text-danger" />
                </div>

                @if ($allow_score)
                    <div class="form-group">
                        <label>Home team goals</label>
                        <input type="number" class="form-control" id="home_goals" name='home_goals'
                            placeholder="Home goals"
                            value="{{ $game->home_goals }}">
                        <x-input-error :messages="$errors->get('home_goals')" class="mt-2 text-danger" />
                    </div>
                    <div class="form-group">
                        <label>Away team goals</label>
                        <input type="number" class="form-control" id="away_goals" name='away_goals'
                            placeholder="Away goals"
                            value="{{ $game->away_goals }}">
                        <x-input-error :messages="$errors->get('away_goals')" class="mt-2 text-danger" />
                    </div>
                @endif
                

                <input type="submit" value="Save changes" class="btn btn-primary">
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        setTimeout(function(){
            $('.alert-info').fadeOut(); 
        }, 5000);
    });
</script>
@stop
