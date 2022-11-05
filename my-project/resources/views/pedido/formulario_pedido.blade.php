<h2>{{ $fuente }} pedido</h2>
<a href = "{{ url('pedido') }}" class="btn btn-primary"> Regresar</a>

@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<input id="pedido" name="pedido" type="hidden" value="{{ $pedido }}">

<div class="row">
    <div class="col">
        <label for="codigo_producto"> Producto (nombre->precio) </label>
        <select class="form-select" name="codigo_producto" id="codigo_producto">
            @foreach($productos as $producto)
                <option value="{{ $producto->id}}">{{ $producto->nombre }} -> ${{ $producto->precio}}</option>
            @endforeach
        </select>
</div>

<div class="col">
    <label for="codigo_combo"> Combo (nombre->precio) </label>
    <select class="form-select" name="codigo_combo" id="codigo_combo">
        @foreach($combos as $combo)
                <option value="{{ $combo->id}}">{{ $combo->nombre }} -> ${{ $combo->precio}}</option>
        @endforeach
    </select>
</div>
</div>
<div class="row">
<div class="col">
    <label for="cantidad"> Cantidad </label>
    <input type="number" name="cantidad" id="cantidad" class="form-control">
</div>
</div>
<br><br>
<div class="row">
    <input type="submit" value="Agregar producto" class="btn btn-success">
</div>