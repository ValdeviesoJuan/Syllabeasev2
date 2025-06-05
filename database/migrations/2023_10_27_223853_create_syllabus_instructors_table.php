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
        Schema::create('syllabus_instructors', function (Blueprint $table) {
            $table->id('syll_ins_id');
            $table->unsignedBigInteger('syll_ins_user_id');
            $table->unsignedBigInteger('syll_id');
            $table->timestamps();

            $table->foreign('syll_ins_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_instructors');
    }
};
