<div class="tm-sidebar-a uk-width-medium-2-4 uk-row-first">
    <section class="widget recent-posts-widget version-ii">
        <header class="tab-head wow fadeInUp">
            <h3><a class="active" href="#tab1">Table</a></h3>
            <h3><a href="#tab2">Stats</a></h3>
        </header>
        <div class="tab-content">
            <div id="tab1">
                <table class="table table-striped">
                    <thead class=" wow fadeInUp">
                        <tr>
                            <th>Club</th>
                            <th>P</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>GD</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamStats as $team)
                            <tr  class=" wow fadeInUp">
                                <td>
                                    <a href="{{ route('team.show', $team->slug) }}">
                                    <x-bladewind::avatar image="{{ $team->logo ? asset('storage/'.$team->logo) : asset('img/team.png') }}"
                                    size="small" /> 
                                    {{ $team->name }}</a>
                                </td>
                                <td>{{ $team->total_games }}</td>
                                <td>{{ $team->total_goals }}</td>
                                <td>{{ $team->total_goals_conceded }}</td>
                                <td>{{ $team->total_goals-$team->total_goals_conceded }}</td>
                                <td>{{ $team->total_wins }}</td>
                                <td>{{ $team->total_draws }}</td>
                                <td>{{ $team->total_loses }}</td>
                                <td><strong>{{ $team->total_points }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="tab2">
                <div class="uk-accordion" data-uk-accordion="">
                    <h4 class="uk-accordion-title ">Strikers<span class="arrow"><i class="uk-icon-arrow-right"></i></span></h4>
                    <div aria-expanded="true" data-wrapper="true" role="list">
                        <div class="uk-accordion-content uk-active">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Club</th>
                                        <th>Goals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topScorers as $player)
                                        <tr>
                                            <td>
                                                <a href="{{ route('player.show', $player->id)}}">
                                                    <x-bladewind::avatar image="{{ $player->photo ? asset('storage/'.$player->photo) : asset('img/user-default.png') }}"
                                                    size="small" /> 
                                                    {{ $player->name }}
                                                </a>
                                            </td>
                                            <td>{{ $player->team_name }}</td>
                                            <td>{{ $player->total_goals }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="uk-accordion" data-uk-accordion="">
                    <h4 class="uk-accordion-title uk-active">Assisters<span class="arrow"><i class="uk-icon-arrow-right"></i></span></h4>
                    <div aria-expanded="true" data-wrapper="true" role="list">
                        <div class="uk-accordion-content uk-active">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Club</th>
                                        <th>Assits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topAssisters as $player)
                                        <tr>
                                            <td>
                                                <a href="{{ route('player.show', $player->id)}}">
                                                <x-bladewind::avatar image="{{ $player->photo ? asset('storage/'.$player->photo) : asset('img/user-default.png') }}"
                                                size="small" /> 
                                                {{ $player->name }}
                                                </a>
                                            </td>
                                            <td>{{ $player->team_name }}</td>
                                            <td>{{ $player->total_assists }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>



                <div class="uk-accordion" data-uk-accordion="">
                    <h4 class="uk-accordion-title uk-active">Yellow Cards<span class="arrow"><i class="uk-icon-arrow-right"></i></span></h4>
                    <div aria-expanded="true" data-wrapper="true" role="list">
                        <div class="uk-accordion-content uk-active">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Club</th>
                                        <th>Cards</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topYellowCards as $player)
                                        <tr>
                                            <td>
                                                <a href="{{ route('player.show', $player->id)}}">
                                                <x-bladewind::avatar image="{{ $player->photo ? asset('storage/'.$player->photo) : asset('img/user-default.png') }}"
                                                size="small" /> 
                                                {{ $player->name }}
                                                </a>
                                            </td>
                                            <td>{{ $player->team_name }}</td>
                                            <td>{{ $player->total_yellow_cards }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="uk-accordion" data-uk-accordion="">
                    <h4 class="uk-accordion-title uk-active">Red Cards<span class="arrow"><i class="uk-icon-arrow-right"></i></span></h4>
                    <div aria-expanded="true" data-wrapper="true" role="list">
                        <div class="uk-accordion-content uk-active">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Club</th>
                                        <th>Cards</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topRedCards as $player)
                                        <tr>
                                            <td>
                                                <a href="{{ route('player.show', $player->id)}}">
                                                <x-bladewind::avatar image="{{ $player->photo ? asset('storage/'.$player->photo) : asset('img/user-default.png') }}"
                                                size="small" /> 
                                                {{ $player->name }}
                                                </a>
                                            </td>
                                            <td>{{ $player->team_name }}</td>
                                            <td>{{ $player->total_red_cards }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>