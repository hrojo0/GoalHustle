<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $player_stats = $this->player_stats;
        if($player_stats){
            return [
                'tournament' => 'required|integer',
                'home_team' => 'required|integer',
                'away_team' => 'required|integer',
                'matchday' => 'required|date',
                'round' => 'required|integer',
                'home_goals' => 'required|integer',
                'away_goals' => 'required|integer',
                'player_stats' => 'array',
                'player_stats.*.goals' => 'nullable|integer',
                'player_stats.*.assists' => 'nullable|integer',
                'player_stats.*.yellow_cards' => 'nullable|integer',
                'player_stats.*.red_card' => 'nullable|integer',
            ];
        } else {
            return [
                'tournament' => 'required|integer',
                'home_team' => 'required|integer',
                'away_team' => 'required|integer',
                'matchday' => 'required|date',
                'round' => 'required|integer',
            ];
        }
    }

    /**
     * Customize the validation logic.
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $home_team_id = $this->home_team;
            $away_team_id = $this->away_team;
            $home_goals = $this->home_goals;
            $away_goals = $this->away_goals;
            $player_stats = $this->player_stats;

            // Retrieve all players for home and away teams
            $home_team_players = Player::where('team_id', $home_team_id)->get()->keyBy('id');
            $away_team_players = Player::where('team_id', $away_team_id)->get()->keyBy('id');

            // Calculate total goals from player stats
            $total_home_goals = 0;
            $total_away_goals = 0;
            $total_home_assists = 0;
            $total_away_assists = 0;

            if($player_stats){
                foreach ($player_stats as $player_id => $stats) {
                    if ($home_team_players->has($player_id)) {
                        $total_home_goals += $stats['goals'] ?? 0;
                        $total_home_assists += $stats['assists'] ?? 0;
                    } elseif ($away_team_players->has($player_id)) {
                        $total_away_goals += $stats['goals'] ?? 0;
                        $total_away_assists += $stats['assists'] ?? 0;
                    }
                }

                if ($total_home_goals != $home_goals) {
                    $validator->errors()->add('home_goals', "Total home goals from player stats doesn't match the provided home goals.");
                }
                if ($total_home_assists > $home_goals) {
                    $validator->errors()->add('home_goals', 'Total home assists from player stats exceed the provided home goals.');
                }

                if ($total_away_goals != $away_goals) {
                    $validator->errors()->add('away_goals', "Total away goals from player stats doesn't match the provided away goals.");
                }
                if ($total_away_assists > $away_goals) {
                    $validator->errors()->add('away_goals', 'Total away assists from player stats exceed the provided away goals.');
                }
            }
        });
    }
}
