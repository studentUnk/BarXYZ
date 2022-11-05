<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;

use Response;
use File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reporte.indice_reporte');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = request()->except(['_token','_method']);
        switch($data['reportes']){
            case 'reportInvDisp':
                if($data['tipoArchivo'] == 'csv'){
                    //return view('reporte.indice_reporte');
                    $nombreArchivo = "inventario_restante.csv";
                    $nombreArchivoPath = public_path("files/" . $nombreArchivo);
                    $headers = array('Content-type' => 'text/csv');
                    $this->reporteInventarioDisponibleCSV($data['reportes'], $nombreArchivo);

                    return Response::download($nombreArchivoPath, $nombreArchivo, $headers);
                }
                else{
                    $nombreArchivo = "inventario_restante.xls";
                    $this->reporteInventarioDisponibleXLS($data['reportes'],$nombreArchivo);
                }
                break;
            case 'reportInvVend':
                if($data['tipoArchivo'] == 'csv'){
                    //return view('reporte.indice_reporte');
                    $nombreArchivo = "inventario_vendido.csv";
                    $nombreArchivoPath = public_path("files/" . $nombreArchivo);
                    $headers = array('Content-type' => 'text/csv');
                    $this->reporteInventarioDisponibleCSV($data['reportes'], $nombreArchivo);

                    return Response::download($nombreArchivoPath, $nombreArchivo, $headers);
                }
                else{
                    $nombreArchivo = "inventario_vendido.xls";
                    $this->reporteInventarioDisponibleXLS($data['reportes'],$nombreArchivo);
                }
                break;
            case 'reportVtaFech':
                break;
        }

        //return view('reporte.indice_reporte');
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
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function show(Reporte $reporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Reporte $reporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporte $reporte)
    {
        //
    }

    /**
     * Generar data para reportes
     */
    public function generarDatosReporte($tipoReporte)
    {
        //
        switch ($tipoReporte)
        {
            case 'reportInvDisp':
                $header;
                break;
            case 'reportInvVend':
                break;
            case 'reportVtaFech':
                break;
        }
    }

    /**
     * Generar cabeceras para reportes
     */
    public function generarCabecerasReporte($tipoReporte)
    {
        //
        switch ($tipoReporte)
        {
            case 'reportInvDisp':
                $header = [
                    "Codigo sede",
                    "Codigo producto",
                    "Usuario",
                    "Nombre producto",
                    "Descripcion producto",
                    "Sede",
                    "Unidades disponibles",
                    "Precio",
                    "Valor total"
                ];
                return $header;
            case 'reportInvVend':
                $header = [
                    "Codigo sede",
                    "Codigo producto",
                    "Nombre producto",
                    "Descripcion producto",
                    "Sede",
                    "Unidades vendidas",
                    "Valor vendido"
                ];
                return $header;
            case 'reportVtaFech':
                $header = [
                    "hola"
                ];
                return $header;
        }
    }


    /**
     * Generar reporte en formato CSV
     */
    public function reporteInventarioDisponibleCSV($tipoReporte, $nombreAr){
        // Obtener datos de la base de datos
        $inventarioController = new InventarioController();
        $pedidoController = new PedidoController();
        
        $tipoArchivo = "csv";
        
        $headers = array('Content-type' => 'text/' . $tipoArchivo);

        // Confirmar ruta de creacion
        if(!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        // Archivo a crear
        $nombreArchivo = $nombreAr;
        $nombreArchivoPath = public_path("files/" . $nombreArchivo);
        $handle = fopen($nombreArchivoPath, "w");

        // Cabeceras del archivo CSV
        fputcsv($handle, $this->generarCabecerasReporte($tipoReporte));

        switch ($tipoReporte)
        {
            //
            case 'reportInvDisp':
                $data = $inventarioController->productos_full_reporte();
                foreach ($data as $d) {
                    fputcsv($handle, [
                        $d->codigo_sede,
                        $d->codigo_producto,
                        $d->usuario_ingreso,
                        $d->nombre_producto,
                        $d->descripcion_producto,
                        $d->nombre_sede,
                        $d->unidades_disponibles,
                        $d->precio,
                        $d->precio * $d->unidades_disponibles
                    ]);
                };
                break;
            case 'reportInvVend':
                $data = $pedidoController->obtenerProductosVendidos();
                foreach ($data as $d) {
                    fputcsv($handle, [
                        $d->codigo_sede,
                        $d->codigo_producto,
                        $d->nombre_producto,
                        $d->descripcion_producto,
                        $d->nombre_sede,
                        $d->unidades_disponibles,
                        $d->precio
                    ]);
                };
                break;
            case 'reportVtaFech':
                break;

        }
        

        fclose($handle);

        //return Response::download($nombreArchivoPath, $nombreArchivo, $headers);
    }

    /**
     * Generar reporte en format XLS
     */
    public function reporteInventarioDisponibleXLS($tipoReporte, $nombreAr){
        // Obtener datos de la base de datos
        $inventarioController = new InventarioController();
        $pedidoController = new PedidoController();
        //$inventarioDisp = $inventarioController->productos_full_reporte();

        $tipoArchivo = "xls";        
        $headers = array('Content-type' => 'text/' . $tipoArchivo);

        /*
        // Confirmar ruta de creacion
        if(!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }
        */

        // Archivo a crear
        //$nombreArchivo = "inventario_restante." . $tipoArchivo;
        $nombreArchivo = $nombreAr;
        $nombreArchivoPath = public_path("files/" . $nombreArchivo);
        //$handle = fopen($nombreArchivoPath, "w");

        $data_array[] = $this->generarCabecerasReporte($tipoReporte);

        switch ($tipoReporte)
        {
            //
            case 'reportInvDisp':
                $data = $inventarioController->productos_full_reporte();

                foreach ($data as $d) {
                    $data_array [] = array(
                        "Codigo sede" => $d->codigo_sede,
                        "Codigo producto" => $d->codigo_producto,
                        "Usuario" => $d->usuario_ingreso,
                        "Nombre producto" => $d->nombre_producto,
                        "Descripcion producto" => $d->descripcion_producto,
                        "Sede" => $d->nombre_sede,
                        "Unidades disponibles" => $d->unidades_disponibles,
                        "Precio" => $d->precio,
                        "Valor total" => $d->precio * $d->unidades_disponibles                
                    );
                };
                break;
            case 'reportInvVend':
                $data = $pedidoController->obtenerProductosVendidos();
                foreach ($data as $d) {
                    $data_array [] = array(
                        "Codigo sede" => $d->codigo_sede,
                        "Codigo producto" => $d->codigo_producto,
                        "Nombre producto" => $d->nombre_producto,
                        "Descripcion producto" => $d->descripcion_producto,
                        "Sede" => $d->nombre_sede,
                        "Unidades vendidas" => $d->unidades_disponibles,
                        "Valor vendido" => $d->precio               
                    );
                };
                break;
            case 'reportVtaFech':
                break;
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($data_array);

            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
}
