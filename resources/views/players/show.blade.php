@section('title', 'Torneos de futbol')
@section('styles')
    <link href="{{ asset('css/tournament.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/t/jquery.js')}}"></script>    
    <script type="text/javascript" src="{{ asset('js/t/isotope.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/t/theme.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/t/uikit.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/c/slider.js')}}"></script>
@endsection
<x-app-layout>
    <div id="wrapper">
        <main id="main" role="main">
            <!-- Container of the page -->
            @include('players.partials.hader-img')
            <article class="player-single tt-players-page" style="margin-top: 59px;">
                <div class="player-top">
                    <div class="background-wrapper"></div>
                        <div class="uk-container uk-container-center alt">
                            <div class="uk-grid">
                                <div class="uk-width-5-12">
                                    <div class="avatar">
                                        <img src="{{ $player->photo ? asset($player->photo) : asset('img/player-avatar.jpg') }}" class="img-polaroid" alt="{{ $player->photo }}" title="{{ $player->photo }}">                    
                                    </div>
                                </div>
                                <div class="uk-width-1-12">
                                    <div class="number">
                                        {{ $player->number }}
                                    </div>
                                </div>
                                <div class="uk-width-6-12">
                                    <div class="name">
                                        <h2>
                                            {{ $player->name }}
                                        </h2>
                                    </div>
                                    <div class="wrap">
                                        <ul class="info">
                                            <li><span>Team</span><span><a href="{{ route('team.show',$player->team->slug)}}">{{ $player->team->name }}</a></span></li>
                                            <li><span>Position</span><span>{{ $player->position }}</span></li>
                                            <li><span>Goals</span><span>{{ $player->statsPlayer()->sum('goals') }}</span></li>
                                            <li><span>Assists</span><span>{{ $player->statsPlayer()->sum('assists') }}</span></li>
                                            <li><span>Yellow Card</span><span>{{ $player->statsPlayer()->sum('yellow_cards') }}</span></li>
                                            <li><span>Red Cards</span><span>{{ $player->statsPlayer()->sum('red_card') }}</span></li>
                                            @php
                                                $age = Carbon\Carbon::parse($player->birthdate)->age;
                                            @endphp
                                            <li><span>Age</span><span>{{ $age }}</span></li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <div class="other-players-wrap">
                <div class="uk-container uk-container-center alt">
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <h3 class="other-post-title"><span>{{ $player->team->name }} </span>| Other players</h3>
                            <div dir="ltr" class="uk-slidenav-position player-slider" data-uk-slider="">
                                <div class="uk-slider-container">
                                    <div class="player-slider-btn">
                                        <a draggable="false" href="/" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
                                        <a draggable="false" href="/" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>
                                    </div>
                                    <ul class="uk-slider uk-grid uk-grid-width-1-4">
                                        @foreach ($cardPlayers as $cardPlayer)
                                            <li class="player-item">
                                                <div class="player-article">
                                                    <div class="wrapper">
                                                        <div class="img-wrap">
                                                            <div class="player-number">
                                                                <span>{{ $cardPlayer->number }}</span>
                                                            </div>
                                                            <div class="bio"><span><a draggable="false" href="{{ route('player.show', $cardPlayer->id) }}">Bio</a></span></div>
                                                            <a draggable="false" href="{{ route('player.show', $cardPlayer->id) }}">
                                                            <img draggable="false" src="{{ $cardPlayer->photo ? asset($cardPlayer->photo) : asset('img/player-avatar.jpg') }}" class="img-polaroid" alt="{{ $cardPlayer->name }}" title="{{ $cardPlayer->name }}"></a>
                                                        </div>
                                                        <div class="info">
                                                            <div class="name">
                                                                <h3>
                                                                    <a draggable="false" href="{{ route('player.show', $cardPlayer->id) }}">{{ $cardPlayer->name }}</a>
                                                                </h3>
                                                            </div>
                                                            <div class="position">{{ $cardPlayer->position }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>