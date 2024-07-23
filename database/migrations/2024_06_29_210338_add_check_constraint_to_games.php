<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*Schema::table('games', function (Blueprint $table) {
            //
        });*/
        DB::statement('ALTER TABLE games ADD CONSTRAINT check_different_teams CHECK (home_team_id <> away_team_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*Schema::table('games', function (Blueprint $table) {
            //
        });*/
        DB::statement('ALTER TABLE games DROP CONSTRAINT check_different_teams');
    }
};
