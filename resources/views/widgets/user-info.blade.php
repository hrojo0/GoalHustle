<div class="widget widget-block wow fadeInUp" data-wow-delay="0.4s">
    <div class="alignleft">
        <a href="{{ route('profile.show', $article->user->id) }}"><img src="{{ $article->user->profile->photo ? asset($article->user->profile->photo) : asset('img/user-default.png') }}" alt=""></a>
    </div>
    <div class="text-holder">
        <header>
            <h2><a href="{{ route('profile.show', $article->user->id) }}">{{ $article->user->name }}</a></h2>
            <span class="subtitle"><a href="{{ $article->user->profile->website }}">{{ $article->user->profile->website }}</a></span>
        </header>
        <p>{{ $article->user->profile->about }}</p>
        <!-- Social Network of the page -->
        <ul class="social-networks">
            <li><a href="{{ $article->user->profile->facebook }}"><span class="ico-facebook"></span></a></li>
            <li><a href="{{ $article->user->profile->twitter }}"><span class="ico-twitter"></span></a></li>
            <li><a href="{{ $article->user->profile->linkedin }}"><span class="ico-linkedin"></span></a></li>
        </ul>
        <!-- Social Network of the page end -->
    </div>
</div>