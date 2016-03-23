<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Korisnik
 */
class Korisnik extends Model
{
    protected $table = 'korisnik';

    public $timestamps = false;

    protected $fillable = [
        'ime',
        'prezime',
        'email',
        'lozinka',
        'verifikovan',
        'ban',
        'vrijeme_bana',
        'create_time',
        'dodatno_korisnik'
    ];

    protected $guarded = [];

    public function oglasi()
    {
        return $this->hasMany('App\Models\Oglas', 'autor_id');
    }

    public function favoriti()
    {
        return $this->hasMany('App\Models\Favorit');
    }

    public function dodatno()
    {
        return $this->belongsTo('App\Models\KorisnikDodatno', 'korisnik_dodatno');
    }
        
}