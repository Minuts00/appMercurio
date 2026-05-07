<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anagraphics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('fiscalCode')->nullable();
            $table->string('identityDoc')->nullable();
            $table->string('mail')->nullable();
            $table->string('address')->nullable();
            $table->string('POD')->nullable();
            $table->string('PDR')->nullable();
            $table->string('RID')->nullable();
            $table->string('lightOffer')->nullable();
            $table->string('gasOffer')->nullable();
            $table->boolean('telco')->nullable();
            $table->string('note')->nullable();
            $table->string('boNote')->nullable();
            $table->foreignId('id_campaign')->constrained('campaigns')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anagraphics');
    }
};