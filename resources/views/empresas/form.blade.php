{!! csrf_field() !!}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>RUC </label>
            <input type="number" min="0" max="99999999999" name="ruc" id="ruc" value="{{ old('ruc', @$empresa->ruc) }}" placeholder="RUC" required class="form-control">
            @if ($errors->has('ruc'))
            <div class="invalid-feedback">{{ $errors->first('ruc') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Razón social </label>
            <input type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', @$empresa->razon_social) }}" placeholder="Razón social" required class="form-control">
            @if ($errors->has('razon_social'))
            <div class="invalid-feedback">{{ $errors->first('razon_social') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Seudonimo </label>
            <input type="text" name="seudonimo" id="seudonimo" value="{{ old('seudonimo', @$empresa->seudonimo) }}" placeholder="Seudonimo" required class="form-control">
            @if ($errors->has('seudonimo'))
            <div class="invalid-feedback">{{ $errors->first('seudonimo') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Dirección </label>
            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', @$empresa->direccion) }}" placeholder="Dirección" required class="form-control">
            @if ($errors->has('direccion'))
            <div class="invalid-feedback">{{ $errors->first('direccion') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Referencia
        </div>
        <input type="text" name="referencia" id="referencia" value="{{ old('referencia', @$empresa->referencia) }}" placeholder="Referencia" class="form-control">
        @if ($errors->has('referencia'))
        <div class="invalid-feedback">{{ $errors->first('referencia') }}</div>
        @endif
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Telefonos</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', @$empresa->telefono) }}" placeholder="Telefonos" class="form-control">
            @if ($errors->has('telefono'))
            <div class="invalid-feedback">{{ $errors->first('telefono') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Correo</label>
            <input type="text" name="correo_electronico" value="{{ old('correo_electronico', @$empresa->correo_electronico) }}" placeholder="Correo electrónico" class="form-control">
            @if ($errors->has('correo_electronico'))
            <div class="invalid-feedback">{{ $errors->first('correo_electronico') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Web</label>
            <input type="text" name="web" value="{{ old('web', @$empresa->web) }}" placeholder="Web" class="form-control">
            @if ($errors->has('web'))
            <div class="invalid-feedback">{{ $errors->first('web') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Aniversario</label>
            <input type="date" name="aniversario" value="{{ old('aniversario', @$empresa->aniversario) }}" placeholder="Aniversario" class="form-control">
            @if ($errors->has('aniversario'))
            <div class="invalid-feedback">{{ $errors->first('aniversario') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Sector </label>
            <select name="sector_id" data-value="{{ old('sector_id', @$empresa->sector_id) }}" placeholder="Sector" required class="form-control">
                @foreach (App\Empresa::TipoSectores() as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('sector_id'))
            <div class="invalid-feedback">{{ $errors->first('sector_id') }}</div>
            @endif
        </div>
    </div>


    <div class="col-12">
        <div class="form-group">
            <label>Categoria</label>
            <select name="categoria_id" data-value="{{ old('categoria_id', @$empresa->categoria_id) }}" placeholder="Categoria" required class="form-control">
                @foreach (App\Empresa::TipoCategorias() as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('categoria_id'))
            <div class="invalid-feedback">{{ $errors->first('categoria_id') }}</div>
            @endif
        </div>
    </div>


    <div class="col-12">
        <div class="form-group">
            <label>¿Es agente retencion?</label>
            <input type="checkbox" name="es_agente_retencion" value="1" placeholder="Es agente retencion" @if (@$empresa->es_agente_retencion)
            checked
            @endif
            >
            @if ($errors->has('es_agente_retencion'))
            <div class="invalid-feedback">{{ $errors->first('es_agente_retencion') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">
            Guardar
        </button>
        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">
            Cancelar
        </button>
    </div>
