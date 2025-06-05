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
        Schema::create('tos_rows', function (Blueprint $table) {
            $table->id('tos_r_id');
            $table->unsignedBigInteger('tos_id');
            $table->text('tos_r_topic')->nullable();
            $table->integer('tos_r_no_hours')->nullable();
            $table->integer('tos_r_percent')->nullable();
            $table->integer('tos_r_no_items')->nullable();
            $table->decimal('tos_r_col_1')->nullable();
            $table->decimal('tos_r_col_2')->nullable();
            $table->decimal('tos_r_col_3')->nullable();
            $table->decimal('tos_r_col_4')->nullable();

            $table->timestamps();
            $table->foreign('tos_id')->references('tos_id')->on('tos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tos_rows');
    }
};
