<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add new columns to user_roles. Run the Migrations
     */
    public function up(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            /*
             |--------------------------------------------------------------
             | Polymorphic reference to the organisation unit
             |--------------------------------------------------------------
             |   - entity_type : "College" or "Department"
             |   - entity_id   : PK of the chosen college/department record
             |
             | We keep them nullable because only Dean/Chairperson roles
             | actually need these fields.
             */
            $table->string('entity_type')       // e.g. 'College' or 'Department'
                  ->nullable()
                  ->after('role_id');

            $table->unsignedBigInteger('entity_id')
                  ->nullable()
                  ->after('entity_type');

            /*
             |--------------------------------------------------------------
             | Validity period of the appointment
             |--------------------------------------------------------------
             */
            $table->date('start_validity')->nullable()->after('entity_id');
            $table->date('end_validity')->nullable()->after('start_validity');

            // Helpful composite and single‑column indexes
            $table->index(['entity_type', 'entity_id'], 'user_roles_entity_idx');
            $table->index('start_validity');
            $table->index('end_validity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            // Drop indexes first (names must match those in up())
            $table->dropIndex('user_roles_entity_idx');
            $table->dropIndex(['start_validity']);
            $table->dropIndex(['end_validity']);

            // Then drop the columns
            $table->dropColumn([
                'entity_type',
                'entity_id',
                'start_validity',
                'end_validity',
            ]);
        });
    }
};
