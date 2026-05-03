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
    Schema::create('badges', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->string('description');
        $table->enum('condition_type', [
            'premier_defi',
            'assidu',
            'maitrise',
            'explorateur',
            'secret'
        ]);
        $table->integer('condition_valeur')->default(1);
        $table->string('image')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
