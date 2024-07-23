@extends('adminlte::page')
@section('title', 'Create tournament')

@section('content_header')
    <h2>Create new tournament</h2>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tournaments.store') }}" enctype="multipart/form-data">
                @csrf 

                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name='name' placeholder="Tournament name" value="{{ old('name') }}">
    
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" id="slug" name='slug' placeholder="Tournament slug" readonly value="{{ old('slug') }}">
    
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" /> 
                </div>

                <div class="form-group">
                    <label for="">Season</label>
                    <input type="number" class="form-control" id="season" name='season' placeholder="Season year"  value="{{ old('season') }}" min="2020" max="2099">
    
                    <x-input-error :messages="$errors->get('season')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Rounds</label>
                    <input type="number" class="form-control" id="rounds" name='rounds' placeholder="Season rounds"  value="{{ old('rounds') }}" min="1" max="60">
    
                    <x-input-error :messages="$errors->get('rounds')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <label for="">Upload logo</label>
                    <input type="file" class="form-control-file" id="logo" name='logo'>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2 text-danger" />
                    

                </div>


                <label for="">Featured</label>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="">Yes</label>
                        <input class="form-check-input ml-2" type="radio" name='is_featured' 
                        id="is_featured" value="0" {{ old('is_featured')=="0" ? 'checked' : '' }}>
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="">No</label>
                        <input class="form-check-input ml-2" type="radio" name='is_featured' 
                        id="is_featured" value="1" {{ old('is_featured')=="1" ? 'checked' : '' }}>
                    </div>

                    <x-input-error :messages="$errors->get('is_featured')" class="mt-2 text-danger" />
                
                </div>

                <input type="submit" value="Save tournament" class="btn btn-primary">
            </form>
        </div>
    </div>
@stop

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