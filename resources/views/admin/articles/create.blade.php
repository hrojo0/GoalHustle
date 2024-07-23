@extends('adminlte::page')
@section('title', 'Crear artículo')

@section('content_header')
    <h2>Create new article</h2>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control" id="title" name='title'
                        placeholder="Article title" minlength="5" maxlength="255" 
                        value="{{ old('title') }}">
                    
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-danger" />
                    

                </div>

                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" id="slug" name='slug' 
                        placeholder="Article slug" readonly value="{{ old('slug') }}">

                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />

                </div>

                <div class="form-group">
                    <label>Introduction</label>
                    <input type="text" class="form-control" id="introduction" name='introduction'
                        placeholder="Article introduction" minlength="5" maxlength="255"
                        value="{{ old('introduction') }}">


                    <x-input-error :messages="$errors->get('introduction')" class="mt-2 text-danger" />

                </div>

                <div class="form-group">
                    <label for="">Upload image</label>
                    <input type="file" class="form-control-file" id="image" name='image'>
                    <x-input-error :messages="$errors->get('image')" class="mt-2 text-danger" />
                    

                </div>

                <div class="form-group w-5">
                    <label for="">Body of the article</label>
                    <textarea class="ckeditor form-control" id="body" name="body"> {{ old('body') }} </textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-danger" />
                    
                </div>

                <label for="">Status</label>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="">Private</label>
                        <input class="form-check-input ml-2" type="radio" name='status' 
                        id="status" value="0" {{ old('status')=="0" ? 'checked' : '' }}>
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="">Public</label>
                        <input class="form-check-input ml-2" type="radio" name='status' 
                        id="status" value="1" {{ old('status')=="1" ? 'checked' : '' }}>
                    </div>

                    <x-input-error :messages="$errors->get('status')" class="mt-2 text-danger" />
                
                </div>

                <div class="form-group">
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Category</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        
                        
                    </select>

                    <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-danger" />
                    
                </div>

                <input type="submit" value="Save article" class="btn btn-primary">
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#body'))
            .catch(error => {
                console.error( error );
        });
    </script>
    <script src="{{ asset('vendor\jQuery-Plugin-stringToSlug-1.3\jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready( function() {
        $("#title").stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: '#slug',
            space: '-'
        });
        });
    </script>
@stop