<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Bewertung extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'bewertungen';
    const CREATED_AT = 'bewertungszeitpunkt';

    public function gericht() {
        return $this->belongsTo(Gericht::class);
    }
}
