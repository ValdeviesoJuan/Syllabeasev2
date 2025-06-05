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
        Schema::create('deadlines', function (Blueprint $table) {
            $table->id('dl_id');
            $table->dateTime('dl_syll')->nullable()->default(null);
            $table->dateTime('dl_tos_midterm')->nullable()->default(null);
            $table->dateTime('dl_tos_final')->nullable()->default(null);
            $table->unsignedBigInteger('user_id');
            $table->string('dl_school_year');
            $table->string('dl_semester');
            $table->unsignedBigInteger('college_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('college_id')->references('college_id')->on('colleges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadlines');
    }
};
