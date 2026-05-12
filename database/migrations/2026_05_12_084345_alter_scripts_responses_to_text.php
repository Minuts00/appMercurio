<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE scripts MODIFY responses TEXT NOT NULL');
    }

    public function down(): void
    {
        Schema::table('scripts', function (Blueprint $table) {
            $table->string('responses')->change();
        });
    }
};