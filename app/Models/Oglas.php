<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Oglas
 */
class Oglas extends Model
{
    protected $table = 'oglas';

    public $timestamps = false;

    protected $fillable = [
        'naziv',
        'tip_oglasa',
        'status_oglasa',
        'povrsina',
        'cijena',
        'stanje',
        'opis',
        'lokacija_id',
        'autor_id',
        'datum_objave',
        'grijanje',
        'struja',
        'voda',
        'telefon',
        'kablovska',
        'internet',
        'garaza'
    ];

    protected $guarded = [];

        
}