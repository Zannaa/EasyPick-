<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 */
class Admin extends Model
{
    protected $table = 'admin';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'lozinka',
        'ime',
        'prezime'
    ];

    protected $guarded = [];

        
}