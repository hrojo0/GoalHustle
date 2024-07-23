<div class="tm-top-a-box tm-full-width tm-box-bg-1 ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1 uk-row-first">
                <div class="uk-panel">
                    <div class="uk-cover-background uk-position-relative head-match-wrap" style="height: 590px; background-image: url('../img/stadium-2.jpg');">
                        <img class="uk-invisible" src="{{ asset('img/stadium-2.jpg')}}" alt="">
                        <div class="uk-position-cover uk-flex-center head-news-title">
                            <h1>
                                Last Game
                            </h1>
                            <div class="clear"></div>
                            <div class="va-latest-wrap">
                                <div class="va-latest-middle uk-flex uk-flex-middle">
                                    <div class="uk-container uk-container-center">
                                        <div class="uk-grid uk-flex uk-flex-middle">
                                            <div class="uk-width-2-12 center">
                                                <a href="{{ route('team.show', $games[0]->homeTeam) }}">
                                                <img src="{{ $games[0]->homeTeam->logo ? asset($games[0]->homeTeam->logo) : asset('img/team.png') }}" ></a>                                    
                                            </div>
                                            <div class="uk-width-3-12 name uk-vertical-align">
                                                <div class="wrap uk-vertical-align-middle">
                                                    <a href="{{ route('team.show', $games[0]->homeTeam) }}" style="color: #fff">
                                                    {{ $games[0]->homeTeam->name }}</a>
                                                </div>
                                            </div>
                                            <div class="uk-width-2-12 score">
                                                <div class="title">Score</div>
                                                <div class="table">
                                                    <div class="left">{{ $games[0]->home_goals }}</div>
                                                    <div class="right">{{ $games[0]->away_goals }}</div>
                                                    <div class="uk-clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="uk-width-3-12 name alt uk-vertical-align">
                                                <div class="wrap uk-vertical-align-middle">
                                                    <a href="{{ route('team.show', $games[0]->awayTeam) }}" style="color: #fff">
                                                    {{ $games[0]->awayTeam->name }} </a>
                                                </div>
                                            </div>
                                            <div class="uk-width-2-12 center">
                                                <a href="{{ route('team.show', $games[0]->awayTeam) }}">
                                                <img src="{{$games[0]->awayTeam->logo ? asset($games[0]->awayTeam->logo) : asset('img/team.png')}}" class="img-polaroid" ></a>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-container uk-container-center">
                                    <div class="va-latest-bottom">
                                        <div class="uk-grid">
                                            <div class="uk-width-1-1">
                                                <div class="btn-wrap uk-container-center">
                                                    @php
                                                        $matchday = Carbon\Carbon::parse($games[0]->matchday);
                                                        $matchday->locale('es');
                                                        $shortMonths = [
                                                            1 => 'ENE', 2 => 'FEB', 3 => 'MAR', 4 => 'ABR',
                                                            5 => 'MAY', 6 => 'JUN', 7 => 'JUL', 8 => 'AGO',
                                                            9 => 'SEP', 10 => 'OCT', 11 => 'NOV', 12 => 'DIC'
                                                        ];
                                                    @endphp
                                                    <h1>{{ $matchday->day.' '.$shortMonths[$matchday->month]; }}</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
    
</div>