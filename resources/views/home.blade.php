@section('title', 'GoalHustle')
@section('styles')
    <link href="{{ asset('build/assets/css/tournament.css') }}" rel="stylesheet">
@endsection
<x-app-layout>
	<div class="home-box">
		<section class="slideshow">
			<!-- slide of the page -->
			@foreach ($articlesFeatured as $article)
				<div class="slide" style="background-image: url('{{ asset('storage/'.$article->image) }}');">
					<div class="align-holder wow fadeInUp">
						<div class="align">
							<div class="container">
								<div class="row">
									<header class="header col-xs-12 col-sm-8 col-sm-offset-2 text-center">
										<div class="title-box"><strong class="title"><a href="{{ route('categories.detail', $article->category->slug) }}" style="color:#fff ">{{ $article->category->name }}</a></strong></div>
										<h1>{{ $article->title }}</h1>
										<a href="{{ route('article.show', $article->slug) }}">Read more...</a>
									</header>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</section>
		<!-- switcher of the page -->
		<div class="switcher wow fadeInUp">
			<div class="center-block">
				<!-- switcher mask of the page -->
				<div class="switcher-mask">
					@foreach ($articlesFeatured as $article)
						@php
							$date = Carbon\Carbon::parse($article->updated_at);
							$date->locale('es');
							$formattedDate = $date->translatedFormat('d \d\e F, Y');
						@endphp
						<div class="slide">
							<div class="switcher-slide">
								<div class="slide-holder">
									<div class="img-holder">
										<img src="{{ asset('storage/'.$article->image) }}" alt="image description">
									</div>
									<h2><a href="{{ route('article.show', $article->slug) }}">{{ Str::limit($article->introduction, 50, '...') }}</a></h2>
									<time datetime="2011-01-12">{{ $formattedDate }}</time>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<!-- switcher mask of the page end -->
			</div>
		</div>
		<!-- slide of the page end -->
	</div>
	<!-- last results -->
	<div id="twocolumns">
		
		<div class="container">
			<div class="row">
				<!-- Content of the page -->
				<div class="tm-sidebar-a uk-row-first  wow fadeInUp">
					<div class="uk-container uk-container-center">
						<div class="va-latest-top">
							<h3>Lasts <span>Results</span></h3>
						</div>
					</div>
					<x-bladewind::tab-group name="tournaments">
						<x-slot:headings>
							@php $x=1; @endphp
							@foreach ($latestGames as $latestGame)
								@if($loop->first)
									<x-bladewind::tab-heading
									name="tournament-{{$x}}" label="{{ $latestGame->tournament->name }}" active="true"/>
								@else
									@php $x++; @endphp
									<x-bladewind::tab-heading
										name="tournament-{{$x}}" label="{{ $latestGame->tournament->name }}" />
								@endif
							@endforeach
						</x-slot:headings>



						<x-bladewind::tab-body>
							@php $y=1; @endphp
							@foreach ($latestGames as $latestGame)
								@if($loop->first)
									@if($latestGame->tournament->is_featured)
									<x-bladewind::tab-content name="tournament-{{$y}}" active="true">
										@include('widgets.latest-game')
									</x-bladewind::tab-content>
									@endif
								@else
									@if($latestGame->tournament->is_featured)
									@php $y++; @endphp
									<x-bladewind::tab-content name="tournament-{{$y}}">
										@include('widgets.latest-game')
									</x-bladewind::tab-content>
									@endif
								@endif
							@endforeach
							


						</x-bladewind::tab-body>

					</x-bladewind::tab-group>
				</div>
				<!-- Content of the page end -->
			</div>
		</div>
	</div>
	<!-- end last results -->

	<!-- news -->
	<div class="tm-top-f-box tm-full-width  va-main-our-news">
		<div class="uk-container uk-container-center">
			<section id="tm-top-f" class="tm-top-f uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
				<div class="uk-width-1-1">
					<div class="uk-panel">
						<div class="uk-container uk-container-center">
							<div class="uk-grid uk-grid-collapse" data-uk-grid-match="">
								<div class="uk-width-1-1">
									<div class="our-news-title wow fadeInUp">
										<h3>Latest<span> News</span></h3>
										<br>
									</div>
								</div>
								@foreach ($articlesRandom as $article)
									<article class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1 our-news-article wow fadeInUp" data-uk-grid-match="">
										<div class="img-wrap uk-cover-background uk-position-relative" style="background-image: url({{ asset('storage/'.$article->image) }}); min-height: 280px;">
											<a href="{{ route('article.show', $article->slug) }}"></a>
											<img class="uk-invisible" src="{{ asset('storage/'.$article->image) }}" alt="">

										</div>
										<div style="min-height: 280px;" class="info">
											<div class="date">
												@php
													$date = Carbon\Carbon::parse($article->created_at);
													$date->locale('es');
													$formattedDate = $date->translatedFormat('d \d\e F, Y');
												@endphp
												{{ $formattedDate }} </div>
											<div class="name">
												<h4>
													<a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>	
												</h4>
											</div>
											<div class="text">
												<p>{{ Str::limit($article->introduction, 150, '...') }}</p>
												<div class="read-more"><a href="{{ route('article.show', $article->slug) }}">Read more..</a>
												</div>
											</div>
										</div>

									</article>
								@endforeach



							</div>
						</div>
						<div class="all-news-btn  wow fadeInUp"><a href="{{ route('article.news') }}"><span>ALL NEWS</span></a>
						</div>

					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- end news -->

	
<!--div id="content" class="col-xs-12">

					<nav role="navigation" class="navigation pagination">
						<div class="nav-links text-center">
							<a href="#" class="prev page-numbers">Prev post.</a>
							<a href="#" class="page-numbers">1</a>
							<span class="page-numbers current">2</span>
							<span class="page-numbers dots hidden">…</span>
							<a href="#" class="page-numbers">3</a>
							<a href="#" class="next page-numbers">NEXT post.</a>
						</div>
					</nav>
					
				</div-->
				<!-- Navigation of the page end -->

	<!-- Instaragram Slider of the page -->
	<div class="instagram-slider wow fadeInUp">
		<div class="container-fluid">
			<div class="row">
				<div class="mask">
					<div class="slideset">
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
						<div class="slide">
							<a href="#"><img src="http://placehold.it/275x240" alt="image description"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Instaragram Slider of the page end -->
</x-app-layout>



