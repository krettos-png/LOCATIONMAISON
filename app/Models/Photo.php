<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [ 'maison_id','chemin'];

    public function maison()
    {
        return $this->belongsTo(Maison::class);
    }
}

