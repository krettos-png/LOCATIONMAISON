<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Utilisateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'utilisateurs'; // Nom de la table (si non standard)

    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'email',
        'password',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    // 🔁 Relation : un utilisateur possède plusieurs maisons
    public function maisons(): HasMany
    {
        return $this->hasMany(Maison::class);
    }
}
