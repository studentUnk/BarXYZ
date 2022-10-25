<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MesaController extends Controller
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
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesa $mesa)
    {
        //
    }

    /**
     * Mesas disponibles por sede
     */
    public function mesas_disponibles($id_sede)
    {
        //
        /*$productos = DB::table('combos')
            ->join('combo_productos', [['combo_productos.fk_codigo_combo', '=', 'combos.id']])
            ->join('inventarios', [['inventarios.fk_codigo_producto', '=', 'combo_productos.fk_codigo_producto']])
            ->select('combos.*')
            ->where([['inventarios.unidad','>',0],['inventarios.codigo_sede','=',$id_sede]])
            ->get();*/
        // PENDIENTE CORREGIR CONSULTA PARA FILTRO POR FECHA!!!!!!!!
        $query = "select *
        from mesas
        where mesas.codigo_sede = " . $id_sede . " " .
        "and not exists (
            select 1
            from pedidos
            where pedidos.activo = 'Y'
            and pedidos.codigo_mesa = mesas.id
            )";
        $mesas = DB::select($query);
        return $mesas;
    }
}
