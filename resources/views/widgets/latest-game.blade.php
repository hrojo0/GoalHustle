<div>
    <div class="latest-date">
        @php
            $matchday = Carbon\Carbon::parse($latestGame->matchday)->locale('es');
        @endphp
        <div class="date">
            {{ $matchday->isoFormat('LL') }}
         </div>
    </div>
    <div class="va-latest-middle uk-flex uk-flex-middle">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-2-12 center">
                    <a href="{{ route('team.show', $latestGame->homeTeam->slug) }}">
                        <img src="{{ $latestGame->homeTeam->logo ? asset('storage/'.$latestGame->homeTeam->logo) : asset('img/team.png') }}" class="img-polaroid" alt="" title="">
                    </a>
                </div>
                <div class="uk-width-3-12 name uk-vertical-align">
                    <div class="wrap uk-vertical-align-middle">
                        <a href="{{ route('team.show', $latestGame->homeTeam->slug) }}">
                        {{ $latestGame->homeTeam->name }} </a></div>
                </div>
                <div class="uk-width-2-12 score">
                    <div class="title">Marcador</div>
                    <div class="table">
                        <div class="left"> {{ $latestGame->home_goals }}</div>
                        <div class="right"> {{ $latestGame->away_goals }}</div>
                        <div class="uk-clearfix"></div>
                    </div>
                </div>
                <div class="uk-width-3-12 name alt uk-vertical-align">
                    <div class="wrap uk-vertical-align-middle">
                        <a href="{{ route('team.show', $latestGame->awayTeam->slug) }}">
                        {{ $latestGame->awayTeam->name }} </a></div>
                </div>
                <div class="uk-width-2-12 center">
                    <a href="{{ route('team.show', $latestGame->awayTeam->slug) }}">
                    <img src="{{ $latestGame->awayTeam->logo ? asset('storage/'.$latestGame->awayTeam->logo) : asset('img/team.png') }}" class="img-polaroid" alt="" title="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-container uk-container-center">
        <div class="va-latest-bottom">

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <div class="btn-wrap uk-container-center">
                        <a class="read-more" href="{{ route('tournaments.show', $latestGame->tournament->slug) }}">More results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>