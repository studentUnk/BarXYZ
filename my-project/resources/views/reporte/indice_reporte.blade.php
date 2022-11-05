@extends('layouts.app')
@section('content')

<div class="container">

<form action="{{ url('/reporte/create') }}" method="get">
    @csrf
    <div class="row">
        <div class="col">
            <label for="reportes"> Seleccionar tipo de reporte a generar</label>
            <select class="form-select" name="reportes" id="reportes">
                <option value="reportInvDisp">Inventario restante</option>
                <option value="reportInvVend">Inventario vendido</option>
                <option value="reportVtaFech">Ventas por fecha</option>
            </select>
        </div>
        <div class="col">
            <label for="tipoArchivo"> Seleccionar tipo de archivo</label>
            <select class="form-select" name="tipoArchivo" id="tipoArchivo">
                <option value="csv">Archivo CSV</option>
                <option value="xls">Archivo XLS</option>
            </select>
        </div>
    </div>
    <br><br>
    <div class="row">
        <input type="submit" value="Generar reporte" class="btn btn-success">
    </div>    
</form>
<br><br>

</div>
@endsection