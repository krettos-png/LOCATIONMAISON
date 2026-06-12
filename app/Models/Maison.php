<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maison extends Model
{
    // Indique explicitement le nom de la table si Laravel ne la devine pas au pluriel
    protected $table = 'maisons'; 

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'vues',
        'est_loue',
        'adresse',
        'image',
        'latitude',
        'longitude',
        'utilisateur_id',
        'categorie_id',
        'ville',
        'visites_demandees',
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
        'caution_elec_eau'
    ];

    // Cast des types de données pour manipuler plus facilement les booléens (tinyint)
    protected $casts = [
        'est_loue'            => 'boolean',
        'immeuble_etage'      => 'boolean',
        'meuble'              => 'boolean',
        'climatise'           => 'boolean',
        'sanitaire'           => 'boolean',
        'adapte_pmr'          => 'boolean',
        'compteur_elec_perso' => 'boolean',
        'compteur_eau_perso'  => 'boolean',
        'prix'                => 'integer',
        'latitude'            => 'decimal:7',
        'longitude'           => 'decimal:7',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}