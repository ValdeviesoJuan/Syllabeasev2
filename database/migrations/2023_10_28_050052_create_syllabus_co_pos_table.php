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
        Schema::create('syll_co_pos', function (Blueprint $table) {
            $table->id('syll_co_po_id');
            $table->unsignedBigInteger('syll_co_id');    
            $table->unsignedBigInteger('syll_po_id');
            $table->string('syll_co_po_code')->default('')->nullable();//letter              
            $table->unsignedBigInteger('syll_id');  
            $table->timestamps();

            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus_co_pos');
    }
};
