<?php

namespace App\Http\Controllers;

use App\Models\Poruka;
use Illuminate\Http\Request;

use App\Http\Requests;

class PorukaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Poruka::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function dajPoruku($id)
    {
        return Poruka::where('id', $id)->get();
    }

    public function dajPorukuOglas($id_oglas)
    {
        return Poruka::where('oglas', $id_oglas)->get();
    }

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
       $poruka=new Poruka();


        $poruka->tekst=$request->input('tekst');
        $poruka->korisnik1_id=$request->input('korisnik1_id');
        $poruka->korisnik2_id=$request->input('korisnik2_id');
        $poruka->oglas=$request->input('oglas');
        $poruka->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Poruka::find($id);

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





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Poruka::destroy($id);
    }
}
