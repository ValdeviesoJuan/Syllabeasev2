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
        Schema::create('program_outcomes', function (Blueprint $table) {
            $table->id('po_id');
            $table->unsignedBigInteger('department_id');
            $table->string('po_letter');
            $table->text('po_description');
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_outcomes');
    }
};
