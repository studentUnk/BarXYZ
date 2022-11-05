<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoDetalleController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MesasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sede = Auth::user()->sede;

        $mesaController = new MesaController();
        //$mesas = $mesaController->mesas_disponibles($sede);
        $datos['mesas'] = $mesaController->mesas_disponibles($sede);
        $datos['pedidos'] = Pedido::where([['activo','=','Y'],['codigo_sede','=',$sede]])->paginate(5);
        return view('pedido.indice_pedido', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sede = Auth::user()->sede;
        $productoController = new ProductoController();
        $inventarioController = new InventarioController();
        $comboController = new ComboController();
        $productos = $inventarioController->productos_sede($sede);
        $combos = $comboController->combos_disponibles($sede);

        //return view('administracion.crear_usuario', compact('tipos_usuario','sedes'));

        return view('pedido.crear_pedido', compact('productos','combos','sede'));
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

        $pedidoController = new PedidoController();

        $datos_r = request();
        $sede = Auth::user()->sede;
        $mesero = Auth::user()->id;
        DB::table('pedidos')->insert([
            'usuario_mesero' => $mesero,
            'codigo_mesa' => $datos_r['codigo_mesa'],
            'codigo_sede' => $sede,
            'activo' => 'Y',
            'valor_venta' => 0
        ]);

        $pedido = $pedidoController->buscar_pedido_mesa($datos_r['codigo_mesa']);

        $productoController = new ProductoController();
        $inventarioController = new InventarioController();
        $comboController = new ComboController();
        $pedidoDetalleController = new PedidoDetalleController();
        $productos = $inventarioController->productos_sede($sede);
        $combos = $comboController->combos_disponibles($sede);

        $detalle_pedidos = $pedidoDetalleController->obtener_detalle_de_pedido($pedido[0]->id); // codigo pedido
        $pedido = $pedido[0]->id;

        //return view('administracion.crear_usuario', compact('tipos_usuario','sedes'));

        return view('pedido.crear_pedido', compact('productos','combos','sede','pedido','detalle_pedidos'));



        //return view('pedido.test_me', compact('datos_r','pedido'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    //public function edit(Pedido $pedido)
    public function edit($pedido)
    {
        //
        $pedidoController = new PedidoController();

        //$datos_r = request();
        $sede = Auth::user()->sede;
        $mesero = Auth::user()->id;
        /*DB::table('pedidos')->insert([
            'usuario_mesero' => $mesero,
            'codigo_mesa' => $datos_r['codigo_mesa'],
            'codigo_sede' => $sede,
            'activo' => 'Y',
            'valor_venta' => 0
        ]);*/

        //$pedido = $pedidoController->buscar_pedido_mesa($datos_r['codigo_mesa']);

        $productoController = new ProductoController();
        $inventarioController = new InventarioController();
        $comboController = new ComboController();
        $pedidoDetalleController = new PedidoDetalleController();
        $productos = $inventarioController->productos_sede($sede);
        $combos = $comboController->combos_disponibles($sede);

        $detalle_pedidos = $pedidoDetalleController->obtener_detalle_de_pedido($pedido); // codigo pedido

        return view('pedido.crear_pedido', compact('productos','combos','sede','pedido','detalle_pedidos'));
        //return view('pedido.indice_pedido');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Pedido $pedido)
    public function update(Request $request)
    {
        //
        $datos_r = request();
        $pedidoDetalleController = new PedidoDetalleController();
        $pedidoDetalleController->insertar_detalle_de_pedido($datos_r);
        

        $pedidoController = new PedidoController();

        //$datos_r = request();
        $sede = Auth::user()->sede;
        $mesero = Auth::user()->id;
        /*DB::table('pedidos')->insert([
            'usuario_mesero' => $mesero,
            'codigo_mesa' => $datos_r['codigo_mesa'],
            'codigo_sede' => $sede,
            'activo' => 'Y',
            'valor_venta' => 0
        ]);*/

        $pedido = $datos_r['pedido'];

        $productoController = new ProductoController();
        $inventarioController = new InventarioController();
        $comboController = new ComboController();
        $pedidoDetalleController = new PedidoDetalleController();
        $productos = $inventarioController->productos_sede($sede);
        $combos = $comboController->combos_disponibles($sede);

        $detalle_pedidos = $pedidoDetalleController->obtener_detalle_de_pedido($pedido); // codigo pedido

        return view('pedido.crear_pedido', compact('productos','combos','sede','pedido','detalle_pedidos'));
        //return view('pedido.test_me', compact('datos_r'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Pedido $pedido)
    public function destroy($id)
    {
        //
        Pedido::destroy($id);
        return redirect("pedido")->with('mensaje_exitoso','Pedido eliminado con éxito');
    }

    /**
     * Buscar pedido en base a la mesa
     */
    public function buscar_pedido_mesa($codigo_mesa)
    {
        //
        $pedido = DB::table('pedidos')
            ->where('codigo_mesa','=',$codigo_mesa)
            ->where('activo','=','Y')
            ->get();
        return $pedido;
    }

    /**
     * Obtener registro de todos los productos vendidos
     */
    public function obtenerProductosVendidos()
    {
        //
        $productos = DB::table('pedidos')
            ->join('sedes', [['sedes.id', '=', 'pedidos.codigo_sede']])
            ->join('pedido_detalles', [['pedido_detalles.codigo_pedido', '=', 'pedidos.id']])
            ->join('productos', [['productos.id', '=', 'pedido_detalles.codigo_producto']])
            ->select('pedidos.codigo_sede', 
                    'pedido_detalles.codigo_producto',
                    'productos.nombre AS nombre_producto',
                    'productos.desripcion AS descripcion_producto',
                    'sedes.nombre AS nombre_sede',
                    'pedido_detalles.cantidad AS unidades_disponibles',
                    'pedido_detalles.precio')
            ->where([['pedidos.activo','!=','Y']])        
            ->get();
        return $productos;
    }
}
