<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gericht extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'gericht';
    public function bewertungen() {
        return $this->hasMany(Bewertung::class);
    }
    function getPreisInternAttribute() {
        return number_format($this->attributes['preis_intern'],2);
    }
    function getPreisExternAttribute() {
        return number_format($this->attributes['preis_extern'],2);
    }
    function setVegetarischAttribute($value) {
        $str = str_replace(' ', '', $value);
        $str = strtolower($str);
        if($str == 'yes' || $str == 'ja') {
            $this->attributes['vegetarisch'] = true;
        } else {
            $this->attributes['vegetarisch'] = false;
        }
    }
    function setVeganAttribute($value) {
        $str = str_replace(' ', '', $value);
        $str = strtolower($str);
        if($str == 'yes' || $str == 'ja') {
            $this->attributes['vegan'] = true;
        } else {
            $this->attributes['vegan'] = false;
        }
    }
}
