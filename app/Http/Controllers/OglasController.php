<?php

namespace App\Http\Controllers;

use App\Models\Oglas;
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
        //
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
        Oglas::destroy($id);
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
}
