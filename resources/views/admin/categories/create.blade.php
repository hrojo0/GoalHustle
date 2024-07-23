@extends('adminlte::page')

@section('title', 'Crear categoría')

@section('content_header')
<h2>Create new Category</h2>
@endsection

@section('content') 

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Nombre de la categoría"
                    value="{{ old('name') }}">

                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>


            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' placeholder="Slug de la categoría" readonly
                    value="{{ old('slug') }}">

                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="">Upload image</label>
                <input type="file" class="form-control-file" id="image" name='image'>

                <x-input-error :messages="$errors->get('image')" class="mt-2 text-danger" />
            </div>


            <label for="">Status</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Private</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="0" {{ old('status')=="0" ? 'checked' : '' }}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Public</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="1" {{ old('status')=="1" ? 'checked' : '' }}>
                </div>

                <x-input-error :messages="$errors->get('status')" class="mt-2 text-danger" />
            </div>

            <label for="">Featured</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">No</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="0"
                        {{ old('is_featured')=="0" ? 'checked' : '' }}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">Yes</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="1"
                    {{ old('is_featured')=="1" ? 'checked' : '' }}>
                </div>

                <x-input-error :messages="$errors->get('is_featured')" class="mt-2 text-danger" />

            </div>
            <input type="submit" value="Crear categoría" class="btn btn-primary">
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