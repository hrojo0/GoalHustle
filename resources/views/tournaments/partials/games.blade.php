<div class="tm-main uk-width-medium-2-4">
    <main id="tm-content" class="tm-content">
        <div class="match-list-wrap">
            @foreach ($games as $game)
                @if(!$loop->first)
                    <div class="match-list-item version-ii wow fadeInUp">
                        <div class="date">
                            @php
                                $matchday = Carbon\Carbon::parse($game->matchday);
                                $matchday->locale('es');
                                $shortMonths = [
                                    1 => 'ENE', 2 => 'FEB', 3 => 'MAR', 4 => 'ABR',
                                    5 => 'MAY', 6 => 'JUN', 7 => 'JUL', 8 => 'AGO',
                                    9 => 'SEP', 10 => 'OCT', 11 => 'NOV', 12 => 'DIC'
                                ];
                            @endphp
                            <span>{{ $matchday->day }}</span>
                            {{ $shortMonths[$matchday->month]; }}
                        </div>
                    
                        <div class="logo">
                            <a href="{{ route('team.show', $game->homeTeam) }}">
                            <img src="{{ $game->homeTeam->logo ? asset($game->homeTeam->logo) : asset('img/team.png') }}" class="img-polaroid" ></a>                                     
                        </div>
                        <div class="team-name" >
                            <a href="{{ route('team.show', $game->homeTeam) }}" style="color: #fff">{{ $game->homeTeam->name }} </a>
                        </div>
                        <div class="team-score">
                            {{ $game->home_goals }}                    
                        </div>
                        <div class="score-separator">:</div>
                        <div class="team-score">
                            {{ $game->away_goals }}                    
                        </div>
                        <div class="team-name">
                            <a href="{{ route('team.show', $game->awayTeam) }}" style="color: #fff">
                            {{ $game->awayTeam->name }} </a>
                        </div>
                        <div class="logo">
                            <a href="{{ route('team.show', $game->awayTeam) }}">
                            <img src="{{ $game->awayTeam->logo ? asset($game->awayTeam->logo) : asset('img/team.png')}}" class="img-polaroid"></a>                                    
                        </div>
                    </div>
                @endif  
            @endforeach
        </div>
        
    </main>
</div>