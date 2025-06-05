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
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id');
            $table->string('department_code');
            $table->string('department_name');
            $table->string('program_code');
            $table->string('program_name');
            $table->string('department_status');
            $table->unsignedBigInteger('college_id');
            $table->timestamps();

            $table->foreign('college_id')->references('college_id')->on('colleges')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
