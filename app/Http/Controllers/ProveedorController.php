<?php

namespace App\Http\Controllers;

use App\Proveedor;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProveedorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request) {
            $sql=trim($request->get('buscarTexto'));
            $proveedores=DB::table('proveedores')
            ->where('nombre','LIKE','%'.$sql.'%')
            ->orwhere('num_documento','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(3);
            return view('proveedor.index',["proveedores"=>$proveedores,"buscarTexto"=>$sql]);
            //return $proveedores;
        }
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
        $proveedor= new Proveedor();
        $proveedor->nombre= $request->nombre;
        $proveedor->tipo_documento= $request->tipo_documento;
        $proveedor->num_documento= $request->num_documento;
        $proveedor->direccion= $request->direccion;
        $proveedor->telefono= $request->telefono;
        $proveedor->email= $request->email;
        // $proveedor->condicion= '1';
        $proveedor->save();
        return Redirect::to("proveedor");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $proveedor= Proveedor::findOrFail($request->id_proveedor);
        $proveedor->nombre= $request->nombre;
        $proveedor->tipo_documento= $request->tipo_documento;
        $proveedor->num_documento= $request->num_documento;
        $proveedor->direccion= $request->direccion;
        $proveedor->telefono= $request->telefono;
        $proveedor->email= $request->email;
        // $proveedor->condicion= '1';
        $proveedor->save();
        return Redirect::to("proveedor");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $proveedor= Proveedor::findOrFail($request->id_proveedor);

        if ($proveedor->condicion=="1"){
            $proveedor->condicion= '0';
            $proveedor->save();
            return Redirect::to("proveedor");
        }else{
            $proveedor->condicion= '1';
            $proveedor->save();
            return Redirect::to("proveedor");
        }
    }
}
