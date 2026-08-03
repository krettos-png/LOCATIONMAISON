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
    Schema::create('paiements', function (Blueprint $table) {
        $table->id();
        // Relation avec le contrat
        $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade');
        
        $table->double('montant', 10, 2);
        $table->string('mois_concerne'); // Ex: "Juillet 2026"
        $table->date('date_concerne');
        $table->string('type')->default('0'); // 0 pour loyer, 1 pour caution, etc.
        $table->string('statut')->default('En attente'); // En attente, Payé, Échoué
        $table->string('moyen_paiement')->nullable(); // Stripe, T-Money, Flooz, Cash
        $table->string('transaction_id')->nullable(); // ID unique de l'API de paiement
        $table->timestamp('date_paiement')->nullable();

        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
