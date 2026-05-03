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
    Schema::create('defis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('parcours_id')->constrained()->onDelete('cascade');
        $table->string('titre');
        $table->enum('type', ['qcm', 'vrai_faux']);
        $table->enum('niveau', ['debutant', 'intermediaire', 'expert']);
        $table->integer('xp_recompense');
        $table->json('contenu_json');
        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defis');
    }
};
