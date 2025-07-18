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
        Schema::create('bayanihan_group_users', function (Blueprint $table) {
            $table->id('bgu_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bg_id');
            $table->enum('bg_role', ['leader', 'member']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bg_id')->references('bg_id')->on('bayanihan_groups')->onDelete('cascade');

            $table->unique(['user_id', 'bg_id', 'bg_role']); // prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayanihan_group_users');
    }
};
