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
        Schema::create('switcher', function (Blueprint $table) {
            $table->id();
            $table->string('serie')->nullable();
            $table->integer('numberOfPorts')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('brandNameId')->constrained('brandName')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('switcher');
    }
};
