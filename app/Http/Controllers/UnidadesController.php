<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;

class UnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $index= Unidad::all();
        return $index;
    }

    public function indexActivos()
    {
        $index= Unidad::where('activo', 1)->get();
        return $index;
    }

    public function estado($id, $cambio)
    {
         $model = Unidad::find($id);
         
         $modificacion = ($cambio == 'activar') ? $model->activo = 1 : $model->activo =0;
         $validate = $model->save();
         $return = $validate ? 'true' : 'false';

         return $return;
    }
    
    public function store(Request $request)
    {
        $nuevoItem = new Unidad($request->all());
        $nuevoItem->activo = 1;
        $nuevoItem->save();

        return 'done';
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
        //
    }
}
