@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/administracion') }}" method="post">
    @csrf
    @include('administracion.formulario_usuario',['fuente'=>'Crear'])
</form>
</div>
@endsection