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
        Schema::create('syllabus_cot_cos_finals', function (Blueprint $table) {
            $table->id('syllabus_cot_co');
            $table->unsignedBigInteger('syll_co_out_id');  
            $table->unsignedBigInteger('syll_co_id');  
            $table->timestamps();

            $table->foreign('syll_co_out_id')->references('syll_co_out_id')->on('syllabus_course_outlines_finals')->onDelete('cascade');
            $table->foreign('syll_co_id')->references('syll_co_id')->on('syllabus_course_outcomes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_cot_cos_finals');
    }
};
