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
        Schema::create('bayanihan_members', function (Blueprint $table) {
            $table->id('bm_id');
            $table->unsignedBigInteger('bm_user_id');
            $table->unsignedBigInteger('bg_id');
            $table->timestamps();

            $table->foreign('bm_user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('bg_id')->references('bg_id')->on('bayanihan_groups')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayanihan_members');
    }
};
