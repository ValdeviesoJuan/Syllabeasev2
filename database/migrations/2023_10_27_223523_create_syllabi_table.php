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
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id('syll_id');
            $table->unsignedBigInteger('bg_id');
            $table->text('syll_class_schedule');
            $table->string('syll_bldg_rm');
            $table->text('syll_ins_consultation');
            $table->text('syll_ins_bldg_rm');
            $table->text('syll_course_description');
            $table->timestamps();

            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('curr_id');

            $table->text('syll_course_requirements')->default('')->nullable();

            $table->timestamp('chair_submitted_at')->nullable();
            $table->timestamp('dean_submitted_at')->nullable();
            $table->timestamp('chair_rejected_at')->nullable();
            $table->timestamp('dean_rejected_at')->nullable();
            $table->timestamp('dean_approved_at')->nullable();

            $table->string('status')->nullable();
            $table->string('version')->nullable();

            $table->foreign('bg_id')->references('bg_id')->on('bayanihan_groups')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');
            $table->foreign('college_id')->references('college_id')->on('colleges')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
            $table->foreign('curr_id')->references('curr_id')->on('curricula')->onDelete('cascade');
            
            $table->text('syll_dean');
            $table->text('syll_chair');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabi');
    }
};
