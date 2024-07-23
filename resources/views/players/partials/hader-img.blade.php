<section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

    <div class="uk-width-1-1 uk-row-first">
        <div class="uk-panel">
            <div class="uk-cover-background uk-position-relative head-wrap" style="height: 290px; background-image: url('../img/stadium-2.jpg'); display:flex; justify-content:center; align-items:center">
                <div class=" uk-flex uk-flex-center head-title">
                    <div class="uk-width-2-12 center">
                        <a href="{{ route('team.show', $player->team->slug) }}">
                        <img src="{{ $player->team->logo ? asset($player->team->logo) : asset('img/team.png') }}" class="img-polaroid" alt="{{ $player->photo }}"></a>                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--div class="tm-top-a-box tm-full-width tm-box-bg-1 ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1 uk-row-first">
                <div class="uk-panel">
                    <div class="uk-cover-background uk-position-relative head-match-wrap" style="height: 590px; background-image: url('../img/stadium-2.jpg');">
                        <img class="uk-invisible" src="{{ asset('img/stadium-2.jpg')}}" alt="">
                        <div class="uk-position-cover uk-flex-center head-news-title">
                            <div class="uk-width-2-12 center">
                                <a href="{{ route('team.show', $player->team->slug) }}">
                                <img src="{{ $player->team->logo ? asset($player->team->logo) : asset('img/team.png') }}" class="img-polaroid" alt="{{ $player->photo }}"></a>                                    
                            </div>
                            <h1>
                                {{ $player->team->name }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
    
</div-->