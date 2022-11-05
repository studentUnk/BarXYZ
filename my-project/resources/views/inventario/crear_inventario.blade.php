@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/inventario') }}" method="post">
    @csrf
    @include('inventario.formulario_inventario',['fuente'=>'Crear'])
</form>
</div>
@endsection