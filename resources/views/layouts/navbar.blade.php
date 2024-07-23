<div class="category-container">
    <ul class="px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600">
        <li class="nav-item {{ request()->routeIs('welcome') ? 'active' : '' }}"><a href="{{ route('welcome') }}">Todo</a></li>         
            
        @foreach ($navbar as $category)
            <li class="nav-item {!! (Request::path()) == 'category/'. $category->slug ? 'active' : '' !!}">
                <a href="{{ route('categories.detail', $category->slug) }}">{{ $category->name }}</a>
            </li>
        @endforeach
        

        <li class="nav-item {{ request()->routeIs('home.all') ? 'active' : '' }}">
            <a href="{{ route('home.all') }}">Todas las categorias</a>
        </li>

    </ul>
</div>