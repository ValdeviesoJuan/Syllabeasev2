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
        Schema::create('syllabus_course_outcomes', function (Blueprint $table) {
            $table->id('syll_co_id');
            $table->string('syll_co_code');
            $table->text('syll_co_description');
            $table->unsignedBigInteger('syll_id');
            $table->timestamps();

            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_course_outcomes');
    }
};
