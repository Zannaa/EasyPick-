<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class KorisnikDodatno
 */
class KorisnikDodatno extends Model
{
    protected $table = 'korisnik_dodatno';

    public $timestamps = false;

    protected $fillable = [
        'telefon',
        'drzava',
        'grad'
    ];

    protected $guarded = [];

    public function korisnik()
    {
        return $this->hasOne('App\Models\Korisnik', 'korisnik_dodatno');
    }
        
}