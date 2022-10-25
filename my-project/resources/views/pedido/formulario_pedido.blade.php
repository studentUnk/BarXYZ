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

<div class="row">
    <div class="col">
        <label for="codigo_producto"> Producto (nombre->precio) </label>
        <select class="form-select" name="codigo_producto" id="codigo_producto">
            <option value="-1">------</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id}}">{{ $producto->nombre }} -> ${{ $producto->precio}}</option>
            @endforeach
        </select>
</div>

<div class="col">
    <label for="codigo_combo"> Combo (nombre->precio) </label>
    <select class="form-select" name="codigo_combo" id="codigo_combo">
        <option value="-1">------</option>
        @foreach($combos as $combo)
                <option value="{{ $combo->id}}">{{ $combo->nombre }} -> ${{ $combo->precio}}</option>
        @endforeach
    </select>
</div>
</div>
<div class="row">
<div class="col">
    <label for="name"> Cantidad </label>
    <input type="text" name="name" id="name" value="{{ isset($user->name)?$user->name:old('name') }}" class="form-control">
</div>
</div>
<br><br>
<div class="row">
    <input type="submit" value="Agregar producto" class="btn btn-success">
</div>