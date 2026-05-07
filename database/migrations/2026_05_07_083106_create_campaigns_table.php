<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    
    Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_campaign')->references('id')->on('campaigns')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_campaign']);

        });
        Schema::dropIfExists('campaigns');
    }
};