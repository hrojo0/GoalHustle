@extends('adminlte::page')
@section('title', 'Add Team')

@section('content_header')
    <h2>Add new team</h2>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('teams.store') }}" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name='name'
                        placeholder="Team name" minlength="5" maxlength="255" 
                        value="{{ old('name') }}">
                    
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                    

                </div>

                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" id="slug" name='slug' 
                        placeholder="Team slug" readonly value="{{ old('slug') }}">

                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />

                </div>

                <div class="form-group">
                    <label for="">Upload team logo</label>
                    <input type="file" class="form-control-file" id="logo" name='logo'>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2 text-danger" />
                </div>


                <input type="submit" value="Save team" class="btn btn-primary">
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
@endsection