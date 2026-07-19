<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['contrat_id', 'montant', 'mois_concerne', 'statut', 'moyen_paiement', 'transaction_id', 'date_paiement'];

public function contrat() {
    return $this->belongsTo(Contrat::class);
}
}
