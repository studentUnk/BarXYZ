@extends('layouts.app')
@section('content')

<div class="container">

@if(Session::has('mensaje_exitoso'))
<div class="alert alert-success" role="alert">
{{ Session::get('mensaje_exitoso') }}
<br><br>
</div>
@endif

<form action="{{ url('/pedido' ) }}" method="post" class="d-inline">
    @csrf
    <label for="codigo_combo"> Seleccionar mesa disponible para creacion de nuevo pedido</label>
    <select class="form-select" name="codigo_mesa" id="codigo_mesa">    
        @foreach($mesas as $mesa)
                <option value="{{ $mesa->id}}">{{ $mesa->numero_mesa }}</option>
        @endforeach
    </select>
    <br>
    <input type="submit" value="Crear nuevo pedido" class="btn btn-success">
</form>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Mesa</th>
            <th>Fecha</th>
            <th>Valor</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->codigo_mesa }}</td>
            <td>{{ $pedido->fecha_creacion }}</td>
            <td>{{ $pedido->valor_venta }}</td>
            <td>{{ $pedido->activo }}</td>
            <td>
            <a href="{{ url('/pedido/'.$pedido->id.'/edit') }}" class="btn btn-warning">
                Editar
            </a>
            | 
            <form action="{{ url('/pedido/'.$pedido->id ) }}" method="post" class="d-inline">
                @csrf
                {{ method_field("delete") }}
                <input type="submit" onclick="return confirm('¿Esta seguro de eliminar el registro?')" value="Eliminar" class="btn btn-danger">
            </form>
            @if(Auth::user()->type_user === '1' or Auth::user()->type_user === '2')
            |
            <form action="{{ url('/pedido_detalle/'.$pedido->id ) }}" method="post" class="d-inline">
                @csrf
                {{ method_field("put") }}
                <input type="submit" onclick="return confirm('¿Marcar como pagado el pedido?')" value="Pagar" class="btn btn-success">
            </form>
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $pedidos->links() !!}

</div>
@endsection