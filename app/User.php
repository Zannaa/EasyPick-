<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name',
        'email',
        'password',
        'verifikovan',
        'ban',
        'vrijeme_bana',
        'dodatno_korisnik',
        'telefon',
        'drzava',
        'grad'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin'
    ];

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
        return $this->belongsTo('App\Models\KorisnikDodatno', 'dodatno_korisnik');
    }
}
