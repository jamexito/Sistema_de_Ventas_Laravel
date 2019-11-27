<?php

namespace App\Http\Controllers;

use App\Producto;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
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
            $sql = trim($request->get('buscarTexto'));
            $productos = DB::table('productos as p')
            ->join('categorias as c', 'p.idcategoria', '=', 'c.id')
            ->select('p.id', 'p.idcategoria', 'p.nombre', 'p.precio_venta', 'p.codigo', 'p.stock', 'p.condicion', 'p.imagen', 'c.nombre as categoria')
            ->where('p.nombre', 'LIKE', '%' . $sql . '%')
            ->orwhere('p.codigo', 'LIKE', '%' . $sql . '%')
            ->orderBy('p.id', 'desc')
            ->paginate(3);

            /*listar las categorias en la ventana modal*/
            $categorias = DB::table('categorias')
            ->select('id', 'nombre', 'descripcion')
            ->where('condicion', '=', '1')->get();

            return view('producto.index', ["productos" => $productos, "categorias" => $categorias, "buscarTexto" => $sql]);

            //return $productos;
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
        $productos = new Producto();
        $productos->idcategoria = $request->id;
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->precio_venta = $request->precio_venta;
        $productos->stock = '0';
        $productos->condicion = '1';

        //Handle File Upload
        if ($request->hasFile('imagen')) {
            //Get filename with the extension
            $filenamewithExt = $request->file('imagen')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('imagen')->guessClientExtension();
            //filname store
            $fileNameToStore = time() . '.' . $extension;
            //upload image
            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);
        } else {
            $fileNameToStore = "noimagen.png";
        }
        $productos->imagen = $fileNameToStore;

        $productos->save();
        return Redirect::to("producto");
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
        $producto = Producto::findOrFail($request->id_producto);
        $producto->idcategoria = $request->id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';

        //Handle File Upload
        if ($request->hasFile('imagen')) {
            /*si la imafen que subeds es distinta a la que esta por defencto, entonces debes elimminarla
            la imagen anterior para no acumular imagenes en el servidor */
            if ($producto->imagen != 'noimagen.png') {
                Storage::delete('public/img/producto/' . $producto->imagen);
            }

            //Get filename with the extension
            $filenamewithExt = $request->file('imagen')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('imagen')->guessClientExtension();
            //filname store
            $fileNameToStore = time() . '.' . $extension;
            //upload image
            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);
        } else {
            $fileNameToStore = $producto->imagen;
        }
        $producto->imagen = $fileNameToStore;

        $producto->save();
        return Redirect::to("producto");
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
        $producto = Producto::findOrFail($request->id_producto);

        if ($producto->condicion == "1") {

            $producto->condicion = '0';
            $producto->save();
            return Redirect::to("producto");
        } else {
            $producto->condicion = '1';
            $producto->save();
            return Redirect::to("producto");
        }
    }
    public function listarPdf()
    {

      $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
      ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.stock','productos.condicion')
      ->orderBy('productos.nombre', 'desc')->get();


      $cont=Producto::count();

      $pdf= \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
      return $pdf->download('productos.pdf');

    }
}
