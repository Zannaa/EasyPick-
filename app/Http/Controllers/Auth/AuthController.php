<?php

namespace App\Http\Controllers\Auth;

use App\Models\Korisnik;
use App\User;
use App\Models\KorisnikDodatno;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $dodatno = new KorisnikDodatno();

        if (isset($data['telefon']) || isset($data['drzava']) || isset ($data['grad']))
        {
            $dodatno->telefon=$data['telefon'];
            $dodatno->grad=$data['grad'];
            $dodatno->drzava=$data['drzava'];
            $dodatno->save();
        }

        $korisnik = new User();
        $korisnik->name = $data['name'];
        $korisnik->email = $data['email'];
        $korisnik->password = bcrypt($data['password']);
        $korisnik->verifikovan = 0;
        $korisnik->dodatno_korisnik = $dodatno->id;
        $korisnik->save();

        return $korisnik;
    }
}
