@extends('adminlte::page')

@section('title', 'Edit tournament')

@section('content_header')
    <h2>Edit Tournament</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('tournaments.update', $tournament) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" value="{{ $tournament->id }}"></div>

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Tournament name" value="{{ $tournament->name }}" required>

                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' 
                placeholder="Tournament slug" readonly value="{{ $tournament->slug }}">

                <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />
                
            </div>

            <div class="form-group">
                <label for="">Season</label>
                <input type="number" class="form-control" id="season" name='season' 
                placeholder="Season year"  value="{{ $tournament->season }}" min="2020" max="2099">

                <x-input-error :messages="$errors->get('season')" class="mt-2 text-danger" />
                
            </div>

            <div class="form-group">
                <label for="">Rounds</label>
                <input type="number" class="form-control" id="rounds" name='rounds' 
                placeholder="Season rounds"  value="{{ $tournament->rounds }}" min="1" max="60">

                <x-input-error :messages="$errors->get('rounds')" class="mt-2 text-danger" />
                
            </div>

            <div class="form-group">
                <label>Change logo</label>
                <input type="file" class="form-control-file mb-2" id="logo" name='logo'>

                <div class="rounded mx-auto d-block">
                    @if($tournament->logo)
                        <img src="{{ asset('storage/'.$tournament->logo) }}" style="width: 250px">
                    @else
                     <p>Tournament doesn't have a logo</p>
                    @endif
                </div>

                <x-input-error :messages="$errors->get('logo')" class="mt-2 text-danger" />
            </div>

            <label for="">Featured</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">No</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="0"
                    {{ ($tournament->is_featured == 0) ? 'checked' : '' }}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">Yes</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="1"
                    {{ ($tournament->is_featured == 1) ? 'checked' : '' }}>
                </div>

                <x-input-error :messages="$errors->get('is_featured')" class="mt-2 text-danger" />
            </div>

            <input type="submit" value="Save changes" class="btn btn-primary">    
        </form>

    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('vendor\jQuery-Plugin-stringToSlug-1.3\jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready( function() {
        $("#name").stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: '#slug',
            space: '-'
        });
        });
    </script>
@stop