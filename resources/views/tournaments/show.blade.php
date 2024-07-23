@section('title', 'Torneos de futbol')
@section('styles')
    <link href="{{ asset('css/tournament.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/t/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/t/uikit.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/c/accordion.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/t/theme.js')}}"></script>
@endsection
<x-app-layout>
    @include('tournaments.partials.header-img')
    <div class="uk-container uk-container-center alt">
        <ul class="uk-breadcrumb">
            <li class="uk-active"><span>{{ $tournament->name }}</span></li>
        </ul>
    </div>
    <div id="wrapper">
		<!-- w1 of the page -->
		<div class="w1">
			<!-- Header of the page end -->
			<!-- Main of the page -->
			<main id="main" role="main">
				<!-- Container of the page -->
				<div class="container">
                    <div id="tm-middle" class="tm-middle uk-grid" data-uk-grid-match="" data-uk-grid-margin="">
                        @include('tournaments.partials.games')
                        @include('tournaments.partials.stats')
                        
                    </div>
                   
                    
                </div>

            </main>
        </div>
    </div>
    <div class="tm-bottom-e-box tm-full-width  ">
        <div class="uk-container uk-container-center">
            <section id="tm-bottom-e" class="tm-bottom-e uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
                <div class="uk-width-1-1 uk-row-first">
                    <div class="uk-panel">
                        <img src="{{ asset('img/foot-results.png') }}" alt="">
                    </div>
                </div>
            </section>
        </div>
    </div>
    
</x-app-layout>