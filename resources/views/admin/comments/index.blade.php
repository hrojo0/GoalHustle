@extends('adminlte::page')

@section('title', 'Administración de comentarios')

@section('content_header')
<h2>Administra los comentarios</h2>
@endsection

@section('content')
@if (session('success-delete'))
    <div class="alert alert-info">
        {{ session('success-delete') }}
    </div>
@endif
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>User</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td><a href=" {{ '/article/'.$comment->slug }}"> {{ $comment->title }} </a></td>
                        <td>{{ $comment->value }}</td>
                        <td>{{ $comment->description }}</td>
                        <td>{{ $comment->name }}</td>

                        
                        <td width="10px">
                            <form action="{{ route('comments.destroy', $comment->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                            </form>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
    </div>
</div>
@endsection