<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('bayanihan_members');
        Schema::dropIfExists('bayanihan_leaders');
    }
};
