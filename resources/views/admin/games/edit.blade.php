@extends('adminlte::page')

@section('title', 'Edit player')

@section('content_header')
    <h2>Edit Player</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('teams.update', $team->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" value="{{ $team->id }}"></div>

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Team name" value="{{ $team->name }}">

                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' 
                placeholder="Team slug" readonly value="{{ $team->slug }}">

                <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />
                
            </div>

            <div class="form-group">
                <label>Change logo</label>
                <input type="file" class="form-control-file mb-2" id="logo" name='logo'>

                <div class="rounded mx-auto d-block">
                    @if($team->logo)
                        <img src="{{ asset('storage/'.$team->logo) }}" style="width: 250px">
                    @else
                     <p>Team doesn't have a logo</p>
                    @endif
                </div>

                <x-input-error :messages="$errors->get('logo')" class="mt-2 text-danger" />
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
@endsection