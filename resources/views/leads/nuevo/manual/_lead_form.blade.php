<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="tipo_id">Tipo de Lead *</label>
            <select name="tipo_id" id="tipo_id" 
                    class="form-control @error('tipo_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre_tipo }}
                    </option>
                @endforeach
            </select>
            @error('tipo_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="canal_id">Canal *</label>
            <select name="canal_id" id="canal_id" 
                    class="form-control @error('canal_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($canales as $canal)
                    <option value="{{ $canal->id }}" {{ old('canal_id') == $canal->id ? 'selected' : '' }}>
                        {{ $canal->nombre_canal }}
                    </option>
                @endforeach
            </select>
            @error('canal_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="estado_actual_id">Estado Actual *</label>
            <select name="estado_actual_id" id="estado_actual_id" 
                    class="form-control @error('estado_actual_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($estadosLead as $estado)
                    <option value="{{ $estado->id }}" {{ old('estado_actual_id') == $estado->id ? 'selected' : '' }}>
                        {{ $estado->nombre_estado }}
                    </option>
                @endforeach
            </select>
            @error('estado_actual_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="medio_contacto_id">Medio de Contacto *</label>
            <select name="medio_contacto_id" id="medio_contacto_id" 
                    class="form-control @error('medio_contacto_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($mediosContacto as $medio)
                    <option value="{{ $medio->id }}" {{ old('medio_contacto_id') == $medio->id ? 'selected' : '' }}>
                        {{ $medio->nombre_medio }}
                    </option>
                @endforeach
            </select>
            @error('medio_contacto_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="forma_registro_id">Forma de Registro *</label>
            <select name="forma_registro_id" id="forma_registro_id" 
                    class="form-control @error('forma_registro_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($formasRegistro as $forma)
                    <option value="{{ $forma->id }}" {{ old('forma_registro_id') == $forma->id ? 'selected' : '' }}>
                        {{ $forma->nombre_forma }}
                    </option>
                @endforeach
            </select>
            @error('forma_registro_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="modelo_id">Modelo de Vehículo</label>
            <select name="modelo_id" id="modelo_id" 
                    class="form-control @error('modelo_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach($modelos as $modelo)
                    <option value="{{ $modelo->id }}" {{ old('modelo_id') == $modelo->id ? 'selected' : '' }}>
                        {{ $modelo->nombre_modelo }}
                    </option>
                @endforeach
            </select>
            @error('modelo_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="observacion">Observación</label>
    <textarea name="observacion" id="observacion" 
              class="form-control @error('observacion') is-invalid @enderror" 
              rows="3">{{ old('observacion') }}</textarea>
    @error('observacion')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>