<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_category')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('id_subcategory')->constrained('subcategories')->cascadeOnDelete();
            $table->text('responses');
            $table->foreignId('id_campaign')->constrained('campaigns')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};