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
        Schema::table('bayanihan_group', function (Blueprint $table) {
            $table->string('bg_semester')
                ->nullable()
                ->after('bg_school_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bayanihan_group', function (Blueprint $table) {
            $table->dropColumn('bg_semester');
        });
    }
};
