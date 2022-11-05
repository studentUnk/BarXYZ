<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['productos']=Producto::paginate(10);
        return view('producto.indice_producto',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('producto.crear_producto');
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
        $campos = [
            'nombre' => 'required|string|max:255',
            'desripcion' => 'required|string|max:255'
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $datos_usuario = request()->except('_token');
        #$pwd = $datos_usuario['']
        Producto::insert($datos_usuario); 
        
        /*User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        #return response()->json($datos_usuario);
        return redirect('producto')->with('mensaje_exitoso','Producto agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    //public function edit(Producto $producto)
    public function edit($id)
    {
        //
        $producto = Producto::findOrFail($id);
        return view("producto.editar_producto", compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Producto $producto)
    public function update(Request $request, $id)
    {
        //
        $campos = [
            'nombre' => 'required|string|max:255',
            'desripcion' => 'required|string|max:255'
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $datos_usuario = request()->except(['_token','_method']);

        //$datos_usuario['password'] = Hash::make($datos_usuario['password']);

        Producto::where('id','=',$id)->update($datos_usuario);

        $producto = Producto::findOrFail($id);
        #return view("administracion.editar_usuario", compact('user'));
        return redirect("producto")->with('mensaje_exitoso','Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Producto $producto)
    public function destroy($id)
    {
        //
        Producto::destroy($id);
        return redirect("producto")->with('mensaje_exitoso','Producto eliminado con éxito');
    }

    /**
     * Obtener productos disponibles por sede
     */
    public function productos_sede($id_sede)
    {
        //
        $productos = DB::table('productos')
            ->join('inventarios', [['productos.id', '=', 'inventarios.codigo_producto']])
            ->select('productos.*', 'inventarios.codigo_sede')
            ->where([['inventarios.unidad','>',0],['inventarios.codigo_sede','=',$id_sede]])
            ->get();
        return $productos;
    }

    /**
     * Obtener precio de un producto
     */
    public function precio_producto($codigo_producto)
    {
        //
        $precio = Producto::select('precio')
                    ->where('id',$codigo_producto)
                    ->value('precio');
        return $precio;
    }

    /**
     * Obtener un unico producto en base al id
     */
    public function obtener_producto($id)
    {
        //
        return Producto::findOrFail($id);
    }

    /**
     * Obtener todos los productos disponibles
     */
    public function obtener_todo(){
        return Producto::all();
    }
}
