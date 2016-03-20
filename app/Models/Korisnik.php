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

        
}