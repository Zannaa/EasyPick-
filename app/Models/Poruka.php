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
        'korisnik1_name',
        'korisnik2_name',
        'oglas'
    ];
    
    protected $guarded = [];

    public function snd()
    {
        return $this->belongsTo('App\User', 'korisnik1_id');
    }

    public function rcv()
    {
        return $this->belongsTo('App\User', 'korisnik2_id');
    }

    public function oglas()
    {
        return $this->BelongsTo('App\Oglas', 'oglas');
    }
}