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
            $table->boolean('immeuble_etage')->default(false)->after('visites_demandees');
            $table->boolean('meuble')->default(false)->after('immeuble_etage');
            $table->boolean('climatise')->default(false)->after('meuble');
            $table->boolean('sanitaire')->default(false)->after('climatise');
            $table->boolean('adapte_pmr')->default(false)->after('sanitaire');
            $table->boolean('compteur_elec_perso')->default(false)->after('adapte_pmr');
            $table->boolean('compteur_eau_perso')->default(false)->after('compteur_elec_perso');
            
            $table->integer('caution_mois')->nullable()->after('compteur_eau_perso');
            $table->integer('prepaiement_mois')->nullable()->after('caution_mois');
            $table->integer('frais_visite')->nullable()->after('prepaiement_mois');
            $table->integer('commission')->nullable()->after('frais_visite');
            $table->integer('caution_elec')->nullable()->after('commission');
            $table->integer('caution_eau')->nullable()->after('caution_elec');
            $table->integer('caution_elec_eau')->nullable()->after('caution_eau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maisons', function (Blueprint $table) {
            $table->dropColumn([
                'immeuble_etage',
                'meuble',
                'climatise',
                'sanitaire',
                'adapte_pmr',
                'compteur_elec_perso',
                'compteur_eau_perso',
                'caution_mois',
                'prepaiement_mois',
                'frais_visite',
                'commission',
                'caution_elec',
                'caution_eau',
                'caution_elec_eau',
            ]);
        });
    }
};