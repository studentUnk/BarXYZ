@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/pedido') }}" method="post">
    @csrf
    @include('pedido.formulario_pedido',['fuente'=>'Crear'])
</form>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Producto</th>
            <th>Combo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalle_pedidos as $detalle_pedido)
        <tr>
            <td>{{ $detalle_pedido->codigo_producto }}</td>
            <td>{{ $detalle_pedido->codigo_combo }}</td>
            <td>{{ $detalle_pedido->cantidad }}</td>
            <td>{{ $detalle_pedido->precio }}</td>
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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection