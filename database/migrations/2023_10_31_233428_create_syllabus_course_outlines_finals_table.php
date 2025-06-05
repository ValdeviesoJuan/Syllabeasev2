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
        Schema::create('syllabus_course_outlines_finals', function (Blueprint $table) {
            $table->id('syll_co_out_id');
            $table->unsignedBigInteger('syll_id');  
            $table->integer('syll_allotted_hour');
            $table->text('syll_allotted_time')->default('')->nullable();
            $table->text('syll_intended_learning')->default('')->nullable();
            $table->text('syll_topics');
            $table->text('syll_suggested_readings')->default('')->nullable();
            $table->text('syll_learning_act')->default('')->nullable();
            $table->text('syll_asses_tools')->default('')->nullable();
            $table->text('syll_grading_criteria')->default('')->nullable();
            $table->text('syll_remarks')->default('')->nullable();
            $table->integer('syll_row_no')->nullable();;

            $table->timestamps();
            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_course_outlines_finals');
    }
};
