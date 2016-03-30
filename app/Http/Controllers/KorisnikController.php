<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\KorisnikDodatno;
use Illuminate\Http\Request;
use App\Models\Favorit;

use App\Http\Requests;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as HttpResponse;

class KorisnikController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return User::all() ;
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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $korisnik=new User() ;
            $korisnik->name=$request->name;
            $korisnik->email=$request->email;
            $korisnik->password=bcrypt($request->password);
            $korisnik->verifikovan= 0;
            $korisnik->ban= 0;

            if (isset($request->grad) || isset($request->telefon) || isset ($request->drzava))

            {
                $dodatno=new KorisnikDodatno();
                $dodatno->telefon=$request->telefon;
                $dodatno->grad=$request->grad;
                $dodatno->drzava=$request->drzava;
                $dodatno->save();
                $korisnik->dodatno_korisnik=$dodatno->id;
            }

            $korisnik->save() ;
        } catch (Exception $e) {
            return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
        }

        $token = JWTAuth::fromUser($korisnik);

        return response()->json(compact('token'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $input=$request->all();
        $korisnik=User::find($id) ;

        if($user->id == $korisnik->id || $user->admin){
            $korisnik->name=$request->name;
            $korisnik->email=$request->email;
            $korisnik->password=bcrypt($request->password);
            $korisnik->verifikovan= 0;
            $korisnik->ban= 0;

            if (isset($request->grad) || isset($request->telefon) || isset ($request->drzava))

            {
                $dodatno= $korisnik->dodatno();
                $dodatno->telefon=$request->telefon;
                $dodatno->grad=$request->grad;
                $dodatno->drzava=$request->drzava;
                $dodatno->save();
                $korisnik->dodatno_korisnik=$dodatno->id;
            }

            $korisnik->save() ;
            return response()->json(['success' => 'User info updated'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to update'], HttpResponse::HTTP_UNAUTHORIZED);


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

        $korisnik=User::find($id) ;

        if($user->id == $korisnik->id || $user->admin){
            $korisnik->delete();
            return response()->json(['success' => 'User deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function PoEmail($email)
    {
     return User::where('email', $email)->get();
    }

    public function urediPoEmail(Request $request,  $email)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $korisnik= User::where('email', $email)->first();
        $input=$request->all();

        if($user->id == $korisnik->id || $user->admin){
            $korisnik->fill($input);
            $korisnik->save();
            return response()->json(['success' => 'User updated'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to update'], HttpResponse::HTTP_UNAUTHORIZED);


    }

    public function brisanjePoEmail ($email)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $korisnik= User::where('email', $email)->first();

        if($user->id == $korisnik->id || $user->admin){
            User::destroy($korisnik->id);
            return response()->json(['success' => 'User deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_UNAUTHORIZED);

    }

    public function dajFavorite ($id)
    {
        $favoriti = array();

        $favoritikorisnika = User::find($id)->favoriti();
        foreach ($favoritikorisnika as $favorit){
            $favoriti[] = (array)$favorit;
            }
        return $favoriti;

    }

    public function dodajFavorit ($id_korisnika, $id_favorita) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        if($user->id == $id_korisnika){
            $favorit=new Favorit();
            $favorit->korisnik_id=$id_korisnika;
            $favorit->oglas_id=$id_favorita;
            $favorit->save();
            return response()->json(['success' => 'Favorit added'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to add'], HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function izbrisiFavorit ( $id_favorita) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $favorit = Favorit::find($id_favorita);
        if($user->id == $favorit->korisnik_id)
        {
            $favorit->delete();
            return response()->json(['success' => 'Favorit deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function dodajBan ( $id) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if($user->admin){
            $korisnik= User::find($id);
            $korisnik->ban=1;
            $korisnik->save();
            return response()->json(['success' => 'User banned'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to ban user'], HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function ukloniBan ( $id) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if($user->admin){
            $korisnik= User::find($id);
            $korisnik->ban=0;
            $korisnik->save();
            return response()->json(['success' => 'Ban removed'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to remove ban'], HttpResponse::HTTP_UNAUTHORIZED);
    }
}