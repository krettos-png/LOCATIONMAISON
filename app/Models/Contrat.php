<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    // Autoriser l'attribution de masse sur ces colonnes
    protected $fillable = [
        'utilisateur_id',
        'maison_id',
        'date_debut',
        'statut',
        'motif',
        'date_fin'
    ];

    // Ajoute ceci pour lier les paiements et la maison au contrat
public function paiements() {
    return $this->hasMany(Paiement::class, 'contrat_id');
}

public function maison() {
    return $this->belongsTo(Maison::class, 'maison_id');
}

public function locataire() {
    // Si ta table s'appelle 'utilisateurs', spécifie la clé étrangère 'utilisateur_id'
    return $this->belongsTo(Utilisateur::class, 'utilisateur_id'); 
}
}