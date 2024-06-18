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
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->dateTime('DateOrder');
            $table->dateTime('DateInstall')->nullable();
            $table->dateTime('DateInactivity')->nullable();
            $table->string('CodeOrder')->nullable();
            $table->string('CodeInstall')->nullable();
            $table->string('CodeInactivity')->nullable();
            $table->integer('PaymentCycle')->default(0);
            $table->decimal('PaymentAmount', $precision=8, $escala=2)->default(0)->nullable(false);
            $table->foreignId('serviceProviderId')->constrained('serviceprovider')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('clientId')->constrained('client')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
