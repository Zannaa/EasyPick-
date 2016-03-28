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

        $oglas->grijanje = $request->input('grijanje');
        $oglas->struja = $request->input('struja');
        $oglas->voda = $request->input('voda');
        $oglas->telefon = $request->input('telefon');
        $oglas->kablovska = $request->input('kablovska');
        $oglas->internet = $request->input('internet');
        $oglas->garaza = $request->input('garaza');

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
        $oglas = Oglas::find($id);

        if ($request->has('naziv')) {
            $oglas->naziv = $request->input('naziv');
        }

        if ($request->has('tip')) {
            $oglas->tip_oglasa = $request->input('tip');
        }

        if ($request->has('status')) {
            $oglas->status_oglasa = $request->input('status');
        }

        if ($request->has('cijena')) {
            $oglas->cijena = $request->input('cijena');
        }

        if ($request->has('povrsina')) {
            $oglas->povrsina = $request->input('povrsina');
        }

        if ($request->has('stanje')) {
            $oglas->stanje = $request->input('stanje');
        }

        if ($request->has('opis')) {
            $oglas->opis = $request->input('opis');
        }

        $lokacija = $this->dajLokaciju($id);
        
        if ($request->has('drzava')) {
            $lokacija->drzava = $request->input('drzava');
        }

        if ($request->has('kanton')) {
            $lokacija->kanton = $request->input('kanton');
        }

        if ($request->has('grad')) {
            $lokacija->grad = $request->input('grad');
        }

        if ($request->has('opstina')) {
            $lokacija->opstina = $request->input('opstina');
        }

        if ($request->has('adresa')) {
            $lokacija->adresa = $request->input('adresa');
        }

        if ($request->has('grijanje')) {
            $oglas->grijanje = $request->input('grijanje');
        }

        if ($request->has('struja')) {
            $oglas->struja = $request->input('struja');
        }

        if ($request->has('voda')) {
            $oglas->voda = $request->input('voda');
        }

        if ($request->has('telefon')) {
            $oglas->telefon = $request->input('telefon');
        }

        if ($request->has('kablovska')) {
            $oglas->kablovska = $request->input('kablovska');
        }

        if ($request->has('internet')) {
            $oglas->internet = $request->input('internet');
        }

        if ($request->has('garaza')) {
            $oglas->garaza = $request->input('garaza');
        }

        $lokacija->save();
        $oglas->save();

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
