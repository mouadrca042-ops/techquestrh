<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progressions', function (Blueprint $table) {
            // Index de la question où l'employé s'est arrêté (point de situation du quiz).
            $table->integer('question_courante')->default(0)->after('tentatives');
        });
    }

    public function down(): void
    {
        Schema::table('progressions', function (Blueprint $table) {
            $table->dropColumn('question_courante');
        });
    }
};
