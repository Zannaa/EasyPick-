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



Route::get('/', function () {

    echo 'hello';

});


/*Oglasi servis*/
Route::resource('oglasi', 'OglasController');
Route::get('oglasi/tip/{tip}', 'OglasController@poTipuOglasa');
Route::get('oglasi/{id}/autor', 'OglasController@dajAutora');
Route::get('oglasi/{id}/lokacija', 'OglasController@dajLokaciju');
Route::get('oglasi/{id}/slike', 'OglasController@dajSlike');
Route::post('oglasi/{id}/slike', 'OglasController@dodajSliku');
Route::delete('oglasi/{id}/slike/{slika_id}', 'OglasController@obrisiSliku');

/*Poruke servis */
Route::resource('poruke', 'PorukaController');
Route::get('poruke/oglas/{oglas_id}' , 'PorukaController@dajPorukuOglas') ;

/*Admin servis*/
Route::resource('admini', 'AdminController');
Route::get('admini/username/{username}','AdminController@poUsername');
Route::delete('admini/username/{username}','AdminController@brisanjePoUsername');
Route::put('admini/username/{username}', 'AdminController@urediPoUsername');


/*Korisnik servis*/
Route::post('prijava', 'KorisnikController@login');
Route::resource('korisnici', 'KorisnikController');
Route::get('korisnici/email/{email}', 'KorisnikController@poEmail');
Route::put('korisnici/email/{email}', 'KorisnikController@urediPoEmail');
Route::delete('korisnici/email/{email}','KorisnikController@brisanjePoEmail' );
Route::get('korisnici/ban/{ban}', 'KorisnikController@poBan');
Route::post('korisnici/ban/{id}', 'KorisnikController@dodajBan');
Route::delete('korisnici/ban/{id}', 'KorisnikController@ukloniBan');
Route::post('korisnici/{id}/favoriti', 'KorisnikController@dajFavorite');
Route::post('korisnici/{id_korisnika}/favoriti/{id_favorita}', 'KorisnikController@dodajFavorit');
Route::delete('korisnici/favoriti/{id_favorita}', 'KorisnikController@izbrisiFavorit');

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

});
