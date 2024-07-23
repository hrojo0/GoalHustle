<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();



            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('season', 255); 
            $table->integer('rounds')->default(1);
            $table->string('logo', 255)->nullable();
            $table->boolean('is_featured')->default(1);

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
