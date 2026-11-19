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
    Schema::create('guitar_specifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('guitar_id')
              ->unique()
              ->constrained()
              ->cascadeOnDelete();

        $table->string('body_material');
        $table->string('pickup_type');
        $table->integer('number_of_strings')->default(6);
        $table->string('color');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guitar_specifications');
    }
};
