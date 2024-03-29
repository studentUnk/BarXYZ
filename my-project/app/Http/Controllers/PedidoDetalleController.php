<?php

namespace App\Http\Controllers;

use App\Models\Pedido_detalle;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\InventarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PedidoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido_detalle  $pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido_detalle $pedido_detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido_detalle  $pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido_detalle $pedido_detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido_detalle  $pedido_detalle
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Pedido_detalle $pedido_detalle)
    //public function update(Request $request)
    public function update($pedido)
    {
                // Actualizar pago de un pedido a pagado
                $datos_r = request();
                $pedidoController = new PedidoController();
        
                //$sede = Auth::user()->sede;
                $cajero = Auth::user()->id;
                /*DB::table('pedidos')->insert([
                    'usuario_mesero' => $mesero,
                    'codigo_mesa' => $datos_r['codigo_mesa'],
                    'codigo_sede' => $sede,
                    'activo' => 'Y',
                    'valor_venta' => 0
                ]);*/
                //$pedido = $datos_r['pedido'];
                $pedidoController->actualizarPedidoPago($pedido,$cajero);
                return redirect("pedido")->with('mensaje_exitoso','Pedido ha sido pagado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido_detalle  $pedido_detalle
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Pedido_detalle $pedido_detalle)
    public function destroy($id)
    {
        //
        Pedido_detalle::destroy($id);
        return redirect("pedido")->with('mensaje_exitoso','Detalle del pedido eliminado con éxito');
        //return view('detalle_pedido/test');
    }

    /**
     * Bucar pedido detalle asociado a un pedido
     */
    public function obtener_detalle_de_pedido($codigo_pedido)
    {
        //
        $pedido_detalle = DB::table('pedido_detalles')
            ->leftJoin('productos', [['productos.id', '=', 'pedido_detalles.codigo_producto']])
            ->select('pedido_detalles.*','productos.nombre', 'productos.desripcion')
            ->where('codigo_pedido','=',$codigo_pedido)
            ->get();

        return $pedido_detalle;
    }

    /**
     * Insertar pedido detalle asociado a un pedido
     */
    public function insertar_detalle_de_pedido($data)
    {
        //
        $productoController = new ProductoController();
        $inventarioController = new InventarioController();

        //$precio = $productoController->precio_producto($data['codigo_producto']);
        $precio = $inventarioController->precio_producto($data['codigo_producto']);

        DB::table('pedido_detalles')->insert([
            'codigo_pedido' => $data['pedido'],
            'codigo_producto' => $data['codigo_producto'] == -1 ? null : $data['codigo_producto'],
            'codigo_combo' => $data['codigo_combo'] == -1 ? null : $data['codigo_combo'],
            'cantidad' => $data['cantidad'],
            'precio' => ($precio*$data['cantidad'])
        ]);
    }
}
