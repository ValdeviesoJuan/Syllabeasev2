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
        Schema::create('srf_checklists', function (Blueprint $table) {
            $table->id('srf_checklist_id');
            $table->unsignedBigInteger('srf_id');
            $table->integer('srf_no');
            $table->string('srf_yes_no');
            $table->text('srf_remarks')->nullable();;
            $table->timestamps();

            $table->foreign('srf_id')->references('srf_id')->on('syllabus_review_forms')->onDelete('cascade');

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srf_checklists');
    }
};
