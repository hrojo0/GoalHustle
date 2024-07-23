<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'team_id' => [
                'required',
                'exists:teams,id',
                function ($attribute, $value, $fail) {
                    // Check if the team is already registered in the tournament
                    $tournament_id = $this->route('tournamentTeam')->tournament_id;
                    $duplicate = \App\Models\TournamentTeam::where('tournament_id', $tournament_id)
                        ->where('team_id', $value)
                        ->where('id', '!=', $this->route('tournamentTeam')->id)
                        ->exists();

                    if ($duplicate) {
                        $fail('The selected team is already registered in the tournament.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'team_id.required' => 'Please select a team.',
            'team_id.exists' => 'The selected team does not exist.',
        ];
    }
}
