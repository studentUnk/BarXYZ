<h2>{{ $fuente }} producto</h2>
<a href = "{{ url('inventario') }}" class="btn btn-primary"> Regresar</a>

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
    <label for="codigo_producto"> Nombre producto </label>
    <select class="form-select" name="codigo_producto" id="codigo_producto">
        @foreach($productos as $producto)
            <option value="{{ $producto->id}}">{{ $producto->nombre }}</option>
        @endforeach
    </select>
</div>
<div class="row">
    <div class="col">
        <label for="unidad"> Unidades </label>
        <input type="number" name="unidad" id="unidad" value="{{ isset($inventario->unidad)?$inventario->unidad:old('unidad')  }}" class="form-control">
    </div>
    <div class="col">
        <label for="precio"> Precio </label>
        <input type="number" step="0.01" name="precio" id="precio" value="{{ isset($inventario->precio)?$inventario->precio:old('precio')  }}" class="form-control">
    </div>
</div>
<br><br>
<div class="row">
    <input type="submit" value="{{ $fuente }} producto" class="btn btn-success">
</div>