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
            $table->date('effectivity_date') 
                ->nullable()
                ->after('tos_term');
        });

        Schema::table('syllabus_review_forms', function (Blueprint $table) {
            $table->date('effectivity_date') 
                ->nullable()
                ->after('srf_sem_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tos', function (Blueprint $table) {
            $table->dropColumn('effectivity_date');
        });

        Schema::table('syllabus_review_forms', function (Blueprint $table) {
            $table->dropColumn('effectivity_date');
        });
    }
};
