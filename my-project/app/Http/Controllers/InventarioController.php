<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$datos['users']=User::paginate(10);
        //return view('administracion.indice_usuario',$datos);
        $sede = Auth::user()->sede;

        $datos['inventarios'] = Inventario::where([['codigo_sede','=',$sede]])->paginate(10);
        return view('inventario.indice_inventario',$datos);

        

        /*
        $mesaController = new MesaController();
        //$mesas = $mesaController->mesas_disponibles($sede);
        $datos['mesas'] = $mesaController->mesas_disponibles($sede);
        $datos['pedidos'] = Pedido::where([['activo','=','Y'],['codigo_sede','=',$sede]])->paginate(5);
        return view('pedido.indice_pedido', $datos);
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $usuarioController = new TipoUsuarioController();
        $sedeController = new SedeController();
        $productoController = new ProductoController();
        $tipos_usuario = $usuarioController->obtener_todo();
        $sedes = $sedeController->obtener_todo();
        $productos = $productoController->obtener_todo();

        return view('inventario.crear_inventario', compact('tipos_usuario','sedes','productos'));
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
            'codigo_producto' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'precio' => 'required|numeric'
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $data = request()->except('_token');
        
        $sede = Auth::user()->sede;
        $usuario = Auth::user()->id;
        
        #$pwd = $datos_usuario['']
        DB::table('inventarios')->insert([
            'codigo_sede' => $sede,
            'codigo_producto' => $data['codigo_producto'],
            'usuario_ingreso' => $usuario,
            'unidad' => $data['unidad'],
            'precio' => $data['precio']
        ]);
        //User::insert($datos_usuario); 
        
        /*User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        #return response()->json($datos_usuario);
        return redirect('inventario')->with('mensaje_exitoso','Producto asociado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    //public function edit(Inventario $inventario)
    public function edit($id)
    {
        //
        $productoController = new ProductoController();

        $usuarioController = new TipoUsuarioController();
        $sedeController = new SedeController();
        $tipos_usuario = $usuarioController->obtener_todo();
        $sedes = $sedeController->obtener_todo();

        $inventario = Inventario::findOrFail($id);

        $productos = $productoController->obtener_todo();
        $producto = $productoController->obtener_producto($inventario->codigo_producto);
        
        //return view("inventario.editar_inventario", compact('user','tipos_usuario','sedes'));
        return view("inventario.editar_inventario", compact('inventario','producto','productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Inventario $inventario)
    public function update(Request $request, $id)
    {
        //
        $campos = [
            'codigo_producto' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'precio' => 'required|numeric'
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $data = request()->except('_token');
        
        $sede = Auth::user()->sede;
        $usuario = Auth::user()->id;
        
        #$pwd = $datos_usuario['']
        DB::table('inventarios')->where('id',$id)
            ->update([
               'codigo_producto' => $data['codigo_producto'],
               'usuario_ingreso' => $usuario,
               'unidad' => $data['unidad'],
               'precio' => $data['precio']
            ]);
        //User::insert($datos_usuario); 
        
        /*User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        #return response()->json($datos_usuario);
        return redirect('inventario')->with('mensaje_exitoso','Producto asociado actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Inventario $inventario)
    public function destroy($id)
    {
        //
        Inventario::destroy($id);
        return redirect("inventario")->with('mensaje_exitoso','Producto asociado a tienda eliminado con éxito');
    }

    /**
     * Obtener precio de producto
     */
    public function precio_producto($codigo_producto)
    {
        //
        //$sedeController = new SedeController();
        $sede = Auth::user()->sede;
        $precio = Inventario::select('precio')
                    ->where('id',$codigo_producto)
                    ->where('codigo_sede',$sede)
                    ->value('precio');
        return $precio;
    }

    /**
     * Obtener productos disponibles por sede
     */
    public function productos_sede($id_sede)
    {
        //
        $productos = DB::table('inventarios')
            ->join('productos', [['productos.id', '=', 'inventarios.codigo_producto']])
            ->select('inventarios.*', 'productos.nombre', 'productos.desripcion')
            ->where([['inventarios.unidad','>',0],['inventarios.codigo_sede','=',$id_sede]])
            ->get();
        return $productos;
    }

    /**
     * Obtener todos los productos disponibles en todas las sedes
     */
    public function productos_full_reporte()
    {
        //
        $productos = DB::table('inventarios')
            ->join('productos', [['productos.id', '=', 'inventarios.codigo_producto']])
            ->join('sedes', [['sedes.id', '=', 'inventarios.codigo_sede']])
            ->select(
                    'inventarios.codigo_sede', 
                    'inventarios.codigo_producto',
                    'inventarios.usuario_ingreso',
                    'productos.nombre AS nombre_producto', 
                    'productos.desripcion AS descripcion_producto',
                    'sedes.nombre AS nombre_sede',
                    'inventarios.unidad AS unidades_disponibles',
                    'inventarios.precio'
                    )
            ->where([['inventarios.unidad','>',0]])
            ->get();
        return $productos;
    }


}
