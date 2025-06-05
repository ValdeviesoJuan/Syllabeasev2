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
        Schema::create('header_comments', function (Blueprint $table) {
            $table->id('header_comment_id');
            $table->unsignedBigInteger('syll_id');
            $table->text('header_comment_text');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('header_comment_created_at');
            $table->timestamp('header_comment_resolved_at')->nullable();;
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_comments');
    }
};
