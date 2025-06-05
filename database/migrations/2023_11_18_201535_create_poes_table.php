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
        Schema::create('poes', function (Blueprint $table) {
            $table->id('poe_id');
            $table->unsignedBigInteger('department_id');
            $table->string('poe_code');
            $table->text('poe_description');
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_o_e_s');
    }
};
