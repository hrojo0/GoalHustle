@extends('adminlte::page')
@section('title', 'Edit Game')

@section('content_header')
    <h2>Edit Game</h2>
@stop

@section('content')
    @if (session('error-update'))
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
                    <label for="tournament">Select Tournament</label>
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
                    <label for="">Matchday</label>
                    <input type="date" class="form-control" id="matchday" name='matchday' placeholder="Matchday" value="{{ $game->matchday }}">
                    <x-input-error :messages="$errors->get('matchday')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label>Round</label>
                    <input type="number" class="form-control" id="round" name='round' placeholder="Round" value="{{ $game->round }}">
                    <x-input-error :messages="$errors->get('round')" class="mt-2 text-danger" />
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
                @if ($allow_stats)
                    <div class="nav-tabs-custom">
                        <label>Fill the stats for each team</label>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home-team" data-toggle="tab">Home Team </a></li>
                            <li style="margin-left: 1rem"><a href="#away-team" data-toggle="tab"> Away Team</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-team">
                                <h4 id="home-team-name">{{ $game->awayTeam->name }}</h4>
                                <div class="form-group">
                                    <label>Home Team Goals</label>
                                    <input type="number" class="form-control" id="home_goals" name='home_goals' placeholder="Home goals" value="{{ $game->home_goals }}">
                                    <x-input-error :messages="$errors->get('home_goals')" class="mt-2 text-danger" />
                                </div>
                                <h5>Players stats</h5>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Player</th>
                                            <th>Goals</th>
                                            <th>Assists</th>
                                            <th>Yellow Cards</th>
                                            <th>Red Cards</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($home_team_players as $player)
                                            @php
                                                $playerStats = $player->statsForGame($game->id);
                                            @endphp
                                            <tr>
                                                <td><h6>{{ $player->name }}</h6></td>
                                                <td><input placeholder="Goals" type="number" class="form-control" name="player_stats[{{ $player->id }}][goals]" value="{{ $playerStats->goals }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][assists]" value="{{ $playerStats->assists ?? 0 }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][yellow_cards]" value="{{ $playerStats->yellow_cards ?? 0 }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][red_card]" value="{{ $playerStats->red_card ?? 0 }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane " id="away-team">
                                <h4 id="away-team-name">{{ $game->awayTeam->name }}</h4>
                                <div class="form-group">
                                    <label>Away Team Goals</label>
                                    <input type="number" class="form-control" id="away_goals" name='away_goals' placeholder="Away goals" value="{{ $game->away_goals }}">
                                    <x-input-error :messages="$errors->get('away_goals')" class="mt-2 text-danger" />
                                </div>
                                <h5>Players stats</h5>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Player</th>
                                            <th>Goals</th>
                                            <th>Assists</th>
                                            <th>Yellow Cards</th>
                                            <th>Red Cards</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($away_team_players as $player)
                                            @php
                                                $playerStats = $player->statsForGame($game->id);
                                            @endphp
                                            <tr>
                                                <td><h6>{{ $player->name }}</h6></td>
                                                <td><input placeholder="Goals" type="number" class="form-control" name="player_stats[{{ $player->id }}][goals]" value="{{ $playerStats->goals ?? 0 }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][assists]" value="{{ $playerStats->assists ?? 0 }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][yellow_cards]" value="{{ $playerStats->yellow_cards ?? 0 }}"></td>
                                                <td><input type="number" class="form-control" name="player_stats[{{ $player->id }}][red_card]" value="{{ $playerStats->red_card ?? 0 }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @endif
            
                <input type="submit" value="Save Changes" class="btn btn-primary">
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
        $('#home_team').on('change', function () {
            var home_team = $( "#home_team option:selected" ).text();
            $('#home-team-name').text(home_team);
        });
        $('#away_team').on('change', function () {
            var away_team = $( "#away_team option:selected" ).text();
            $('#away-team-name').text(away_team);
        });
    });
</script>
@stop
    