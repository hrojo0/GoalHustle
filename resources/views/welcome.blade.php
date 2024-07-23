@section('title', 'Goal Hustle')
@section('styles')
<link href="{{ asset('build/assets/manage_post/categories/css/article_category.css') }}" rel="stylesheet">
@endsection 
<x-guest-layout>
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class=" text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Goal Hustle') }}
            </h2>
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                        @include('layouts.navbar')
                   

                        <div class="article-container">
                            <!-- Listar artículos -->
                            @foreach ($articles as $article)
                                
                            <article class="article bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <img src="{{ asset('storage/'. $article->image) }}" class="img">
                                <div class="card-body ">
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        <h2 class="title  dark:text-blue-200">{{ Str::limit($article->title, 60, '...') }}</h2>
                                    </a>
                                    <p class="introduction text-gray-800 dark:text-gray-500">{{ Str::limit($article->introduction, 100, '...') }}</p>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        <!--paginado-->
                        <div class="links-paginate"> 
                            {{ $articles->links() }}
                        </div>
                </div>
            </div>
        </div>
    
</x-guest-layout>

