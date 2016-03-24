<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Admin::all();
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
        $admin=new Admin();
        $admin->username= $request->input('username');
        $admin->email= $request->input('email');
        $admin->lozinka= $request->input('lozinka');
        $admin->ime= $request->input('ime');
        $admin->prezime= $request->input('prezime');
        $admin->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Admin::find($id);
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
    public function update($id)
    {
        
        $data= Input::all();
        $admin=Admin::find($id);
        $admin->fill($data);
        $admin->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
    }

    public function poUsername($user){
        return Admin::where('username', $user)->get();
    }

    public function brisanjePoUsername($user){
        Admin::where('username', $user)->delete();
    }

    public function urediPoUsername($user){
              
        $data= Input::all();
        $admin=Admin::where('username', $user)->first();
        $admin->fill($data);
        $admin->save();
    }
    

}
