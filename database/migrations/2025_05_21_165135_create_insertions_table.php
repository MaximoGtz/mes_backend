<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('insertions', function (Blueprint $table) {
            $table->id();
            $table->integer("recipe_number");
            $table->integer("profile_length");
            $table->integer("distance_between_holes");
            $table->float("length_before_reset");
            $table->boolean("good_piece");
            $table->integer("cicle_time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insertions');
    }
};
