<div id="commentlist" class="commentlist">
    <!-- Comment list item of the page -->
    @foreach ($comments as $comment)
        <div class="commentlist-item">
            <div class="comment even thread-even depth-1" id="comment-1">
                <div class="avatar-holder">
                    <a href="{{ route('profile.show', $article->user->id) }}">
                        <img alt="image description"
                            src="{{ $comment->user->profile->photo ? asset('storage/'.$comment->user->profile->photo) : asset('img/user-default.png') }}"
                            class="avatar avatar-48 photo avatar-default">
                    </a>
                </div>
                <div class="commentlist-holder">
                    <p class="meta">
                        @php
                            $stars = '';
                            for ($i = 1 ; $i <= $comment->value; $i++){
                            $stars .= '⭐';
                            }
                        @endphp
                        <strong class="name"><a href="{{ route('profile.show', $article->user->id) }}">{{ $comment->user->name }} &nbsp; &nbsp; {{ $stars }}</strong>
                        
                        @php
                        $date = Carbon\Carbon::parse($comment->created_at);
                        $date->locale('es');
                        $formattedDate = $date->translatedFormat('h\:i a \| d \d\e F, Y');
                        @endphp
                        <a href="#"><time datetime="2011-01-12">{{ $formattedDate }}</time></a>
                    </p>
                    <p>{{ $comment->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
    <div class="links-paginate">
        {{ $comments->links() }}
    </div>

</div>