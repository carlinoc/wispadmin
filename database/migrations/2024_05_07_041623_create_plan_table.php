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
        Schema::create('plan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateOrder')->nullable(false);
            $table->dateTime('dateInstall')->nullable(false);
            $table->dateTime('dateInactivity')->nullable();
            $table->decimal('paymentAmount', $precision=8, $escala=2)->default(0)->nullable(false);
            $table->boolean('active')->default(true);
            $table->tinyInteger('planType');
            $table->foreignId('clientId')->constrained('client')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan');
    }
};
