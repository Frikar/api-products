<?php

namespace App\Http\Controllers;

use App\Models\ProductoModelo;
use DB;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //Obtenemos los registros desde las bases de datos
        $productos = Producto::all();
        $modelos = ProductoModelo::all();

        $data = array($productos, $modelos);

        return response()->json($data);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //Hacemos el proceso de registrar un producto
        $producto = new Producto();
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);
        $producto->nombre = $request->get('nombre');
        $producto->descripcion = $request->get('descripcion');
        $producto->precio = $request->get('precio');
        $producto->cantidad = $request->get('cantidad');

        // Guardar imagenes en la carpeta
        $name = $request->file('imagen')->getClientOriginalName();

        $path = $request->file('imagen')->store('public/images');

        $producto->filename = $name;
        $producto->path = $path;
        $producto->save();

        $modelo = new ProductoModelo();
        $modelo->nombre_modelo = $request->get('nombre_modelo');
        $modelo->descripcion_modelo = $request->get('descripcion_modelo');
        $modelo->producto_id = $producto->id;

        $modelo->save();

        $data = array($producto, $modelo);

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //Mostramos un registro usando el id para ambas tablas
        $producto = Producto::findOrFail($id);
        $modelo = ProductoModelo::where('producto_id', '=', $id)->firstOrFail();

        $data = array($producto, $modelo);

        return response()->json($data);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //Hacemos una actualizacion de los campos
        $producto = Producto::findOrFail($id);
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);
        $producto->nombre = $request->get('nombre');
        $producto->descripcion = $request->get('descripcion');
        $producto->precio = $request->get('precio');
        $producto->cantidad = $request->get('cantidad');

        // Editamos la imagen
        $name = $request->file('imagen')->getClientOriginalName();

        $path = $request->file('imagen')->store('public/images');

        $producto->filename = $name;
        $producto->path = $path;
        $producto->save();

        $modelo = ProductoModelo::where('producto_id', '=', $id)->firstOrFail();
        $modelo->nombre_modelo = $request->get('nombre_modelo');
        $modelo->descripcion_modelo = $request->get('descripcion_modelo');

        $modelo->save();

        $data = array($producto, $modelo);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        //Eliminamos ambos registros de sus respectivas tablas
        $producto = Producto::destroy($id);
        $modelo = ProductoModelo::where('producto_id', '=', $id)->delete();

        return "Registro eliminado";
    }
}
