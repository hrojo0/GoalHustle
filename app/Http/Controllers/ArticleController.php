<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mostrar artículos en el admin
        $user = Auth::user(); //obtiene información del usuario loggeado
        $articles = Article::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->withCount('comments')
            ->simplePaginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function articlesNews() {
        $articles = Article::where('status', '1')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $articlesPerCategory = Article::selectRaw('category_id, count(*) as articles_category')
            ->where('status', '1')            
            ->groupBy('category_id');
        $articlesCount = $articlesPerCategory->pluck('articles_category', 'category_id');

        $categoriesWithArticles = Category::where('status', '1')
            ->whereHas('articles', function ($query) {
                $query->where('status', true);
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('articles.news', compact('articles','articlesCount', 'categoriesWithArticles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Obtener categorías publicas
        $categories = Category::select('id', 'name')
            ->where('status','1')
            ->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        //
        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        //guardar solicitud de cliente
        $article = $request->all();

        //validar si hay un archivo, como un jpg, en el request
        if($request->hasFile('image')){
            $article['image'] = $request->file('image')->store('articles');
        }

        /*echo '<pre>';
        var_dump($article);
        echo '</pre>';
        exit;*/
        Article::create($article);

        return redirect()->action([ArticleController::class, 'index'])
        ->with('success-create', 'Article succesfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $this->authorize('published', $article);
        //ver detalles del articulo
        $comments = $article->comments()->simplePaginate(50);
        $totalComments = $article->comments()->count();

        $articlesRelated = Article::where([['category_id', $article->category_id],['status','1'],['id','!=',$article->id]])
                        ->inRandomOrder()
                        ->limit(2)
                        ->get();

        $articlesRecent = Article::where('status','1')->orderBy('created_at','desc')->limit(4)->get();

        $articlesPopular = DB::table('articles')
                        ->join('comments', 'articles.id', '=', 'comments.article_id', )
                        ->select(DB::raw('COUNT(comments.id) as quantity'), 'articles.id', 'articles.title', 'articles.slug', 'articles.image','articles.created_at')
                        ->where('articles.status', '=', '1')
                        ->groupBy('articles.id')
                        ->orderBy('quantity', 'desc')
                        ->limit(4)
                        ->get();

        $categoriesPublished = Category::where('status', '1')
                        ->whereHas('articles', function ($query) {
                            $query->where('status', true);
                        })
                        ->inRandomOrder()
                        ->orderBy('name', 'asc')
                        ->limit(10)
                        ->get();
        
        return view('articles.single-post', compact('article', 'comments', 'totalComments', 'articlesRelated', 'articlesRecent', 'articlesPopular', 'categoriesPublished'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->authorize('view', $article);
        //Obtener categorías publicas
        $categories = Category::select('id', 'name')
                        ->where('status','1')
                        ->get();
        return view('admin.articles.edit', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        //si usuario sube nueva imagen
        if($request->hasFile('image')){//if para saber si ya existe una carpeta
            //Eliminar imagen anterior
            File::delete(public_path('storage/' . $article->image));
            //Guarda nueva imagen
            $article['image'] = $request->file('image')->store('articles');
        }

        //actualizar datos
        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        //redireccionar a articles index
        return redirect()->action([ArticleController::class, 'index'])
        ->with('success-update', 'Article succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        //eliminar la imagen del articulo
        if($article->image){
            File::delete(public_path('storage/' . $article->image));
        }

        //Eliminar el artículo
        $article->delete();
        return redirect()->action([ArticleController::class, 'index'], compact('article'))
        ->with('success-delete', 'Article deleted');
    }
}
