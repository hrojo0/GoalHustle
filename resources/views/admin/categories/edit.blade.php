@extends('adminlte::page')

@section('title', 'Editar categoría')

@section('content_header')
    <h2>Edit Category</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"><input type="hidden" name="id" value="{{ $category->id }}"></div>

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Nombre de la categoría" value="{{ $category->name }}">

                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' placeholder="Nombre de la categoría" value="{{ $category->slug }}" readonly>

                <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />
            </div>

            <div class="form-group">
                <label>Change image</label>
                <input type="file" class="form-control-file mb-2" id="image" name='image'>

                <div class="rounded mx-auto d-block">
                    <img src="{{ asset('storage/'.$category->image) }}" style="width: 250px">
                </div>

                <x-input-error :messages="$errors->get('image')" class="mt-2 text-danger" />
            </div>


            <label for="">Status</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Private</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="0"
                    {{ ($category->status == 0) ? 'checked' : '' }}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Public</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="1"
                    {{ ($category->status == 1) ? 'checked' : '' }}>
                </div>

                <x-input-error :messages="$errors->get('status')" class="mt-2 text-danger" />
            </div>

            <label for="">Featureed</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">No</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="0"
                    {{ ($category->is_featured == 0) ? 'checked' : '' }}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">Yes</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="1"
                    {{ ($category->is_featured == 1) ? 'checked' : '' }}>
                </div>

                <x-input-error :messages="$errors->get('is_featured')" class="mt-2 text-danger" />
            </div>
            <input type="submit" value="Modificar categoría" class="btn btn-primary">    
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