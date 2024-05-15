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
        Schema::create('streamingtvprofile', function (Blueprint $table) {
            $table->id();
            $table->string('profile');
            $table->text('accessCode');
            $table->foreignId('streamingTvId')->constrained('streamingtv')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamingtvprofile');
    }
};
