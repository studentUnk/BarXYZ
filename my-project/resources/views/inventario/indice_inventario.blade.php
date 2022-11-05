@extends('layouts.app')
@section('content')

<div class="container">

@if(Session::has('mensaje_exitoso'))
<div class="alert alert-success" role="alert">
{{ Session::get('mensaje_exitoso') }}
<br><br>
</div>
@endif

<a href = "{{ url('inventario/create') }}" class = "btn btn-success"> Asociar nuevo producto </a>
<a href = "{{ url('producto') }}" class = "btn btn-success"> Crear/modificar producto </a>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Sede</th>
            <th>Producto</th>
            <th>Unidades</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inventarios as $inventario)
        <tr>
            <td>{{ $inventario->id }}</td>
            <td>{{ $inventario->codigo_sede }}</td>
            <td>{{ $inventario->codigo_producto }}</td>
            <td>{{ $inventario->unidad }}</td>
            <td>
            <a href="{{ url('/inventario/'.$inventario->id.'/edit') }}" class="btn btn-warning">
                Editar
            </a>
            | 
            <form action="{{ url('/inventario/'.$inventario->id ) }}" method="post" class="d-inline">
                @csrf
                {{ method_field("delete") }}
                <input type="submit" onclick="return confirm('¿Esta seguro de eliminar el registro?')" value="Eliminar" class="btn btn-danger">
            </form>       
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $inventarios->links() !!}
</div>
@endsection