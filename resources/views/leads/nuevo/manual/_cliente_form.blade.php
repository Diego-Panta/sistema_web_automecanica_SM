<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nombre">Nombres *</label>
            <input type="text" name="nombre" id="nombre" 
                   class="form-control @error('nombre') is-invalid @enderror" 
                   value="{{ old('nombre') }}" required>
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="apellido_paterno">Apellido Paterno *</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" 
                   class="form-control @error('apellido_paterno') is-invalid @enderror" 
                   value="{{ old('apellido_paterno') }}" required>
            @error('apellido_paterno')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="apellido_materno">Apellido Materno</label>
            <input type="text" name="apellido_materno" id="apellido_materno" 
                   class="form-control @error('apellido_materno') is-invalid @enderror" 
                   value="{{ old('apellido_materno') }}">
            @error('apellido_materno')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="dni">DNI</label>
            <input type="text" name="dni" id="dni" 
                   class="form-control @error('dni') is-invalid @enderror" 
                   value="{{ old('dni') }}" maxlength="8">
            @error('dni')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="celular">Celular</label>
            <input type="text" name="celular" id="celular" 
                   class="form-control @error('celular') is-invalid @enderror" 
                   value="{{ old('celular') }}" maxlength="9">
            @error('celular')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="celular_alterno">Celular Alterno</label>
            <input type="text" name="celular_alterno" id="celular_alterno" 
                   class="form-control @error('celular_alterno') is-invalid @enderror" 
                   value="{{ old('celular_alterno') }}" maxlength="9">
            @error('celular_alterno')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="estado_cliente_id">Estado del Cliente *</label>
            <select name="estado_cliente_id" id="estado_cliente_id" 
                    class="form-control @error('estado_cliente_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($estadosCliente as $estado)
                    <option value="{{ $estado->id }}" {{ old('estado_cliente_id') == $estado->id ? 'selected' : '' }}>
                        {{ $estado->nombre_estado }}
                    </option>
                @endforeach
            </select>
            @error('estado_cliente_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" 
                   class="form-control @error('correo') is-invalid @enderror" 
                   value="{{ old('correo') }}">
            @error('correo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>