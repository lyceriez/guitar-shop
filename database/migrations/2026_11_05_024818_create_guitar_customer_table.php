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
    Schema::create('guitar_customer', function (Blueprint $table) {
        $table->id();

        $table->foreignId('customer_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('guitar_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->date('purchase_date');

        $table->timestamps();

        $table->unique(['customer_id', 'guitar_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guitar_customer');
    }
};
