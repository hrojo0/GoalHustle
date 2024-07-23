<header class="header">
    <h3 id="reply-title" class="comment-reply-title">Envía tu comentario</h3>
</header>
<form action="{{ route('comments.store') }}" method="post" id="commentform" class="comment-form">
    @csrf
    
    <div class="wrap">
        <div class="form-group fs-5">
            <label for="start-label-title">Calificación <span class="required">*</span></label>
            <div class="form-group rating">
                <input id="star5" name="value" type="radio" value="5" class="radio-btn hide" checked />
                <label for="star5"><i class="fa fa-star"></i></label>
                <input id="star4" name="value" type="radio" value="4" class="radio-btn hide" />
                <label for="star4"><i class="fa fa-star"></i></label>
                <input id="star3" name="value" type="radio" value="3" class="radio-btn hide" />
                <label for="star3"><i class="fa fa-star"></i></label>
                <input id="star2" name="value" type="radio" value="2" class="radio-btn hide" />
                <label for="star2"><i class="fa fa-star"></i></label>
                <input id="star1" name="value" type="radio" value="1" class="radio-btn hide" />
                <label for="star1"><i class="fa fa-star"></i></label>
                <div class="clear"></div>
       
                <x-input-error :messages="$errors->get('value')" class="mt-2" />
    
            </div>
        </div>
        
    </div>

    <div class="comment-form-comment">
        <label for="comment">Comentario <span class="required">*</span></label>
        <textarea id="comment" name="description" rows="3" cols="72" aria-required="true" placeholder="Escribe tu comentario">{{ old('description') }}</textarea>
        
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>


    <div class="form-submit">
        <input type="submit" name="submit" id="submit" value="Envía tu comentario">
        <input type="hidden" name="article_id" value="{{ $article->id }}" id="comment_post_ID">
    </div>
</form>