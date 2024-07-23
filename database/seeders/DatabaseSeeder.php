<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Game;
use App\Models\Player;
use App\Models\Profile;
use App\Models\StatsPlayer;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeams;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Eliminar carpetas
        Storage::deleteDirectory('articles');
        Storage::deleteDirectory('categories');
        Storage::deleteDirectory('teams');
        Storage::deleteDirectory('tournaments');

        //Crear carpetas
        Storage::makeDirectory('articles');
        Storage::makeDirectory('categories');
        Storage::makeDirectory('teams');
        Storage::makeDirectory('tournaments');
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call(RoleSeeder::class);
        
        
        $this->call(UserSeeder::class);

        //Factories
        Category::factory(8)->create();
        Article::factory(20)->create();
        Comment::factory(20)->create();


        //Tournaments info seeder
        $tournaments = Tournament::factory(3)->create();
        $teams = Team::factory(20)->create(/*['logo' => 'teams/team.png']*/);
        
        $teams->each(function($team) {
            $shirtNumbers = range(1, 22);
            shuffle($shirtNumbers);
            foreach (range(1, 11) as $index) {
                Player::factory()->create([
                    'team_id' => $team->id,
                    'number' => array_pop($shirtNumbers)
                ]);
            }
        });

        $tournaments->each(function($tournament) use ($teams){
            $teams->each(function($team) use ($tournament){
                TournamentTeams::factory()->create([
                    'tournament_id' => $tournament->id,
                    'team_id' => $team->id
                ]);
            });
        });
        
        
        foreach ($tournaments as $tournament) {
            $gamesCreated = [];
            $roundsTournament = $tournament->rounds;
            $roundTeams = []; //$roundTeams[]
            
            for ($i = 1; $i <= $roundsTournament; $i++) {
                $roundTeams[$i] = []; //$roundTeams[1][]
            }

            for ($i = 0; $i < rand(8,16); $i++) { // 8-16 games por torneo
                $homeTeam = $teams->random()->id;
                $awayTeam = $teams->random()->id;
                $round = rand(1, $roundsTournament); 

                // Ensure home_team_id is not equal to away_team_id and not duplicated
                while ($homeTeam === $awayTeam || in_array([$homeTeam, $awayTeam], $gamesCreated) || in_array([$awayTeam, $homeTeam], $gamesCreated) ||
                in_array($homeTeam, $roundTeams[$round]) || in_array($awayTeam, $roundTeams[$round])) {
                    $homeTeam = $teams->random()->id;
                    $awayTeam = $teams->random()->id;
                    $round = rand(1, $roundsTournament);
                }
                

                $gamesCreated[] = [$homeTeam, $awayTeam];
                $roundTeams[$round][] = $homeTeam; //$roundTeams[1]['homeTeam']
                $roundTeams[$round][] = $awayTeam; //$roundTeams[1]['homeTeam','awayTeam']
                //Create game with these specific parameters and factory on the others
                $game = Game::factory()->create([
                    'tournament_id' => $tournament->id,
                    'home_team_id' => $homeTeam,
                    'away_team_id' => $awayTeam,
                    'round' => $round
                ]);

                $homeGoals = $game->home_goals;
                $awayGoals = $game->away_goals;
                
                // Create StatsPlayer for each Game with given game an player and factory on the others
                foreach ($game->homeTeam->players as $player) {
                    
                    if($homeGoals <= 0){
                        $goals = 0;
                        $assists = 0;
                    } else{
                        $goals = rand(0, $homeGoals);
                        $assists = rand(0, $homeGoals);
                        $homeGoals -= $goals;
                    }
                    
                    StatsPlayer::factory()->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                        'goals' => $goals,
                        'assists' => $assists
                    ]);
                }
                
                foreach ($game->awayTeam->players as $player) {
                    if($awayGoals <= 0){
                        $goals = 0;
                        $assists = 0;
                    } else{
                        $goals = rand(0, $awayGoals);
                        $assists = rand(0, $awayGoals);
                        $awayGoals -= $goals;
                    }
                    StatsPlayer::factory()->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                        'goals' => $goals,
                        'assists' => $assists
                    ]);
                }
            }
        }

    }
}
