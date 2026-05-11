<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Nom de la table (si non standard)

    protected $fillable = [
        'nom',
        'description'];


    // 🔁 Relation : une categorie possède plusieurs maisons
    public function maisons(): HasMany
    {
        return $this->hasMany(Maison::class);
    }
}
