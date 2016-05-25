<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Models\Admin;

use App\Models\Poruka;


/*Oglasi servis*/
Route::resource('oglasi', 'OglasController');
Route::get('oglasi/tip/{tip}', 'OglasController@poTipuOglasa');
Route::get('oglasi/{id}/autor', 'OglasController@dajAutora');
Route::get('oglasi/{id}/lokacija', 'OglasController@dajLokaciju');
Route::get('oglasi/{id}/slike', 'OglasController@dajSlike');
Route::post('oglasi/{id}/slike', 'OglasController@dodajSliku');
Route::delete('oglasi/{id}/slike/{slika_id}', 'OglasController@obrisiSliku');
Route::get('oglasi/autor/{id}', 'OglasController@dajOglaseAutora');


/*Poruke servis */
Route::resource('poruke', 'PorukaController');
Route::get('poruke/oglas/{oglas_id}' , 'PorukaController@dajPorukuOglas') ;
Route::get('poruke/korisnik/{korisnik_id}','PorukaController@dajListuZadnjihPoruka');
Route::get('poruke/{sen}/{rec}', 'PorukaController@dajPoruke');

/*Korisnik servis*/

Route::resource('korisnici', 'KorisnikController');
Route::get('korisnici/email/{email}', 'KorisnikController@poEmail');
Route::put('korisnici/email/{email}', 'KorisnikController@urediPoEmail');
Route::delete('korisnici/email/{email}','KorisnikController@brisanjePoEmail' );
Route::get('korisnici/ban/{ban}', 'KorisnikController@poBan');
Route::post('korisnici/ban/{id}', 'KorisnikController@dodajBan');
Route::delete('korisnici/ban/{id}', 'KorisnikController@ukloniBan');
Route::get('korisnici/{id}/favoriti', 'KorisnikController@dajFavorite');
Route::post('korisnici/{id_korisnika}/favoriti/{id_favorita}', 'KorisnikController@dodajFavorit');
Route::delete('korisnici/favoriti/{id_favorita}', 'KorisnikController@izbrisiFavorit');
Route::get('admini', 'KorisnikController@dajAdmine');
Route::get('admini/{id}', 'KorisnikController@dajAdmina');
Route::get('korisnik/{id}/favoriti', 'KorisnikController@dajFavoriteKorisnika');
Route::get('korisnik/favoriti', 'KorisnikController@dajFavoriteTrenutnogKorisnika');
Route::get('korisnik', 'KorisnikController@dajTrenutnogKorisnika');
Route::get('korisnik/oglasi', 'KorisnikController@dajOglaseTKor');


/*Verifikacija korisničkog računa servis */
Route::get('korisnici/verifikuj/{konfirmacijski_kod}', 'KorisnikController@verifikujKorisnika');






/*
 *
 *
 /*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {

        echo 'hello';

    });


    Route::post('prijava', 'KorisnikController@login');

    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    
});

Route::get('/home', 'HomeController@index');

Route::auth();


