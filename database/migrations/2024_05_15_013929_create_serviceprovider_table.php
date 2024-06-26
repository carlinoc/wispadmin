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
        Schema::create('serviceprovider', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('InternetService', 0);
            $table->boolean('CableService', 0);
            $table->text('description')->nullable();
            $table->foreignId('providerId')->constrained('provider')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serviceprovider');
    }
};
