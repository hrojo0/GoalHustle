@php
    $categoryName = $category->name;
@endphp
@section('title')
{{ 'GoalHustle | '.$categoryName }}
@endsection
@section('styles')
    <!--link href="{{ asset('build/assets/manage_post/post/css/article_show.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/manage_post/categories/css/article_category.css') }}" rel="stylesheet"-->
    <link href="{{ asset('build/assets/css/tournament.css') }}" rel="stylesheet">
@endsection 

<x-app-layout>
    <section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse product" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin=''>

        <div class="uk-width-1-1 uk-row-first">
            <div class="uk-panel">
                <div class="uk-cover-background uk-position-relative head-wrap" style="height: 290px; background-image: url('../img/stadium-2.jpg'); display:flex; justify-content:center; align-items:center">
                    <div class=" uk-flex uk-flex-center head-title">
                        <a href="{{ route('welcome') }}" style="max-width: 150px">
                            <img src="{{ asset('img/logo-v.png') }}" class="img-polaroid" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="uk-container uk-container-center">
        
        <div id="tm-middle" class="tm-middle uk-grid" data-uk-grid-match="" data-uk-grid-margin="">
            
            <aside class="tm-sidebar-a uk-width-medium-1-4 uk-row-first">
                <div class="uk-panel categories-sidebar">
                    <h3 class="uk-panel-title">Categories</h3>
                    <div>
                        <ul class="nav menu">
                            @foreach ($categoriesPublished as $category)
                                @if (($articlesCount[$category->id] ?? 0) != 0)
                                    <li class="item-3">             
                                        <a href="{{ route('categories.detail', $category->slug)}}">
                                            {{ $category->name }}<span class="label">({{ $articlesCount[$category->id] ?? 0 }})</span>
                                        </a>            
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                
                <div class="uk-panel news-sidebar">
                    <h3 class="uk-panel-title">Latest News</h3>
                    @php
                        if(count($articles) > 3)
                            $len = 3;
                        else {
                            $len = count($articles);
                        }
                    @endphp
                    @for ($i = 0; $i < $len; $i++)
                        <article class="has-context ">
                            <div class="latest-news-wrap">
                                <div class="img-wrap">
                                    <a href="{{ route('article.show', $articles[$i]->slug) }}">
                                    <img src="{{ asset($articles[$i]->image) }}" class="img-polaroid" alt="">
                                    </a>        
                                </div>
                                <div class="info">
                                    <div class="date">
                                        {{ \Carbon\Carbon::parse($articles[$i]->created_at)->format('F d, Y') }}            
                                    </div>
                                    <div class="name">
                                        <h4>
                                            <a href="{{ route('article.show', $articles[$i]->slug) }}">
                                                {{ $articles[$i]->title }}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endfor
                </div>
                
            </aside>
            <div class="tm-main uk-width-medium-3-4 ">
                <div class="main-next-match-title">
                    <em>
                        {{ ucfirst($categoryName) }}
                    </em>
                </div>
                <div class="contentpaneopen">
                   <main id="tm-content" class="tm-content">
                        <div class="uk-grid" data-uk-grid-match="">
                            @foreach ($articles as $article)
                                <div class="uk-width-large-1-3 uk-width-medium-2-4 uk-width-small-2-4 list-article uk-flex uk-flex-column">
                                    <div class="wrapper">
                                        <div class="img-wrap uk-flex-wrap-top">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                            <img src="{{ asset($article->image) }}" class="img-polaroid" alt="">
                                            </a>        
                                        </div>
                                        <div class="info uk-flex-wrap-middle">
                                            <div class="date">
                                                {{ \Carbon\Carbon::parse($article->created_at)->format('F d, Y') }}            
                                            </div>
                                            <div class="name">
                                                <h4>
                                                    <a href="{{ route('article.show', $article->slug) }}">
                                                    {{ $article->title }}</a>        
                                                </h4>
                                            </div>
                                            <div class="text">
                                                <p>{{ Str::limit($article->introduction, 150, '...') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="article-actions uk-flex-wrap-bottom">
                                        <div class="count"><i class="uk-icon-comments"></i><span>{{ $article->comments->count() }}</span></div>
                                        <div class="read-more"><a href="{{ route('article.show', $article->slug) }}">Read More</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="links-paginate"> 
                            {{ $articles->links() }}
                        </div>


                        
                            
                        
                    </main>
                </div>


            </div>
            
        </div>
    </div>
    
</x-app-layout>
