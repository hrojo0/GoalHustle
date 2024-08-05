@extends('adminlte::page')

@section('title', 'Edit stats player')

@section('content_header')
    <h2>Edit Stats Player</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('stats_player.update', $statsPlayer) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="" name="id" value="{{ $statsPlayer->id }}"></div>

            <div class="form-group">
                <label for="">{{ $statsPlayer->player->name }}</label>
                <label for="">{{ $statsPlayer->player_id }}</label>
            </div>

            <div class="form-group">
                <label for="">{{ $statsPlayer->player->team->name }}</label>
            </div>

            <input type="submit" value="Save stats" class="btn btn-primary">    
        </form>

    </div>
</div>
@endsection