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
    Schema::table('maisons', function (Blueprint $table) {
        // On crée la colonne qui commence à 0
        $table->unsignedBigInteger('visites_demandees')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('maisons', function (Blueprint $table) {
        $table->dropColumn('visites_demandees');
    });
}
};
