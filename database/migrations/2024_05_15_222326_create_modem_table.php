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
        Schema::create('modem', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('MAC');
            $table->string('DefaultUrl')->nullable();;
            $table->string('DefaultWifiName')->nullable();;
            $table->string('DefaultWifiPassword')->nullable();;
            $table->string('photo', 500)->nullable();
            $table->string('MarkCode')->nullable();;
            $table->tinyInteger('ConnectionType');
            $table->tinyInteger('State');
            $table->text('Description')->nullable();
            $table->foreignId('modemTypeId')->constrained('modemtype')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('contractId')->constrained('contract')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modem');
    }
};
