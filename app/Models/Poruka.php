<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Poruka
 */
class Poruka extends Model
{
    protected $table = 'poruka';

    public $timestamps = false;

    protected $fillable = [
        'tekst',
        'korisnik1_id',
        'korisnik2_id',
        'oglas'
    ];

    protected $guarded = [];

        
}