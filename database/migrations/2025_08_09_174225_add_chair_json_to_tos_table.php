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
        Schema::table('tos', function (Blueprint $table) {
            $table->json('chair')->nullable()->after('tos_cpys'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tos', function (Blueprint $table) {
            $table->dropColumn('chair');
        });
    }
};
