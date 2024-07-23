@extends('adminlte::page')
@section('title', 'Administración de Artículos')

@section('content_header')
    <h2>Administra tus artículos</h2>
@stop

@section('content')
@if (session('success-create'))
    <div class="alert alert-info">
        {{ session('success-create') }}
    </div>
    @elseif (session('success-update'))
        <div class="alert alert-info">
            {{ session('success-update') }}
        </div>
        @elseif (session('success-delete'))
        <div class="alert alert-info">
            {{ session('success-delete') }}
        </div>
@endif
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href="{{ route('articles.create') }}">Create article</a>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Categories</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ Str($article->title, 25, '...') }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>
                                <input type="checkbox" name="status" id="status" class="form-check-input ml-4"
                                {{ $article->status ? 'checked="checked"' : '' }}
                                disabled>
                            </td>

                            <td width="2px"><a href="{{ route('article.show', $article->slug) }}"
                                    class="btn btn-primary btn-sm mb-2">Open</a></td>

                            <td width="5px"><a href="{{ route('articles.edit', $article->slug) }}"
                                    class="btn btn-primary btn-sm mb-2">Edit</a></td>

                            <td width="5px">
                                <form action="{{ route('articles.destroy', $article->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    

                </tbody>
            </table>
            <div class="text-center mt-3">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@stop