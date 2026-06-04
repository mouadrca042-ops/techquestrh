<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcours_user', function (Blueprint $table) {
            $table->enum('niveau_depart', ['debutant', 'intermediaire', 'expert'])
                  ->nullable()
                  ->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('parcours_user', function (Blueprint $table) {
            $table->dropColumn('niveau_depart');
        });
    }
};
