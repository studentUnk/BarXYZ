@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/producto/'.$producto->id) }}" method="post">
    @csrf
    {{ method_field('patch') }}
    @include('producto.formulario_producto',['fuente'=>'Editar'])
</form>
</div>
@endsection