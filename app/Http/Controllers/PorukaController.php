<?php

namespace App\Http\Controllers;

use App\Models\Poruka;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Collection;
use JWTAuth;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB;

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
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $poruka=new Poruka();

        $rules=array(
            'tekst'=>'required|max:256',
            'oglas'=>'integer',
            'korisnik2_id'=>'required|integer'

        );

        $validator= Validator::make(Input::all(), $rules); 
        
        if(!$validator->fails()){
            $poruka->tekst=$request->input('tekst');
            $poruka->korisnik1_id=$user->id;
            $poruka->korisnik1_name = $user->name;
            $poruka->korisnik2_id=$request->input('korisnik2_id');
            $poruka->korisnik2_name = $poruka->rcv->name;
            $poruka->oglas=$request->input('oglas');
            $poruka->save();
        }
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

    public function dajListuZadnjihPoruka($korisnik_id)
    {
        $poslano = Poruka::select(DB::raw('DISTINCT(korisnik2_id)'))->where('korisnik1_id', $korisnik_id)->orderBy('created_at')->get();
        $primljeno = Poruka::select(DB::raw('DISTINCT(korisnik1_id)'))->where('korisnik2_id', $korisnik_id)->orderBy('created_at')->get();
        $ids = array();
        foreach ($poslano as $id)
            array_push($ids, $id->korisnik2_id);
        foreach ($primljeno as $id){
            if(!in_array($id->korisnik1_id,$ids))
                array_push($ids, $id->korisnik1_id);
        }

        $poruke = new \Illuminate\Database\Eloquent\Collection();
        foreach ($ids as $id){
            $zadnjaPorukaId = Poruka::where('korisnik1_id', $id)->orWhere('korisnik2_id', $id)->max('id');
            $zadnjaPoruka = Poruka::find($zadnjaPorukaId);
            $poruke->add($zadnjaPoruka);

        }

        return $poruke;
    }

    public function dajPoruke($sen, $rec)
    {
        $poruke = Poruka::where(function ($query) use ($sen,$rec) {
                $query->where('korisnik1_id', $sen)
                ->orWhere('korisnik1_id', $rec);
        })->where(function ($query) use ($sen,$rec){
            $query->where('korisnik2_id', $sen)
                ->orWhere('korisnik2_id', $rec);
        })->get();

        return $poruke;
    }
}
