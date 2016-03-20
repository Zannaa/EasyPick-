<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slika
 */
class Slika extends Model
{
    protected $table = 'slika';

    public $timestamps = false;

    protected $fillable = [
        'slika',
        'oglas_id'
    ];

    protected $guarded = [];

        
}