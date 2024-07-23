@section('title', 'GoalHustle | Artículo')
@section('styles')
    <link href="{{ asset('css/tournament.css') }}" rel="stylesheet">
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
	<div id="wrapper">
		<!-- w1 of the page -->
		<div class="w1">
			<!-- Header of the page end -->
			<!-- Main of the page -->
			<main id="main" role="main">
				<!-- Container of the page -->
				<div class="container">
					<div class="row">
						<!-- Content of the page -->
						<article id="content" class="col-xs-12 col-md-8">
							
							@include('articles.partials.article-show')
							
							@include('widgets.user-info')
							
							@include('articles.partials.related-posts')

							<!-- Comments -->
							<section class="section comments wow fadeInUp" >
								<header class="header">
									<h2>Comments</h2>
									<p>{{ $totalComments }} comments</p>
								</header>

								@include('articles.partials.comments-show')
								
							</section>

							<!-- Leave a comment -->
							<section class="comment-respond wow fadeInUp" >
								@if(Auth::check())
									@include('articles.partials.comments-create')
								@else
								<header class="header">
									<h3 id="reply-title" class="comment-reply-title"><a href="{{ route('login') }}">Login to leave a comment</a></h3>
								</header>
								@endif
							</section>
						</article>


						<!-- Content of the page end -->
						<!-- Sidebar of the page -->
						<aside id="sidebar" class="col-xs-12 col-md-4">
							<!-- Widget of the page -->
							@include('widgets.search')
							
							@include('widgets.recent-popular-articles')

							<div class="widget promo-widget wow fadeInUp" >
								<a href="#"><img src="http://placehold.it/370x415" alt="“Place your Advertisement here”"></a>
							</div>
							<!-- Widget of the page end -->
							<!-- Widget of the page -->
							<div class="widget widget_categories version-ii wow fadeInUp" >
								<header class="widget-head">
									<h3>Categories</h3>
								</header>
								<ul style="columns: 2;">
									@foreach ($categoriesPublished as $categoryPublished)
										<li class="cat-item cat-item-1"><span><a href="{{ route('categories.detail', $categoryPublished->slug) }}">{{ $categoryPublished->name }}</a></span></li>
									@endforeach
								</ul>
							</div>
							<!-- Widget of the page end -->
						</aside>
						<!-- Sidebar of the page end -->
					</div>
				</div>
				
			</main>
			
	    	<span id="back-top" class="fa fa-angle-up"></span>
		</div>
	</div>

</x-app-layout>