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
    Schema::create('progressions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('defi_id')->constrained()->onDelete('cascade');
<<<<<<< HEAD
        $table->float('score')->default(0);
=======
        $table->float('score', 10, 2)->default(0);
>>>>>>> 510ce3d9d6766b1930a6ad94d335fa3374d9fde3
        $table->integer('tentatives')->default(0);
        $table->datetime('completed_at')->nullable();
        $table->timestamps();
    });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progressions');
    }
};
