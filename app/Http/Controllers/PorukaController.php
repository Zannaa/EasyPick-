<?php

namespace App\Http\Controllers;

use App\Models\Poruka;
use Illuminate\Http\Request;

use App\Http\Requests;
use JWTAuth;
use Illuminate\Http\Response as HttpResponse;

class PorukaController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if($user->admin){
            return Poruka::all();
        }
        else return response()->json(['error' => 'No authorization to see Poruke'], HttpResponse::HTTP_UNAUTHORIZED);

    }
    
    public function dajPorukuOglas($id_oglas)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $sveporuke = Poruka::where('oglas', $id_oglas)->get();
        $poruke = array();
        foreach ($sveporuke as $poruka){
            if($poruka->korisnik1_id == $user->id || $poruka->korisnik2_id == $user->id || $user->admin){
                $poruke[] = (array)$poruka;
            }
        }
        if (!is_null($poruke))
            return $poruke;
        else return response()->json(['error' => 'No authorization to see Poruke'], HttpResponse::HTTP_UNAUTHORIZED);
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
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $poruka = Poruka::find($id);
        if($poruka->korisnik1_id == $user->id || $poruka->korisnik2_id == $user->id || $user->admin){
            return $poruka;
        }
        else return response()->json(['error' => 'No authorization to see Poruka'], HttpResponse::HTTP_UNAUTHORIZED);

    }

    public function destroy($id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $poruka = Poruka::find($id);
        if($poruka->korisnik1_id == $user->id || $poruka->korisnik2_id == $user->id || $user->admin){
            $poruka->delete();
        }
        else return response()->json(['error' => 'No authorization to delete Poruka'], HttpResponse::HTTP_UNAUTHORIZED);
    }
}
