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
        Schema::create('syllabus_dean_feedbacks', function (Blueprint $table) {
            $table->id('syllabus_dean_feedback_id');
            $table->unsignedBigInteger('syll_id');
            $table->unsignedBigInteger('user_id');
            $table->text('syll_dean_feedback_text');
            $table->timestamp('syll_dean_feedback_created_at');
            $table->timestamps();

            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllbus_dean_feedback');
    }
};
