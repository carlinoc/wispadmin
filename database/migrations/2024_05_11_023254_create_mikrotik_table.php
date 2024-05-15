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
        Schema::create('mikrotik', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('Model');
            $table->string('MAC');
            $table->string('Identity')->nullable();;
            $table->string('AccessCodeUrl')->nullable();;
            $table->string('AccessCodeUser')->nullable();;
            $table->string('AccessCodePassword')->nullable();;
            $table->string('photo', 500)->nullable();
            $table->tinyInteger('State');
            $table->text('Description')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik');
    }
};
