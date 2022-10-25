<?php

namespace App\Http\Controllers;

use App\Models\Pedido_detalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //
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
    public function update(Request $request, Pedido_detalle $pedido_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido_detalle  $pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido_detalle $pedido_detalle)
    {
        //
    }

    /**
     * Bucar pedido detalle asociado a un pedido
     */
    public function obtener_detalle_de_pedido($codigo_pedido)
    {
        //
        $pedido_detalle = DB::table('pedido_detalles')
            ->where('codigo_pedido','=',$codigo_pedido)
            ->get();
        return $pedido_detalle;
    }
}
