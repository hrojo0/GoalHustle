<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        if(Auth::check())
            Auth::login(Auth::user());
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Obtener articulos publicos (1)
        $articles = Article::where('status', '1')
                        ->orderBy('id', 'desc')
                        ->simplePaginate(10);
        
        $navbar = Category::where([
                        ['status', '1'],
                        ['is_featured', '1']
                        ])->paginate(3);
        $user_name = Auth::user()->name;
        //return view('home.index', compact('articles', 'navbar'));
        return view('home', compact('articles', 'navbar', 'user_name'));
    }

    //Todas las categorías
    public function all(){
        $categories = Category::where('status', '1')
                        ->simplePaginate(10);

        $navbar = Category::where([
                        ['status', '1'],
                        ['is_featured', '1']
                        ])->paginate(3);
        
        return view('home.all-categories', compact('categories', 'navbar'));
    }
}
