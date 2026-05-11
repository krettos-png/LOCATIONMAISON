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
        // On ajoute la colonne qui va pointer vers la table categories
        $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('maisons', function (Blueprint $table) {
        $table->dropForeign(['categorie_id']);
        $table->dropColumn('categorie_id');
    });
}
};
