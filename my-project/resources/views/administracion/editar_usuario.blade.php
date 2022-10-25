@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/administracion/'.$user->id) }}" method="post">
    @csrf
    {{ method_field('patch') }}
    @include('administracion.formulario_usuario',['fuente'=>'Editar'])
</form>
</div>
@endsection