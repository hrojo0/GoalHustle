@section('title', 'Goal Hustle')
@section('styles')
<link href="{{ asset('build/assets/manage_post/categories/css/article_category.css') }}" rel="stylesheet">
@endsection 
<x-guest-layout>

    @include('layouts.navbar')
    <h2 class=" text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('TODAS LAS CATEGORÍAS') }}
    </h2>
    <div class=" overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="article-container">
                @foreach ($categories as $category)
                    <article class="article">
                        <img src="{{ asset('storage/'. $category->image) }}" class="img">
                        <div class="card-body">
                            <a href="{{ route('categories.detail', $category->slug) }}">
                                <h2 class="title">{{ $category->name }}</h2>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
                <!--paginado-->
            <div class="links-paginate"> 
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>