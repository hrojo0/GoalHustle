@section('title', 'Artículo')
@section('styles')
<link href="{{ asset('build/assets/manage_post/post/css/article_show.css') }}" rel="stylesheet">
<link href="{{ asset('build/assets/manage_post/comments/css/comments.css') }}" rel="stylesheet">
@endsection 

<x-guest-layout>


    <div class="content-post">

        <div class="post-title line">
            <h2 class="fw-bold">{{ $article->title }}</h2>
        </div>

        <div class="post-introduction line">
            <p>{{ $article->introduction}}</p>
        </div>

        <div class="post-author line">
            

            <div style="width: 30px; height: 30px; overflow: hidden; margin-right: 5px; border-radius:100%">
                <img src="{{ $article->user->profile->photo ? asset('storage/'.$article->user->profile->photo) : asset('img/user-default.png') }}" class="img-author">
            </div>


            

            <span>Autor:
                <a href="#">{{ $article->user->name }}</a>
            </span>
        </div>

        <hr>

        <div class="post-image">
            <img src="{{ asset('storage/'.$article->image) }}" alt="imagen" class="post-image-img">
        </div>

        <div class="post-body line">{!! $article->body !!}</div>
        <hr>
    </div>

    <div class="text-primary">
        <h2>Comentarios</h2>
    </div>

    @if (Auth::check())
        @include('subscriber.comments.create')
    @else
    <span class="alert-post">Para comentar debe 
        <a href="{{ route('login') }}" class=" text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            iniciar sesión
        </a>
        </span>
    @endif

    @if (session('success-error'))
        <div class="text-danger text-center">
            <p class="fs-5">{{ session('success-error') }}</p>
        </div>
    @endif

    @include('subscriber.comments.show')
</x-guest-layout>