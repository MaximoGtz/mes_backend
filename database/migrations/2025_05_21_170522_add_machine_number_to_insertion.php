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
        Schema::table('insertions', function (Blueprint $table) {
            $table->unsignedInteger("machine_number");
            $table->foreign("machine_number")
                ->references("number")->on("profilers")
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insertions', function (Blueprint $table) {
            $table->dropForeign(["machine_number"]);
            $table->dropColumn('machine_number');
        });
    }
};
