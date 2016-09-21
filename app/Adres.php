<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adres extends Model
{
        protected $fillable = [
        'id',
        'straat',
        'huisnummer',
        'toevoeging', 
        'postcode', 
        'plaats', 
        'naam'
        
    ];
    public $timestamps = false;
}
