<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datosp;
class DatospsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Datosp::where('user_id',auth()->id())->get();
        if($request->ajax()){
            return Datosp::where('user_id',auth()->id())->get();
        }
        else{
            return view('home');
        }
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
        $datos=new Datosp();
        $datos->cedula=$request->cedula;
        $datos->nombre=$request->nombre;
        $datos->sexo=$request->sexo;
        $datos->fecha_n=$request->fecha_n;
        $datos->user_id=auth()->id();
        $datos->save();
        return $datos;
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $datos= Datosp::find($id);
        $datos->cedula=$request->cedula;
        $datos->nombre=$request->nombre;
        $datos->sexo=$request->sexo;
        $datos->fecha_n=$request->fecha_n;
        $datos->save();
        return $datos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datos= Datosp::find($id);
        $datos->delete();
        
    }
}
