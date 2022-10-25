@extends('layouts.app')
@section('content')

<div class="container">

@if(Session::has('mensaje_exitoso'))
<div class="alert alert-success" role="alert">
{{ Session::get('mensaje_exitoso') }}
<br><br>
</div>
@endif

<a href = "{{ url('administracion/create') }}" class = "btn btn-success"> Crear nuevo empleado </a>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Tipo de usuario</th>
            <th>Sede</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $usuario)
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->last_name }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->phone }}</td>
            <td>{{ $usuario->type_user }}</td>
            <td>{{ $usuario->sede }}</td>
            <td>
            <a href="{{ url('/administracion/'.$usuario->id.'/edit') }}" class="btn btn-warning">
                Editar
            </a>
            | 
            <form action="{{ url('/administracion/'.$usuario->id ) }}" method="post" class="d-inline">
                @csrf
                {{ method_field("delete") }}
                <input type="submit" onclick="return confirm('¿Esta seguro de eliminar el registro?')" value="Eliminar" class="btn btn-danger">
            </form>       
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $users->links() !!}
</div>
@endsection