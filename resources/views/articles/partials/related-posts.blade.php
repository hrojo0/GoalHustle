<section class="posts-blocks extra wow fadeInUp" data-wow-delay="0.4s">
    <header class="header">
        <h2>You might find interesting...</h2>
    </header>
    @foreach ($articlesRelated as $articleRelated)
    @if($article->id != $articleRelated->id)
    <div class="post-block single-post-block">
        <div class="post-holder">
            <div class="img-holder">
                <a href="{{ route('article.show', $articleRelated->slug) }}"><img alt="image description" src="{{ asset('storage/'.$articleRelated->image) }}"></a>
            </div>
            @php
                $date = Carbon\Carbon::parse($articleRelated->updated_at);
                $date->locale('es');
                $formattedDate = $date->translatedFormat('d \d\e F, Y');
            @endphp
            <time datetime=""><a href="#" style="cursor:default">{{ $formattedDate }}</a></time>
            <h2><a href="{{ route('article.show', $articleRelated->slug) }}">{{ $articleRelated->title }}</a></h2>
        </div>
    </div>
    @endif
    @endforeach
</section>