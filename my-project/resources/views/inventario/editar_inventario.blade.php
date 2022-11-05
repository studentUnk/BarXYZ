@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/inventario/'.$inventario->id) }}" method="post">
    @csrf
    {{ method_field('patch') }}
    @include('inventario.formulario_inventario',['fuente'=>'Editar'])
</form>
</div>
@endsection