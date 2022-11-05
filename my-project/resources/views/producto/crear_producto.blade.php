@extends('layouts.app')
@section('content')
<div class="container">

<form action="{{ url('/producto') }}" method="post">
    @csrf
    @include('producto.formulario_producto',['fuente'=>'Crear'])
</form>

</div>
@endsection