<?php

namespace App\Providers;

use App\Http\Middleware\CheckAdminPermission;
use App\Models\Article;
use App\Models\Category;
use App\Models\Player;
use App\Models\Profile;
use App\Models\StatsPlayer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Policies\ArticlePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PlayerPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\StatsPlayerPolicy;
use App\Policies\TeamPolicy;
use App\Policies\TournamentPolicy;
use App\Policies\TournamentTeamPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
        //$this->registerPolicies();
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Player::class, PlayerPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(Tournament::class, TournamentPolicy::class);
        Gate::policy(TournamentTeam::class, TournamentTeamPolicy::class);
        Gate::policy(StatsPlayer::class, StatsPlayerPolicy::class);
        Gate::policy(Profile::class, ProfilePolicy::class);

        Route::aliasMiddleware('check.admin.permission', CheckAdminPermission::class);

        View::composer('layouts.navigation', function ($view) {
            $tournamentsNav = Tournament::orderBy('name','asc')->get();
            $categoriesNav = Category::where('status', '1')
                ->whereHas('articles', function ($query) {
                    $query->where('status', true);
                })
                ->orderBy('name', 'asc')
                ->get();
                
            $view->with([
                'tournamentsNav' => $tournamentsNav,
                'categoriesNav' => $categoriesNav ]);
        });
    }
}
