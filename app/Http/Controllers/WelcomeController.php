<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //Auth::login(Auth::user());
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Obtener articulos publicos (1)
        $articlesFeatured = Article::where([['status', '1'],['is_featured','1']])
                        ->orderBy('updated_at', 'asc')
                        ->limit(5)
                        ->get();
        
        $articlesRandom = Article::where('status', '1')
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();
                        
        $navbar = Category::where([
                        ['status', '1'],
                        ['is_featured', '1']
                        ])->paginate(3);
        
        $tournaments = Tournament::where('is_featured', '1')
                        ->get();
        
        $latestGames = Game::with(['tournament', 'homeTeam', 'awayTeam'])
                        ->where('matchday', '<=', now()) // Only games that have happened or are scheduled
                        ->orderByDesc('matchday')
                        ->get()
                        ->groupBy('tournament_id') // Group games by tournament ID
                        ->map(function ($games) {
                            return $games->first(); // Get the first (latest) game for each tournament
                        });

        $user_name = Auth::check() ? Auth::user()->name : null;

        return view('home', [
            'articlesFeatured' => $articlesFeatured, 
            'navbar' => $navbar, 
            'tournaments' => $tournaments, 
            'user_name' => $user_name,
            'latestGames' => $latestGames,
            'articlesRandom' => $articlesRandom
        ]);
        
        


        //return view('welcome', compact('articles', 'navbar'));
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
