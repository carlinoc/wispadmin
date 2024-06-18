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
        Schema::create('movistardeco', function (Blueprint $table) {
            $table->id();
            $table->string('CASID');
            $table->string('CardNumber')->nullable();
            $table->string('MarkCode');
            $table->string('Photo1')->nullable();
            $table->tinyInteger('State');
            $table->tinyInteger('DecoType');
            $table->text('Description')->nullable();
            $table->foreignId('contractId')->constrained('contract')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movistardeco');
    }
};
