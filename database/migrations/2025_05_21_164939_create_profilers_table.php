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
        Schema::create('profilers', function (Blueprint $table) {
            $table->id();
            $table->string("status");
            $table->string("name");
            $table->float("ip");
            $table->string("model");
            $table->unsignedInteger("number")->unique();
            $table->bigInteger("year_model");
            $table->integer("machine_speed");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilers');
    }
};
