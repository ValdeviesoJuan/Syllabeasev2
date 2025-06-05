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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->unsignedBigInteger('curr_id');
            $table->string('course_title');
            $table->string('course_code');
            $table->string('course_unit_lec');
            $table->string('course_unit_lab');
            $table->string('course_credit_unit');
            $table->string('course_hrs_lec');
            $table->string('course_hrs_lab');
            $table->string('course_pre_req');
            $table->string('course_co_req');
            $table->string('course_year_level');
            $table->string('course_semester');
            $table->timestamps();


            $table->foreign('curr_id')->references('curr_id')->on('curricula')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
