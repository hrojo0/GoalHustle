<section class="widget recent-posts-widget version-ii wow fadeInUp" data-wow-delay="0.4s">
    <header class="tab-head">
        <h3><a class="active" href="#tab1">Recent Posts</a></h3>
        <h3><a href="#tab2">Popular Posts</a></h3>
    </header>
    <div class="tab-content">
        <div id="tab1">
            <ul>
                
                @foreach ($articlesRecent as $articleRecent)
                    <li>
                        <div class="alignleft">
                            <img src="{{ asset('storage/'.$articleRecent->image) }}" alt="image description">
                        </div>
                        <div class="descr">
                            <h4><a href="{{ route('article.show', $articleRecent->slug) }}">{{ $articleRecent->title }}</a></h4>
                            <span class="post-tag">
                                @php
                                    $date = Carbon\Carbon::parse($articleRecent->created_at);
                                    $date->locale('es');
                                    $formattedDate = $date->translatedFormat('d \d\e F, Y');
                                @endphp
                                <time datetime=""><a href="#" style="cursor:default">{{ $formattedDate }}</a></time>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="tab2">
            <ul>
                @foreach ($articlesPopular as $articlePopular)
                <li>
                    <div class="alignleft">
                        <img src="{{ asset('storage/'.$articlePopular->image) }}" alt="image description">
                    </div>
                    <div class="descr">
                        <h4><a href="{{ route('article.show', $articlePopular->slug) }}">{{ $articlePopular->title }}</a></h4>
                        <span class="post-tag">
                            @php
                                    $date = Carbon\Carbon::parse($articlePopular->created_at);
                                    $date->locale('es');
                                    $formattedDate = $date->translatedFormat('d \d\e F, Y');
                                @endphp
                                <time datetime=""><a href="#" style="cursor:default">{{ $formattedDate }}</a></time>
                        </span>
                    </div>
                </li>
                @endforeach>
            </ul>
        </div>
    </div>
</section>