@section('title')
Goal Hustle | {{$team->name}}
@endsection
@section('styles')
    <link href="{{ asset('css/tournament.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/t/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/t/isotope.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/t/theme.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/t/uikit.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/c/slider.js')}}"></script>
@endsection
<x-app-layout>
    <div id="wrapper">
        <main id="main" role="main">
            <!-- Container of the page -->
            <div class="container">

                <!-- header, scorer, assister -->
                <div class="uk-cover-background uk-position-relative row"
                    style="background-image: url('../img/stadium-2.jpg'); display:flex; justify-content:center; align-items:center">

                    <div class="col-6 uk-width-2-12 m-offset">
                        <img src="{{ $team->logo ? asset($team->logo) : asset('img/team.ong') }}" class="img-polaroid"
                            alt="{{ $team->name }}" title="{{ $team->name }}" class="img-polaroid" alt="">
                    </div>


                    <div class="ml-2">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="name">
                                            <h2 class="text-white fs-1">
                                                {{ $team->name }}
                                            </h2>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="max-content">
                                <tr>
                                    <td>
                                        <div class="uk-position-relative inline-flex">
                                            <div class="col-6">
                                                <a href="{{ route('player.show', $topScorer->player_id) }}">
                                                    <x-bladewind::avatar
                                                        image="{{ $topScorer->photo ? asset($topScorer->photo) : asset('img/player-avatar.jpg') }}"
                                                        size="big" />
                                                </a>
                                            </div>
                                            <div class="ml-10 col-xs-offset-1">
                                                <p class="m-0 text-blue-700">Striker</p>
                                                <a href="{{ route('player.show', $topScorer->player_id) }}">
                                                    <div class="m-0 text-3xl text-white inline-flex">
                                                        <p class="max-content">{{ $topScorer->name }}</p>
                                                        <p class="mx-1">{{ $topScorer->total_goals }}</p>
                                                        <p>
                                                            @if ($topScorer->total_goals > 1)
                                                                goals
                                                            @else
                                                                goal
                                                            @endif
                                                        </p>
                                                    </div>

                                                </a>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="mt-1">
                                    <td>
                                        <div class="uk-position-relative inline-flex">
                                            <div class="col-6">
                                                <a href="{{ route('player.show', $topAssister->player_id) }}">
                                                    <x-bladewind::avatar
                                                        image="{{ $topAssister->photo ? asset($topAssister->photo) : asset('img/player-avatar.jpg') }}"
                                                        size="big" />
                                                </a>
                                            </div>
                                            <div class="ml-10 col-xs-offset-1">
                                                <p class="m-0 text-blue-700">Assister</p>
                                                <a href="{{ route('player.show', $topAssister->player_id) }}">
                                                    <div class="m-0 text-3xl text-white inline-flex">
                                                        <p class="max-content">{{ $topAssister->name }}</p>
                                                        <p class="mx-1">{{ $topAssister->total_assists }}</p>
                                                        <p>
                                                            @if ($topAssister->total_assists > 1)
                                                                assists
                                                            @else
                                                                assist
                                                            @endif
                                                        </p>
                                                    </div>

                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- end header, scorer, assister -->

                <!-- next matches -->
                <div class="tm-top-e-box tm-full-width next-match-margin-top">
                    <div class="uk-container uk-container-center">
                        <section id="tm-top-e" class="tm-top-e uk-grid"
                            data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

                            <div class="uk-width-1-1">
                                <div class="uk-panel">
                                    <div class="uk-container uk-container-center">
                                        <div class="uk-grid uk-grid-collapse">
                                            <div class="uk-width-medium-1-2 uk-width-small-1-1 va-single-next-match">
                                                <div class="va-main-next-wrap">
                                                    <div class="main-next-match-title"><em>Next <span>Game</span></em>
                                                    </div>
                                                    <div class="match-list-single">
                                                        <div class="match-list-item">
                                                            
                                                            <div class="clear"></div>
                                                            <div class="logo">
                                                                @php
                                                                    $date = Carbon\Carbon::parse($nextMatches[0]->matchday);
                                                                    $date->locale('es');
                                                                    $formattedDate = $date->translatedFormat('d \d\e F, Y');
                                                                @endphp
                                                                <a href="match-single.html">
                                                                    <img src="{{ $nextMatches[0]->homeTeam->logo ? asset($nextMatches[0]->homeTeam->logo) : asset('img/team.png') }}" class="img-polaroid"
                                                                        alt="{{ $nextMatches[0]->homeTeam->name }}"
                                                                        title="{{ $nextMatches[0]->homeTeam->name }}">
                                                                </a>
                                                            </div>
                                                            <div class="team-name">{{ $nextMatches[0]->homeTeam->name }}</div>
                                                            <div class="versus">VS</div>

                                                            <div class="team-name">{{ $nextMatches[0]->awayTeam->name }}</div>
                                                            <div class="logo">
                                                                <a href="match-single.html">
                                                                    <img src="{{ $nextMatches[0]->awayTeam->logo ? asset($nextMatches[0]->awayTeam->logo) : asset('img/team.png') }}" class="img-polaroid"
                                                                        alt="{{ $nextMatches[0]->awayTeam->name }}"
                                                                        title="{{ $nextMatches[0]->awayTeam->name }}">
                                                                </a>
                                                            </div>
                                                            <div class="clear"></div>
                                                            <div class="date">{{ $formattedDate }}</div>
                                                            <div class="clear"></div>
                                                            <div class="location">
                                                                <a href="{{ route('tournaments.show', $nextMatches[0]->tournament->slug) }}">
                                                                    <address>{{ $nextMatches[0]->tournament->name }}<br><br></address>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="uk-width-medium-1-2 uk-width-small-1-1 va-list-next-match">
                                                <div class="match-list-wrap">
                                                    @foreach ($nextMatches as $nextMatch)
                                                        @if(!$loop->first)
                                                        @php
                                                            $date = Carbon\Carbon::parse($nextMatch->matchday);
                                                            $date->locale('es');
                                                            $formattedDate = $date->translatedFormat('d \d\e F, Y');
                                                        @endphp
                                                        <div class="match-list-item alt">
                                                            <div class="date">{{ $formattedDate }}</div>
                                                            <div class="wrapper">
                                                                <div class="logo logo-next-match">
                                                                    <a href="{{ route('team.show', $nextMatch->homeTeam->slug) }}">
                                                                        <img src="{{ $nextMatch->homeTeam->logo ? asset($nextMatch->homeTeam->logo) : asset('img/team.png') }}" class="img-polaroid"
                                                                            alt="{{ $nextMatch->homeTeam->name }}"
                                                                            title="{{ $nextMatch->homeTeam->name }}">
                                                                    </a>
                                                                </div>
                                                                
                                                                <div class="team-name">{{ $nextMatch->homeTeam->name }}</div>
                                                                <div class="versus">VS</div>

                                                                <div class="team-name">{{ $nextMatch->awayTeam->name }}</div>
                                                                <div class="logo logo-next-match">
                                                                    <a href="{{ route('team.show', $nextMatch->awayTeam->slug) }}">
                                                                        <img src="{{ $nextMatch->awayTeam->logo ? asset($nextMatch->awayTeam->logo) : asset('img/team.png') }}" class="img-polaroid"
                                                                            alt="{{ $nextMatch->awayTeam->name }}"
                                                                            title="{{ $nextMatch->awayTeam->name }}">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- end next matches -->

                <!-- tournaments registered -->
                <section id="tm-bottom-a" class="tm-bottom-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
                    <div class="uk-width-1-1">
                        <div class="uk-width-medium-1-1 achievments-block">
                            <div class="our-awards-main-wrap">
                                <div class="uk-slidenav-position our-awards" data-uk-slider="{autoplay:true, autoplayInterval:7000}">
                                    <div class="our-awards-main-title">
                                        <h2>Tournaments <span></span></h2>
                                        <div class="our-awards-btn">
                                            <a draggable="false" href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                                            <a draggable="false" href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                                        </div>
                                    </div>
                                    <div class="uk-slider-container">
                                        <ul class="uk-slider uk-grid uk-grid-width-large-1-2">
                                            @foreach ($teamTournaments as $teamTournament)
                                                <li class="flex items-center flex-col">
                                                    <div class="img-wrap uk-width-4-12 m-offset">
                                                        <a href="{{ route('tournaments.show', $teamTournament->tournament->slug ) }}">
                                                            <img draggable="false" src="{{ $teamTournament->tournament->logo ? asset($teamTournament->tournament->logo) : asset('img/tournament.png') }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="text">
                                                        <a href="{{ route('tournaments.show', $teamTournament->tournament->slug ) }}">
                                                        <h3>{{ $teamTournament->tournament->name }}</h3>
                                                        </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- end tournaments registered -->

                <!-- list of players -->
                <div class="list-players-wrapper">
                    <div class="uk-sticky-placeholder">
                        <div class="button-group filter-button-group" data-uk-sticky="{top:70, boundary: true}">
                            <div class="uk-container uk-container-center">
                                <div class="label-menu">Players</div>
                                <button class="active" data-filter="*">All
                                </button>
                                <button data-filter=".tt_81747b4426a9882884c1f83eda78844f">Goalkeepers
                                </button>
                                <button data-filter=".tt_2a195f12da9f3f36da06e6097be7e451">Defenders
                                </button>
                                <button data-filter=".tt_4d957768dcc72908ab3b9e28dc867052">Midfielders
                                </button>
                                <button data-filter=".tt_22c19cd174143e3b4c7ef40ae23c5d1a">Strikers
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="list-players-wrap" id="boundary">
                        <div class="uk-container uk-container-center alt">
                            <div class="uk-grid grid1 players-list">

                                @foreach ($players as $player)
                                    @switch($player->position)
                                        @case('Goalkeeper')
                                            @php
                                                $data_filter = 'tt_81747b4426a9882884c1f83eda78844f';
                                            @endphp
                                        @break

                                        @case('Defense')
                                            @php
                                                $data_filter = 'tt_2a195f12da9f3f36da06e6097be7e451';
                                            @endphp
                                        @break

                                        @case('Midfielder')
                                            @php
                                                $data_filter = 'tt_4d957768dcc72908ab3b9e28dc867052';
                                            @endphp
                                        @break

                                        @case('Striker')
                                            @php
                                                $data_filter = 'tt_22c19cd174143e3b4c7ef40ae23c5d1a';
                                            @endphp
                                        @break
                                    @endswitch

                                    <div
                                        class="uk-width-large-1-4 uk-width-medium-1-2 uk-width-small-1-2 player-item {{ $data_filter }}">
                                        <div class="player-article">
                                            <div class="wrapper">
                                                <div class="img-wrap">
                                                    <div class="player-number">
                                                        <span>
                                                            {{ $player->number }}
                                                        </span>
                                                    </div>
                                                    <div class="bio">
                                                        <span>
                                                            <a href="{{ route('player.show', $player->id) }}">bio
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <a href="{{ route('player.show', $player->id) }}">
                                                        <img src="{{ $player->photo ? asset($player->photo) : asset('img/player-avatar.jpg') }}"
                                                            class="img-polaroid" alt="{{ $player->name }}"
                                                            title="{{ $player->name }}">
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <div class="name">
                                                        <h3>
                                                            <a href="{{ route('player.show', $player->id) }}">
                                                                {{ $player->name }}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                    <div class="position">
                                                        {{ $player->position }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end list of players -->








            </div>
        </main>
    </div>
</x-app-layout>
