<?php
namespace App\Http\Controllers;
use App\Models\Oglas;
use App\Models\Lokacija;
use App\Models\Slika;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use Illuminate\Http\Response as HttpResponse;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;


class OglasController extends Controller
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
        return Oglas::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            $oglas = new Oglas;

            $data = Input::except('id', 'lokacija_id', 'autor_id');
            $oglas->fill($data);

            $lokacija = new Lokacija;
            $lokacija->fill($data);
            $lokacija->save();
            $oglas->lokacija_id = $lokacija->id;
            $oglas->autor_id = $user->id;
            $oglas->datum_objave = Carbon::now();

            $rules=array(
                'naziv'=>'required|max:255',
                'tip_oglasa'=>'required|max:45',
                'status_oglasa'=>'required|alpha|max:45',
                'povrsina'=>'integer|Min:30|Max:400',
                'cijena'=>'required|integer|min:0|max:100000',
                'stanje'=>'max:45',
                'grijanje'=>'max:45',
                'struja'=>'boolean',
                'voda'=>'boolean',
                'telefon'=>'boolean',
                'kablovska'=>'boolean',
                'internet'=>'boolean',
                'garaza'=>'boolean',
                'drzava'=>'max:45|regex:/^[A-Za-zčČćĆšŠđĐžŽ ]+$/',
                'kanton'=>'max:45|alpha',
                'grad'=>'max:45|alpha',
                'opstina'=>'max:45|alpha',
                'adresa'=>'max:45|regex:/^[A-Za-zčČćĆšŠđĐžŽ0-9 .]+$/'

            );

            $validator= Validator::make(Input::all(), $rules);

            if(!$validator->fails()) {
                $data = Input::except('id', 'lokacija_id', 'autor_id');
                $oglas->fill($data);

                $lokacija = new Lokacija;
                $lokacija->fill($data);
                $lokacija->save();
                $oglas->lokacija_id = $lokacija->id;

                $oglas->autor_id = $user->id;
                $oglas->datum_objave = Carbon::now();

                $oglas->save();

            }



            $oglas->save();
        } catch(Exception $e){
            return response()->json(['error' => 'Error storing oglas'], HttpResponse::HTTP_CONFLICT);
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
        return Oglas::find($id);
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
        try{
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            $oglas = Oglas::find($id);

            if($user->id == $oglas->autor->id || $user->admin){

                if ($request->has('naziv')) {
                    $validator= Validator::make(['naziv'=>'required|max:255']);
                    if(!$validator->fails())
                        $oglas->naziv = $request->input('naziv');
                }
                if ($request->has('tip')) {
                    $validator= Validator::make(['tip'=>'required|max:45']);
                    if(!$validator->fails())
                        $oglas->tip_oglasa = $request->input('tip');
                }
                if ($request->has('status')) {
                    $validator= Validator::make(['status'=>'required|alpha|max:45']);
                    if(!$validator->fails())
                        $oglas->status_oglasa = $request->input('status');
                }
                if ($request->has('cijena')) {
                    $validator= Validator::make(['cijena'=>'required|integer|min:0|max:100000']);
                    if(!$validator->fails())
                        $oglas->cijena = $request->input('cijena');
                }
                if ($request->has('povrsina')) {
                    $validator= Validator::make(['povrsina'=>'required|min:30|max:400']);
                    if(!$validator->fails())
                        $oglas->povrsina = $request->input('povrsina');
                }
                if ($request->has('stanje')) {
                    $validator= Validator::make(['stanje'=>'max:45']);
                    if(!$validator->fails())
                        $oglas->stanje = $request->input('stanje');
                }
                if ($request->has('opis')) {
                    $oglas->opis = $request->input('opis');
                }
                $lokacija = $this->dajLokaciju($id);
                if ($request->has('drzava')) {
                    $validator= Validator::make(['drzava'=>'max:45|regex:/^[A-Za-zčČćĆšŠđĐžŽ ]+$/']);
                    if(!$validator->fails())
                        $lokacija->drzava = $request->input('drzava');
                }
                if ($request->has('kanton')) {
                    $validator= Validator::make(['kanton'=>'max:45|alpha']);
                    if(!$validator->fails())
                        $lokacija->kanton = $request->input('kanton');
                }
                if ($request->has('grad')) {
                    $validator= Validator::make(['grad'=>'alpha|max:45']);
                    if(!$validator->fails())
                        $lokacija->grad = $request->input('grad');
                }
                if ($request->has('opstina')) {
                    $validator= Validator::make(['opstina'=>'alpha|max:45']);
                    if(!$validator->fails())
                        $lokacija->opstina = $request->input('opstina');
                }
                if ($request->has('adresa')) {
                    $validator= Validator::make(['adresa'=>'max:45|regex:/^[A-Za-zčČćĆšŠđĐžŽ0-9 .]+$/']);
                    if(!$validator->fails())
                        $lokacija->adresa = $request->input('adresa');
                }
                if ($request->has('grijanje')) {
                    $validator= Validator::make(['grijanje'=>'max:45']);
                    if(!$validator->fails())
                        $oglas->grijanje = $request->input('grijanje');
                }
                if ($request->has('struja')) {
                    $validator= Validator::make(['struja'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->struja = $request->input('struja');
                }
                if ($request->has('voda')) {
                    $validator= Validator::make(['voda'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->voda = $request->input('voda');
                }
                if ($request->has('telefon')) {
                    $validator= Validator::make(['telefon'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->telefon = $request->input('telefon');
                }
                if ($request->has('kablovska')) {
                    $validator= Validator::make(['kablovska'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->kablovska = $request->input('kablovska');
                }
                if ($request->has('internet')) {
                    $validator= Validator::make(['internet'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->internet = $request->input('internet');
                }
                if ($request->has('garaza')) {
                    $validator= Validator::make(['garaza'=>'boolean']);
                    if(!$validator->fails())
                        $oglas->garaza = $request->input('garaza');
                }
                $lokacija->save();
                $oglas->save();
                return response()->json(['success' => 'Oglas info updated'], HttpResponse::HTTP_OK);
            }
            else return response()->json(['error' => 'No authorization to update'], HttpResponse::HTTP_UNAUTHORIZED);

        } catch(Exception $e){
            return response()->json(['error' => 'Error storing oglas'], HttpResponse::H);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $oglas = Oglas::find($id);
        if($user->id == $oglas->autor->id || $user->admin){
            $oglas->lokacija()->delete();
            $oglas->delete();
            return response()->json(['success' => 'Oglas deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_UNAUTHORIZED);


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
    public function dodajSliku(Request $request,  $id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $korisnik = Oglas::find($id)->autor;

        if($user->id == $korisnik->id || $user->admin){
            $slika = new Slika;
            $slika->oglas_id = $id;
            $slika->slika = $request->input('slika');
            $slika->save();
            return response()->json(['success' => 'Slika saved'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to add Slika'], HttpResponse::HTTP_UNAUTHORIZED);

    }

    public function obrisiSliku($id, $slika_id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $korisnik = Oglas::find($id)->autor;
        if($user->id == $korisnik->id || $user->admin){
            $slika = Slika::find($slika_id);
            $slika->delete();
            return response()->json(['success' => 'Slika deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete Slika'], HttpResponse::HTTP_UNAUTHORIZED);

    }
    public function dajFavorite($id)
    {
        return Oglas::find($id)->favoriti;
    }

    

    public function dajOglaseAutora($id){
        return Oglas::where('autor_id', $id)->get();
       
    }

    



}