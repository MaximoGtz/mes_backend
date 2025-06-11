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
        Schema::table('justifications', function (Blueprint $table) {
            $table->unsignedBigInteger("profiler_id");
            $table->foreign("profiler_id")
                ->references("id")->on("profilers")
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('justifications', function (Blueprint $table) {
             $table->dropForeign(["profiler_id"]);
            $table->dropColumn('profiler_id');
        });
    }
};
