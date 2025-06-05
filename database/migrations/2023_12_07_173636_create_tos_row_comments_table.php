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
        Schema::create('tos_row_comments', function (Blueprint $table) {
            $table->id('tos_r_comment_id');
            $table->unsignedBigInteger('tos_r_id');
            $table->integer('col_no');
            $table->text('tos_r_comment_text');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('tos_r_comment_created_at');
            $table->timestamp('tos_r_comment_resolved_at')->nullable();;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tos_r_id')->references('tos_r_id')->on('tos_rows')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tos_row_comments');
    }
};
