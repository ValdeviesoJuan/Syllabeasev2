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
        Schema::create('tos', function (Blueprint $table) {
            $table->id('tos_id');
            $table->unsignedBigInteger('syll_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tos_term');
            $table->integer('tos_no_items');
            $table->integer('col_1_per');
            $table->integer('col_2_per');
            $table->integer('col_3_per');
            $table->integer('col_4_per');

            $table->integer('col_1_exp')->nullable();
            $table->integer('col_2_exp')->nullable();
            $table->integer('col_3_exp')->nullable();
            $table->integer('col_4_exp')->nullable();

            $table->timestamps();

            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('bg_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->text('tos_cpys')->nullable();

            $table->timestamp('chair_submitted_at')->nullable();
            $table->timestamp('chair_returned_at')->nullable();
            $table->timestamp('chair_approved_at')->nullable();

            $table->string('tos_status')->nullable();
            $table->integer('tos_version')->nullable()->default(1);

            $table->foreign('syll_id')->references('syll_id')->on('syllabi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
            $table->foreign('bg_id')->references('bg_id')->on('bayanihan_groups')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tos');
    }
};
