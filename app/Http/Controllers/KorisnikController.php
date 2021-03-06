<?php

namespace App\Http\Controllers;

use App\Models\Oglas;
use App\User;
use App\Models\KorisnikDodatno;
use Illuminate\Http\Request;
use App\Models\Favorit;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;

use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Log;


class KorisnikController extends Controller
{
    //Autorizacija sa JSON Web Token za sve servise osim prijave, registracije i verifikacije mailom
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'store', 'verifikujKorisnika']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    //Prijava korisnika, provjera emaila i lozinke i kreiranje tokena
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {

            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $id = Auth::id();

        //sacuvaj podatak o prijavi u bazu, id korisnika i vrijeme prijave
        DB::table('login')->insert(
            ['korisnik_id' => $id]
        );

        // u odgovoru se vraca token
        return response()->json(compact('token', 'id'));
    }

    //verifikacija korisnickog racuna
    public function verifikujKorisnika($konfirmacijski_kod)
    {
        $korisnik= User::where('konfirmacijski_kod', $konfirmacijski_kod)->first();
        $korisnik->verifikovan=1;
        $korisnik->konfirmacijski_kod=null;
        $korisnik->save();

    }

    //provjera captcha tokena koji klijentska stana salje u POST zahtjevu kod registracije
    public function captchaCheck()
    {

        $response = Input::get('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        //reCAPTCHA secret key
        $secret   = "6LfQyB0TAAAAANSmMx8nrWd8DzWsVx79413MJd_v";

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }

    }

    //registracija korisnika
    public function store(Request $request)
    {
        try
        {

            $korisnik=new User();
            $dodatno=new KorisnikDodatno();

            //validacija za polja kod registracije
            $rules=array(
                'name'=>'required|max:32|regex:/^\w{2,}\s\w{2,}$/',
                'email'=>'required|email|max:255|unique:users',
                'password'=>'required|min:6|max:32',
                'telefon'=>'digits_between:6,15|max:45',
                'grad'=>'alpha|max:14',
                'drzava'=>'alpha|max:14'
            );

            $validator= Validator::make(Input::all(), $rules);

            //captcha provjera
            if($this->captchaCheck() == false)
            {
                return response()->json(['error' => 'Captcha failed'], HttpResponse::HTTP_UNAUTHORIZED);
            }

            else{

                //ako su polja validna, spremi korisnika u bazu i posalji mail za verikikaciju
                if(!$validator->fails()) {
                    $confirmation_code = str_random(30);
                    $data = Input::except('password', 'admin');
                    $korisnik->fill($data);
                    $dodatno->fill($data);
                    $korisnik->password = bcrypt($request->password);
                    $dodatno->save();
                    $korisnik->dodatno_korisnik = $dodatno->id;
                    $korisnik->konfirmacijski_kod = $confirmation_code;
                    $korisnik->save();
                    $data = ['code' => $confirmation_code];
                    Mail::send('emailverify', $data, function ($message) use ($korisnik) {
                        $message->from('zanatatar7@gmail.com', 'Zana Tatar');
                        $message->to($korisnik->email, $korisnik->name)
                            ->subject('Verifikacija računa');
                    });
                }

                /*    Mail::raw('http://localhost:8000/korisnici/verifikuj/'.$confirmation_code, function ($message) use ($korisnik) {

                         $message->to($korisnik->email, $korisnik->name);
                         $message->from('@gmail.com', 'Zana Tatar');

                         $message->subject('EayPick email verficiation ');
                     });
                } */
                else{
                    //POST zahtjev nepotpun ili polja nisu prosla validaciju
                    return response()->json(['error' => 'Validation failed'], HttpResponse::HTTP_UNAUTHORIZED);
                }

            }


        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to register user'], HttpResponse::HTTP_CONFLICT);
        }
        
        //registracija uspjesna, kreiraj token za korisnika
        $token = JWTAuth::fromUser($korisnik);

        //vrati JWT
        return response()->json(compact('token'));
        
    }

    //GET korisnika po ID
    public function show($id)
    {
        $user=User::find($id);
        
        if($user->dodatno_korisnik!=null){
            $dodatno=KorisnikDodatno::find($user->dodatno_korisnik);
            //$dodatno= KorisnikDodatno::where('id', $user->dodatno_korisnik)->first();
            $user->telefon=$dodatno->telefon;
            $user->drzava=$dodatno->drzava;
            $user->grad=$dodatno->grad;
        }else{
            $user->telefon=null;
            $user->drzava=null;
            $user->grad=null;
        }
        return $user;
    }

    //PUT metoda, azuriranje korisnika po ID
    public function update(Request $request, $id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $rules=array(
            'name'=>'max:32|regex:/^[A-Za-zčČćĆšŠđĐžŽ]{2,}\s[A-Za-zčČćĆšŠđĐžŽ]{2,}$/',
            'email'=>'email|max:255',

            'telefon'=>'digits_between:6,15|max:45',
            'grad'=>'alpha|max:14',
            'drzava'=>'alpha|max:14'
        );

        $validator= Validator::make(Input::all(), $rules);

        $korisnik=User::find($id);

        if(!$validator->fails()) {



                $data = Input::except( 'password', 'admin');
              ///  $korisnik->password=bcrypt($request->password);
               $korisnik->name=$request->name;



               if(isset($korisnik->dodatno_korisnik))
                    $dodatno = $korisnik->dodatno;
                else
                    $dodatno = new KorisnikDodatno();

                $dodatno->drzava=$request->drzava;
                $dodatno->grad=$request->grad;
                $dodatno->telefon=$request->telefon;
                $dodatno->save();
               // $korisnik->dodatno_korisnik=$dodatno->id;
                $korisnik->save();
                return response()->json(['success' => 'User info updated'], HttpResponse::HTTP_OK);
            }
            else return response()->json(['error' => 'No authorization to update'], HttpResponse::HTTP_FORBIDDEN);




    }

    //DELETE korisnika po ID
    public function destroy($id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $korisnik= User::find($id);

        if($user->id == $korisnik->id || $user->admin){
            $korisnik->delete();
            return response()->json(['success' => 'User deleted'], HttpResponse::HTTP_OK);
        }
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_FORBIDDEN);
    }

    //nadji korisnika po e-mailu
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
        else return response()->json(['error' => 'No authorization to update'], HttpResponse::HTTP_FORBIDDEN);

    }

    public function dodajAdmina ($id)
    {
        $korisnik= User::find($id);
        $korisnik->admin=1;
        $korisnik->save();

    }

    public function oduzmiAdmina ($id)
    {
        $korisnik= User::find($id);
        $korisnik->admin=0;
        $korisnik->save();

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
        else return response()->json(['error' => 'No authorization to delete'], HttpResponse::HTTP_FORBIDDEN);

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

    public function dajFavoriteKorisnika($id){
        $favoriti= Favorit::where('korisnik_id', $id)->get();
        $oglasi=array();
        foreach ($favoriti as $favorit){
            $oglasi[] = Oglas::find($favorit->oglas_id);
        }
        return $oglasi;
    }

    public function dajFavoriteTrenutnogKorisnika(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $favoriti= Favorit::where('korisnik_id', $user->id)->get();
        $oglasi=array();
        foreach ($favoriti as $favorit){
            $oglasi[] = Oglas::find($favorit->oglas_id);
        }
        return $oglasi;
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

    public function dajAdmine(){
        return User::where('admin', true)->get();
    }

    public function dajAdmina($id){
        return User::where('admin', true)
            ->where('id', $id)->get();
    }
    
    public function dajTrenutnogKorisnika(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        //$user=User::find($id);
        if($user->dodatno_korisnik!=null){
            $dodatno=KorisnikDodatno::find($user->dodatno_korisnik);
            //$dodatno= KorisnikDodatno::where('id', $user->dodatno_korisnik)->first();
            $user->telefon=$dodatno->telefon;
            $user->drzava=$dodatno->drzava;
            $user->grad=$dodatno->grad;
        }else{
            $user->telefon=null;
            $user->drzava=null;
            $user->grad=null;
        }
        return $user;
    }

    public function dajOglaseTKor(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        return Oglas::where('autor_id', $user->id)->get();
    }
    
    public function dajPrijaveInfo(){
        $prijave = DB::table('login')->select('korisnik_id','login_time')->get();
        return $prijave;
    }
}