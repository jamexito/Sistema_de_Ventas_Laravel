<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
            $users = DB::table('users')
                ->join('roles', 'users.idrol', '=', 'roles.id')
                ->select('users.id', 'users.nombre', 'users.tipo_documento',
                    'users.num_documento', 'users.direccion', 'users.telefono',
                    'users.email', 'users.email', 'users.usuario', 'users.password',
                    'users.condicion', 'users.idrol' , 'users.imagen', 'roles.nombre as rol')
                ->where('users.nombre', 'LIKE', '%' . $sql . '%')
                ->orwhere('users.num_documento', 'LIKE', '%' . $sql . '%')
                ->orderBy('users.id', 'desc')
                ->paginate(3);

            /*listar los roles en ventana modal*/
            $roles = DB::table('roles')
                ->select('id', 'nombre', 'descripcion')
                ->where('condicion', '=', '1')->get();

            return view('user.index', ["users" => $users,"roles" => $roles, "buscarTexto" => $sql]);
            // return $usuarios;
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
        // if (!$request->ajax()) return redirect('/');
        $user = new User();
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->usuario = $request->usuario;
        $user->password =bcrypt($request->password);
        $user->condicion= '1';
        $user->idrol = $request->id_rol;

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
            $path = $request->file('imagen')->storeAs('public/img/usuario', $fileNameToStore);
        } else {
            $fileNameToStore = "noimagen.jpg";
        }
        $user->imagen = $fileNameToStore;

        //fin registrar imagen
        $user->save();
        return Redirect::to("user");
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
        $user = User::findOrFail($request->id_usuario);
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->usuario = $request->usuario;
        $user->password =bcrypt($request->password);
        $user->condicion= '1';
        $user->idrol = $request->id_rol;

        //Editar Imagen
        if ($request->hasFile('imagen')) {
            /*si la imafen que subeds es distinta a la que esta por defencto, entonces debes elimminarla
            la imagen anterior para no acumular imagenes en el servidor */
            if ($user->imagen != 'noimagen.png') {
                Storage::delete('public/img/usuario/' . $user->imagen);
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
            $path = $request->file('imagen')->storeAs('public/img/usuario', $fileNameToStore);

        } else {
            $fileNameToStore = $user->imagen;
        }
        $user->imagen = $fileNameToStore;

        //fin editar la imagen
        $user->save();
        return Redirect::to("user");
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
        $user = User::findOrFail($request->id_usuario);

        if ($user->condicion == "1") {
            $user->condicion = '0';
            $user->save();
            return Redirect::to("user");
        } else {
            $user->condicion = '1';
            $user->save();
            return Redirect::to("user");
        }
    }
}
