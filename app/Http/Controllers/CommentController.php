<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user()->id;

        $comments = DB::table('comments')
            ->join('articles', 'comments.article_id', '=', 'articles.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.id', 'comments.value', 'comments.description', 'articles.title', 'users.name', 'articles.slug')
            ->where('articles.user_id', '=', $user)
            ->orderBy('articles.title', 'asc')
            ->get();

            return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        //checar si en el articulo ya existe un comentario del usuario
        $result = Comment::where('user_id', Auth::user()->id)
                        ->where('article_id', $request->article_id)->exists();
        
        //obtiener slug y estado del articulo
        $article = Article::select('status', 'slug')->find($request->article_id);

        //si no existe comentario y el estado del articulo es publico se puede comentar
        if(!$result and $article->status == 1)
        {
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'article_id' => $request->article_id,
            ]);

            return redirect()->action([ArticleController::class, 'show'], [$article->slug]);

        } 
        //si ya existe un comentario del usuario en el articulo
        else {
            return redirect()->action([ArticleController::class, 'show'], [$article->slug])
                            ->with('success-error', 'Only one comment per user is allowed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->action([CommentController::class, 'index'], compact('comment'))
                            ->with('success-delete', 'Comment deleted');
    }
}
