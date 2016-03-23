<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lokacija
 */
class Lokacija extends Model
{
    protected $table = 'lokacija';

    public $timestamps = false;

    protected $fillable = [
        'drzava',
        'kanton',
        'grad',
        'opstina',
        'adresa',
        'koordinata_x',
        'koordinata_y'
    ];

    protected $guarded = [];

    public function oglas()
    {
        return $this->hasOne('App\Models\Oglas');
    }
}