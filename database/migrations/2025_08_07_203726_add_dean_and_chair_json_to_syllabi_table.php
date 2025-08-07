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
        Schema::table('syllabi', function (Blueprint $table) {
            $table->json('dean')->nullable()->after('syll_chair');
            $table->json('chair')->nullable()->after('dean');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syllabi', function (Blueprint $table) {
            $table->dropColumn(['dean', 'chair']);
        });
    }
};
