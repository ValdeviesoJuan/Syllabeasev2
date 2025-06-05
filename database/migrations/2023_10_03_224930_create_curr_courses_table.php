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
        Schema::create('curr_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('curr_id');
            $table->unsignedBigInteger('course_id');
            $table->string('school_year');
            $table->timestamps();

            $table->foreign('curr_id')->references('curr_id')->on('curricula')->onDelete('cascade');;
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curr_courses');
    }
};
