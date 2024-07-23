<div class="post-block single-post wow fadeInUp" data-wow-delay="0.4s">
    <div class="post-holder">
        <div class="img-holder">
            <img src="{{ asset('storage/'.$article->image) }}" alt="image description">
        </div>
        @php
            $date = Carbon\Carbon::parse($article->updated_at);
            $date->locale('es');
            $formattedDate = $date->translatedFormat('d \d\e F, Y');
        @endphp
        <time datetime=""><a href="#" style="cursor:default">{{ $formattedDate }}</a></time>
        <h2>{{ $article->title }}</h2>
        <blockquote>
            <p>{{ $article->introduction }}</p>
        </blockquote>
        <p>{!! $article->body !!}</p>
        <footer>
            <strong class="text"><span class="icon ico-user"></span><a href="{{ route('profile.show', $article->user->id) }}">{{ $article->user->name }}</a></strong>
            <strong class="text comment-count"><span class="icon ico-comment"></span><a href="#commentlist">{{ $totalComments }} comments</a></strong>
            <!--strong class="text"><span class="icon ico-tag"></span>Tag: <a href="#">travel.</a> <a href="#">life</a>, <a href="#">enjoy</a></strong>
            <strong class="text share-count"><span class="icon ico-share"></span><a href="#">138 shares</a></strong-->
        </footer>
    </div>
</div>