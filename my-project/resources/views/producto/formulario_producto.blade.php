<h2>{{ $fuente }} producto</h2>
<a href = "{{ url('producto') }}" class="btn btn-primary"> Regresar</a>

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
    <label for="nombre"> Nombre </label>
    <input type="text" name="nombre" id="nombre" value="{{ isset($producto->nombre)?$producto->nombre:old('nombre') }}" class="form-control">
</div>
<div class="col">
    <label for="desripcion"> Descripcion </label>
    <input type="text" name="desripcion" id="desripcion" value="{{ isset($producto->desripcion)?$producto->desripcion:old('desripcion')  }}" class="form-control">
</div>
</div>
<br><br>
<div class="row">
    <input type="submit" value="{{ $fuente }} producto" class="btn btn-success">
</div>