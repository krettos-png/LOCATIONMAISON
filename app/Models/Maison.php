<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maison extends Model
{
    protected $fillable = ['titre', 'description', 'prix', 'adresse', 'image', 'time'];


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


