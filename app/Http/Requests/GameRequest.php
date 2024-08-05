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
    }

    /**
     * Customize the validation logic.
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $homeTeamId = $this->home_team;
            $awayTeamId = $this->away_team;
            $homeGoals = $this->home_goals;
            $awayGoals = $this->away_goals;
            $playerStats = $this->player_stats;

            // Retrieve all players for home and away teams
            $homeTeamPlayers = Player::where('team_id', $homeTeamId)->get()->keyBy('id');
            $awayTeamPlayers = Player::where('team_id', $awayTeamId)->get()->keyBy('id');

            // Calculate total goals from player stats
            $totalHomeGoals = 0;
            $totalAwayGoals = 0;

            foreach ($playerStats as $playerId => $stats) {
                if ($homeTeamPlayers->has($playerId)) {
                    $totalHomeGoals += $stats['goals'] ?? 0;
                } elseif ($awayTeamPlayers->has($playerId)) {
                    $totalAwayGoals += $stats['goals'] ?? 0;
                }
            }

            if ($totalHomeGoals > $homeGoals) {
                $validator->errors()->add('home_goals', 'Total home goals from player stats exceed the provided home goals.');
            }

            if ($totalAwayGoals > $awayGoals) {
                $validator->errors()->add('away_goals', 'Total away goals from player stats exceed the provided away goals.');
            }
        });
    }
}
