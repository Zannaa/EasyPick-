<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorit
 */
class Favorit extends Model
{
    protected $table = 'favorit';

    public $timestamps = false;

    protected $fillable = [
        'oglas_id',
        'korisnik_id'
    ];

    protected $guarded = [];

        
}