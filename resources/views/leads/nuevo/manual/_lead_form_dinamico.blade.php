<!-- Campos específicos para Compra -->
<div id="camposCompra" class="campos-especificos" style="display: none;">
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">Campos Específicos - Compra</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tiempo_compra" class="field-required">Tiempo Estimado de Compra *</label>
                        <select name="tiempo_compra" id="tiempo_compra" 
                               class="form-control @error('tiempo_compra') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            <option value="Este mes" {{ old('tiempo_compra') == 'Este mes' ? 'selected' : '' }}>Este mes</option>
                            <option value="En 1 a 3 meses" {{ old('tiempo_compra') == 'En 1 a 3 meses' ? 'selected' : '' }}>En 1 a 3 meses</option>
                            <option value="En 3 a 6 meses" {{ old('tiempo_compra') == 'En 3 a 6 meses' ? 'selected' : '' }}>En 3 a 6 meses</option>
                        </select>
                        @error('tiempo_compra')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="financiamiento">Deseo un Crédito Vehicular</label>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="financiamiento" id="financiamiento" 
                                   class="form-check-input" value="1" {{ old('financiamiento') ? 'checked' : '' }}>
                            <label class="form-check-label" for="financiamiento">Sí, deseo financiamiento</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Campos específicos para Postventa -->
<div id="camposPostventa" class="campos-especificos" style="display: none;">
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Campos Específicos - Postventa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="numero_placa" class="field-required">Número de Placa *</label>
                        <input type="text" name="numero_placa" id="numero_placa" 
                               class="form-control @error('numero_placa') is-invalid @enderror" 
                               value="{{ old('numero_placa') }}" maxlength="10" placeholder="ABC-123">
                        @error('numero_placa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kilometraje" class="field-required">Kilometraje *</label>
                        <input type="number" name="kilometraje" id="kilometraje" 
                               class="form-control @error('kilometraje') is-invalid @enderror" 
                               value="{{ old('kilometraje') }}" min="0" placeholder="50000">
                        @error('kilometraje')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_servicio_id" class="field-required">Tipo de Servicio *</label>
                        <select name="tipo_servicio_id" id="tipo_servicio_id" 
                               class="form-control @error('tipo_servicio_id') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach($tiposServicio as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_servicio_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre_tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_servicio_id')
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
                        <label for="fecha_cita" class="field-required">Fecha de la Cita *</label>
                        <input type="date" name="fecha_cita" id="fecha_cita" 
                               class="form-control @error('fecha_cita') is-invalid @enderror" 
                               value="{{ old('fecha_cita') }}" required>
                        @error('fecha_cita')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="horario_cita" class="field-required">Horarios Disponibles *</label>
                        <select name="horario_cita" id="horario_cita" 
                               class="form-control @error('horario_cita') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            <option value="Mañana (8:00 - 12:00)" {{ old('horario_cita') == 'Mañana (8:00 - 12:00)' ? 'selected' : '' }}>Mañana (8:00 - 12:00)</option>
                            <option value="Tarde (13:00 - 17:00)" {{ old('horario_cita') == 'Tarde (13:00 - 17:00)' ? 'selected' : '' }}>Tarde (13:00 - 17:00)</option>
                            <option value="Noche (18:00 - 20:00)" {{ old('horario_cita') == 'Noche (18:00 - 20:00)' ? 'selected' : '' }}>Noche (18:00 - 20:00)</option>
                        </select>
                        @error('horario_cita')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Campos específicos para Repuesto -->
<div id="camposRepuesto" class="campos-especificos" style="display: none;">
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0">Campos Específicos - Repuesto</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero_placa_repuesto" class="field-required">Número de Placa *</label>
                        <input type="text" name="numero_placa" id="numero_placa_repuesto" 
                               class="form-control @error('numero_placa') is-invalid @enderror" 
                               value="{{ old('numero_placa') }}" maxlength="10" placeholder="ABC-123">
                        @error('numero_placa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="observacion_repuesto">Consulta</label>
                        <textarea name="observacion" id="observacion_repuesto" 
                                  class="form-control @error('observacion') is-invalid @enderror" 
                                  rows="3" placeholder="Describe qué repuesto necesitas...">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
