<?php

namespace App\Http\Controllers;

use App\Models\Oglas;
use App\Models\Lokacija;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class OglasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Oglas::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $oglas = new Oglas;
        $oglas->naziv = $request->input('naziv');
        $oglas->tip_oglasa = $request->input('tip');
        $oglas->cijena = $request->input('cijena');
        $oglas->povrsina = $request->input('povrsina');
        $oglas->stanje = $request->input('stanje');
        $oglas->opis = $request->input('opis');

        $lokacija = new Lokacija;
        $lokacija->drzava = $request->input('drzava');
        $lokacija->kanton = $request->input('kanton');
        $lokacija->grad = $request->input('grad');
        $lokacija->opstina = $request->input('opstina');
        $lokacija->adresa = $request->input('adresa');
        $lokacija->save();
        $oglas->lokacija_id = $lokacija->id;

        $oglas->autor_id = $request->input('autor_id');
        $oglas->datum_objave = Carbon::now();
        $oglas->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Oglas::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oglas = Oglas::find($id);
        $oglas->lokacija()->delete();
        $oglas->delete();
    }

    
    public function poTipuOglasa($tip)
    {
        return Oglas::where('tip_oglasa', $tip)->get();
    }

    public function dajAutora($id)
    {
        return Oglas::find($id)->autor;
    }

    public function dajLokaciju($id)
    {
        return Oglas::find($id)->lokacija;
    }

    public function dajSlike($id)
    {
        return Oglas::find($id)->slike;
    }

    public function dajFavorite($id)
    {
        return Oglas::find($id)->favoriti;
    }


}
