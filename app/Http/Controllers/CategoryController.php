<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Mostrar categorías en el admin
        $categories = Category::orderBy('id', 'desc')
                        ->simplePaginate(8);
        
                    //'folder.folder.view
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                    //'folder.folder.view
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        //
        $category = $request->all();

        //validar si existe archivi
        if($request->hasFile('image')){
            $category['image'] = $request->file('image')->store('categories');
        }

        //Guardar información
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-create', 'Category succesfully created');
    }

    /**
     * Display the specified resource.
     */
    /*public function show(Category $category)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //si usuario sube nueva imagen
        if($request->hasFile('image')){//if para saber si ya existe una carpeta
            //Eliminar imagen anterior
            File::delete(public_path('storage/' . $category->image));
            //Guarda nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }

        //actualizar datos
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
        ]);

        //redireccionar a articles index
        return redirect()->action([CategoryController::class, 'index'], compact('category'))
        ->with('success-update', 'Category succesfully edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //eliminar la imagen de la categoría
        if($category->image){
            File::delete(public_path('storage/' . $category->image));
        }

        //Eliminar la categoría
        $category->delete();
        return redirect()->action([CategoryController::class, 'index'], compact('category'))
        ->with('success-delete', 'Category deleted');
    }

    //filtrar articulos por categorias
    public function detail(Category $category)
    {
        $this->authorize('published', $category);
        $articles = Article::where([
                    ['category_id', $category->id],
                    ['status', '1']
                ])
                    ->orderBy('id','desc')
                    ->simplePaginate(5);

        $navbar = Category::where([
                    ['status', '1'],
                    ['is_featured', '1']
                    ])->paginate(3);

        $categoriesPublished = Category::where('status', 'true')
            ->inRandomOrder()
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
        $articlesPerCategory = Article::selectRaw('category_id, count(*) as articles_category')
            ->where('status', '1')            
            ->groupBy('category_id');

        
        $articlesCount = $articlesPerCategory->pluck('articles_category', 'category_id');

        return view('subscriber.categories.detail', compact('articles', 'category', 'navbar','categoriesPublished','articlesCount'));
    }
}
