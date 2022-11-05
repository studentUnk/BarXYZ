@extends('layouts.app')
@section('content')

<div class="container">

@if(Session::has('mensaje_exitoso'))
<div class="alert alert-success" role="alert">
{{ Session::get('mensaje_exitoso') }}
<br><br>
</div>
@endif

<a href = "{{ url('inventario') }}" class = "btn btn-primary"> Regresar </a>
<a href = "{{ url('producto/create') }}" class = "btn btn-success"> Crear nuevo producto </a> 

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr>
            <td>{{ $producto->id }}</td>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->desripcion }}</td>
            <td>
            <a href="{{ url('/producto/'.$producto->id.'/edit') }}" class="btn btn-warning">
                Editar
            </a>
            | 
            <form action="{{ url('/producto/'.$producto->id ) }}" method="post" class="d-inline">
                @csrf
                {{ method_field("delete") }}
                <input type="submit" onclick="return confirm('¿Esta seguro de eliminar el registro?')" value="Eliminar" class="btn btn-danger">
            </form>       
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $productos->links() !!}

</div>
@endsection