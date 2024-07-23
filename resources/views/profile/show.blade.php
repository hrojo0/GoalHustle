@section('styles') 
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{ asset('build/assets/css/tournament.css') }}" rel="stylesheet">
@endsection


@section('title', 'Perfil')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 shadow-lg sm:rounded-lg">
                @include('widgets.user-card')
                @if (Auth::check())
                    @if ($profile->user_id == Auth::user()->id ) 
                        <a class=" hidden-sm hidden-xs wow fadeInUp" data-wow-delay="0.4s" href="{{ route('profile.edit', Auth::user())}}">
                            <x-bladewind::button class="text-base">Edit profile</x-bladewind::button>
                        </a>
                    @endif
                @endif
                <div class="max-w-xl">
                </div>
            </div>

            <div class="p-4 sm:p-8 shadow-lg sm:rounded-lg hidden-sm hidden-xs wow fadeInUp" data-wow-delay="0.4s">
                <div class="text-article text-center h4 title">
                    <h2 class="mb-5">Articles published</h2>
                </div>
                @if( count($articles) > 0)
                    <div class="autoplay" style="display: block; position: relative;">
                            @foreach ($articles as $article)
                            <div class="slide">
                                <div class="switcher-slide">
                                    <div class="slide-holder">
                                        <div class="img-holder">
                                            <img src="{{ asset('storage/'.$article->image) }}" alt="image description">
                                        </div>
                                        <h2><a href="{{ route('article.show', $article->slug) }}">{{ Str::limit($article->introduction, 50, '...') }}</a></h2>
                                        @php
                                            $date = Carbon\Carbon::parse($article->updated_at);
                                            $date->locale('es');
                                            $formattedDate = $date->translatedFormat('d \d\e F, Y');
                                        @endphp
                                        <time datetime="2011-01-12">{{ $formattedDate }}</time>
                                    </div>
                                </div>
                            </div>
                                
                            @endforeach
                    @else
                    <div class="no-articles">
                        <p>You don't have any public articles or created</p>
                    </div>
                @endif   
                    

                    
                
            </div>

        </div>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
              
            </div>
        </div>
    </div>
 


<div class="links-paginate-profile">
    {{ $articles->links() }}
</div>

</x-app-layout>