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
        Schema::create('co_comments', function (Blueprint $table) {
            $table->id('co_comment_id');
            $table->unsignedBigInteger('syll_co_id');
            $table->text('co_comment_text');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('co_comment_created_at');
            $table->timestamp('co_comment_resolved_at')->nullable();;
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('syll_co_id')->references('syll_co_id')->on('syllabus_course_outcomes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_o_comments');
    }
};
