<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaiementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('paiements')->insert([
            [
                'contrat_id'     => 1,
                'montant'        => 50000,
                'type'=> '0',
                'mois_concerne'  => 'Janvier 2026',
                'statut'         => 'paye',
                'date_concerne' => now(),
                'moyen_paiement' => 'Mobile Money',
                'transaction_id' => 'TX123456789',
                'date_paiement'  => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}