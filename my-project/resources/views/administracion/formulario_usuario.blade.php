<h2>{{ $fuente }} usuario</h2>
<a href = "{{ url('administracion') }}" class="btn btn-primary"> Regresar</a>

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
    <label for="name"> Nombre </label>
    <input type="text" name="name" id="name" value="{{ isset($user->name)?$user->name:old('name') }}" class="form-control">
</div>
<div class="col">
    <label for="last_name"> Apellido </label>
    <input type="text" name="last_name" id="last_name" value="{{ isset($user->last_name)?$user->last_name:old('last_name')  }}" class="form-control">
</div>
</div>
<div class="row">
<div class="col">
    <label for="email"> Correo </label>
    <input type="text" name="email" id="email" value="{{ isset($user->email)?$user->email:old('email')  }}" class="form-control">
</div>
<div class="col">
    <label for="phone"> Telefono </label>
    <input type="text" name="phone" id="phone" value="{{ isset($user->phone)?$user->phone:old('phone')  }}" class="form-control">
</div>
</div>
<div class="row">
<label for="password"> Contraseña </label>
    <input type="password" name="password" id="password" value="{{ isset($user->password)?$user->password:old('password')  }}" class="form-control">
</div>
    <div class="row">
    <div class="col">
        <label for="type_user"> Tipo de usuario </label>
        <select class="form-select" name="type_user" id="type_user">
            @foreach($tipos_usuario as $tipo_usuario)
                <option value="{{ $tipo_usuario->id}}">{{ $tipo_usuario->descripcion }}</option>
            @endforeach
        </select>
</div>

<div class="col">
    <label for="sede"> Sede </label>
    <select class="form-select" name="sede" id="sede">
            @foreach($sedes as $sede)
                <option value="{{ $sede->id}}">{{ $sede->nombre }}</option>
            @endforeach
        </select>
</div>
</div>
<br><br>
<div class="row">
    <input type="submit" value="{{ $fuente }} usuario" class="btn btn-success">
</div>