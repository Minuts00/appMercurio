<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE scripts MODIFY responses MEDIUMTEXT NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE scripts MODIFY responses TEXT NOT NULL');
    }
};