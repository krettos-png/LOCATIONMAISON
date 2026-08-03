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
    Schema::create('contrats', function (Blueprint $table) {
        $table->id();
        
        // Clé étrangère vers ta table 'utilisateurs' (le locataire)
        $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
        
        // Clé étrangère vers ta table 'maisons' (le logement)
        $table->foreignId('maison_id')->constrained('maisons')->onDelete('cascade');
        
        // Informations du bail
        $table->date('date_debut');
        $table->string('statut')->default('actif'); // actif, terminé, etc.
        $table->string('motif')->nullable(); // Motif de résiliation ou autre
        $table->date('date_fin')->nullable(); // Date de fin du contrat, si
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
