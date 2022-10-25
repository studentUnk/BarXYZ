<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComboController extends Controller
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
     * @param  \App\Models\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function show(Combo $combo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function edit(Combo $combo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Combo $combo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Combo $combo)
    {
        //
    }

    /**
     * Obtener combos disponibles por sede
     */
    public function combos_disponibles($id_sede)
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
        from combos
        WHERE 1 = 1 " .
        "and combos.codigo_sede = " . $id_sede . " " .
        "and not exists (
        select combo_productos.codigo_combo, inventarios.codigo_sede
        from inventarios
        inner join combo_productos 
        on combo_productos.codigo_producto = inventarios.codigo_producto
        where 1 = 1
        and combo_productos.codigo_combo = combos.id
        and inventarios.codigo_sede = combos.codigo_sede
        and inventarios.unidad < 1
        group by combo_productos.codigo_combo)";
        $combos = DB::select($query);
        return $combos;
    }
}
