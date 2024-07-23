@extends('adminlte::page')

@section('title', 'Editar artículo')

@section('content_header')
    <h2>Edit article</h2>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group"><input type="hidden" name="id" value="{{ $article->id }}"></div>

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="title" name='title' minlength="5" 
                    maxlength="255" value="{{ $article->title }}" placeholder="Article title">

                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-danger" />
                    
                </div>

                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" id="slug" name='slug' 
                    placeholder="Article slug" readonly value="{{ $article->slug }}">
    
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-danger" />
                    
                </div>

                <div class="form-group">
                    <label>Introduction</label>
                    <input type="text" class="form-control" id="introduction" name='introduction' 
                    minlength="5" maxlength="255" value="{{ $article->introduction }}">
        
                    <x-input-error :messages="$errors->get('introduction')" class="mt-2 text-danger" />
                
                </div>

                <div class="form-group">
                    <label>Change image</label>
                    <input type="file" class="form-control-file mb-2" id="image" name='image'>

                    <div class="rounded mx-auto d-block">
                        <img src="{{ asset('storage/'.$article->image) }}" style="width: 250px">
                    </div>

                    <x-input-error :messages="$errors->get('image')" class="mt-2 text-danger" />
                
                </div>


                <div class="form-group">
                    <label for="">Article body</label>
                    <textarea class="form-control" id="body" name="body">{{ $article->body }}</textarea>             

                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-danger" />
                    
                </div>

                <label>Status</label>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Private</label>
                        <input class="form-check-input ml-2" type="radio" name='status' id="status" value="0"
                        {{ ($article->status == 0) ? 'checked' : '' }}>
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Public</label>
                        <input class="form-check-input ml-2" type="radio" name='status' id="status" value="1"
                        {{ ($article->status == 1) ? 'checked' : '' }}>
                    </div>

                    <x-input-error :messages="$errors->get('status')" class="mt-2 text-danger" />
                </div>

                <div class="form-group">
                    <select class="form-control" name="category_id" id="category_id">
                        <option>Pick a category</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        
                    </select>

                    
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-danger" />
                    
                </div>
                <input type="submit" value="Save changes" class="btn btn-primary">
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