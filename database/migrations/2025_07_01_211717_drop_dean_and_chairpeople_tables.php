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
        Schema::dropIfExists('deans');
        Schema::dropIfExists('chairpeople');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('deans', function ($table) {
            $table->id('dean_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('college_id');
            $table->date('start_validity')->nullable();
            $table->date('end_validity')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('college_id')->references('college_id')->on('college')->onDelete('cascade');
        });

        Schema::create('chairpeople', function ($table) {
            $table->id('chair_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department_id');
            $table->date('start_validity')->nullable();
            $table->date('end_validity')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('department')->onDelete('cascade');
        });
    }
};
