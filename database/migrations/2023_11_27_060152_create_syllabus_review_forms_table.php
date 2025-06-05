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
        Schema::create('syllabus_review_forms', function (Blueprint $table) {
            $table->id('srf_id');
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('syll_id');
            $table->string('srf_course_code');
            $table->string('srf_title');
            $table->string('srf_sem_year');
            $table->text('srf_faculty');
            $table->date('srf_date');
            $table->string('srf_reviewed_by');
            $table->boolean('srf_action');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_review_forms');
    }
};
