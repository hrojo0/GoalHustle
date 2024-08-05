<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentTeamController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

//Welcome - LandPage
/*Route::get('/', function () {return view('welcome');})->name('welcome');*/
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

//Principal
Route::get('/home', [WelcomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Administrador
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'verified','check.admin.permission:admin.index'])->name('admin.index');

//Rutas de admin
Route::namespace('App\Http\Controllers')->prefix('admin')->group(function(){
        //Articulos
        Route::resource('articles', 'ArticleController')->except('show','articlesPublic')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:articles.index',
                                'check.admin.permission:articles.create', 
                                'check.admin.permission:articles.create', 
                                'check.admin.permission:articles.destroy'])
                        ->names('articles');
        //Categorias
        Route::resource('categories', 'CategoryController')->except('show')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:categories.index', 
                                'check.admin.permission:categories.create', 
                                'check.admin.permission:categories.edit', 
                                'check.admin.permission:categories.destroy'])
                        ->names('categories');
        //Torneos... ESTE ES EL MODELO IDEAL DE RUTAS PARA ADMINISTRATOR/AUTHOR
        Route::group(['middleware' => ['auth', 'verified']], function () {
                // Routes that only require 'tournaments.index' permission
                Route::middleware('check.admin.permission:tournaments.index')->group(function () {
                    Route::get('tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
                    Route::post('/tournaments/search', [TournamentController::class, 'search'])->name('tournaments.search');
                });
            
                // Routes that require different permissions
                Route::middleware('check.admin.permission:tournaments.create')->group(function () {
                    Route::get('tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
                    Route::post('tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
                });
            
                Route::middleware('check.admin.permission:tournaments.edit')->group(function () {
                    Route::get('tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
                    Route::put('tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
                });
            
                Route::delete('tournaments/{tournament}', [TournamentController::class, 'destroy'])
                    ->name('tournaments.destroy')
                    ->middleware('check.admin.permission:tournaments.destroy');
            });
        //Equipos
        Route::resource('teams', 'TeamController')->except('show')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:teams.index', 
                                'check.admin.permission:teams.create', 
                                'check.admin.permission:teams.edit', 
                                'check.admin.permission:teams.destroy'])
                        ->names('teams');
        Route::post('/teams/search', [TeamController::class, 'search'])
                ->middleware(['auth', 'verified', 'check.admin.permission:teams.index'])
                ->name('teams.search');
        //Tournament Teams
        Route::resource('tournamentTeams', 'TournamentTeamController')->except('show', 'index','create')
                ->middleware(['auth', 'verified',
                        'check.admin.permission:tournamentTeam.edit', 
                        'check.admin.permission:tournamentTeam.destroy'
                        ])
                ->names('tournamentTeam');
        Route::get('/tournaments/{tournament}/teams', [TournamentTeamController::class, 'index'])
                ->middleware(['auth', 'verified', 'check.admin.permission:tournamentTeam.index'])
                ->name('tournamentTeam.index');
        Route::get('tournaments/{tournament}/teams/create', [TournamentTeamController::class, 'create'])
                ->middleware(['auth', 'verified', 'check.admin.permission:tournamentTeam.create'])
                ->name('tournamentTeam.create');

        Route::post('/tournamentTeams/search', [TournamentTeamController::class, 'search'])
                ->middleware(['auth', 'verified', 'check.admin.permission:tournamentTeam.index'])
                ->name('tournamentTeam.search');
        //Games
        Route::post('/games/gamesPerTournament', [GameController::class, 'gamesPerTournament'])
                ->middleware(['auth', 'verified', 'check.admin.permission:games.index'])
                ->name('games.gamesPerTournament');
        Route::post('/games/generateGames', [GameController::class, 'generateGames'])
                ->middleware(['auth', 'verified', 'check.admin.permission:games.index'])
                ->name('games.generateGames');
        Route::post('/games/search', [GameController::class, 'search'])
                ->middleware(['auth', 'verified', 'check.admin.permission:games.index'])
                ->name('games.search');
        Route::resource('games', 'GameController')->except('show', 'search', 'gamesPerTournament')
        ->middleware(['auth', 'verified',
                'check.admin.permission:games.index', 
                'check.admin.permission:games.create', 
                'check.admin.permission:games.edit', 
                'check.admin.permission:games.destroy'
                ])
                ->names('games');
        //Jugadores
        Route::post('/players/search', [PlayerController::class, 'search'])
                ->middleware(['auth', 'verified', 'check.admin.permission:players.index'])
                ->name('players.search')
                        ;
        Route::resource('players', 'PlayerController')->except('show', 'search')
        ->middleware(['auth', 'verified',
                'check.admin.permission:players.index', 
                'check.admin.permission:players.create', 
                'check.admin.permission:players.edit', 
                'check.admin.permission:players.destroy'])
                ->names('players');
        //Stats Player
        Route::resource('stats_player', 'StatsPlayerController')->except('show','index','destroy')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:stats_player.create', 
                                'check.admin.permission:stats_player.edit'])
                        ->names('stats_player');
        //Comentarios
        Route::resource('comments', 'CommentController')->only('index', 'destroy')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:comments.index',
                                'check.admin.permission:comments.destroy'])
                        ->names('comments');
        //Usuario
        Route::resource('users', 'UserController')->except('create', 'show', 'store')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:users.index', 
                                'check.admin.permission:users.edit',
                                'check.admin.permission:users.destroy', ])
                        ->names('users');
        //Roles
        Route::resource('roles', 'RoleController')->except('show')
                        ->middleware(['auth', 'verified',
                                'check.admin.permission:roles.index',
                                'check.admin.permission:roles.create',
                                'check.admin.permission:roles.edit',
                                'check.admin.permission:roles.destroy'])
                        ->names('roles');

});

//Perfiles
Route::resource('profile', ProfileController::class)
        ->middleware(['auth', 'verified'])
        ->only('edit', 'update','destroy')
        ->names('profile');
Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');

//ver artículos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('news', [ArticleController::class, 'articlesNews'])->name('article.news');
//ver articulos por categorias
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');
//ver torneos
Route::get('tournament/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
//Ver equipos
Route::get('team/{team}', [TeamController::class, 'show'])->name('team.show');
//Ver jugadores
Route::get('player/{player}', [PlayerController::class, 'show'])->name('player.show');
//Get players ajax search
//Route::post('/players/search', [PlayerController::class, 'search'])->middleware(['auth', 'verified','check.admin.permission:players.search'])->name('players.search');


//Guardar comentarios
Route::post('/comment', [CommentController::class, 'store'])->middleware(['auth', 'verified'])->name('comments.store');

Route::middleware('auth')->group(function () {
    Route::get('/pre', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.destroy');
});

//Auth::routes();

require __DIR__.'/auth.php';