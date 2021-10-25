{!! csrf_field() !!}
<div class="row">

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">RUC <span class="required"></span></div>
    <div class="col-md-10">
        <input type="number" min="0" max="99999999999" name="ruc" id="ruc" value="{{ old('ruc', @$empresa->ruc) }}" placeholder="RUC" required class="form-control">
        @if ($errors->has('ruc'))
        <div class="invalid-feedback">{{ $errors->first('ruc') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Razón social <span class="required"></span></div>
    <div class="col-md-10">
        <input type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', @$empresa->razon_social) }}" placeholder="Razón social" required class="form-control">
        @if ($errors->has('razon_social'))
        <div class="invalid-feedback">{{ $errors->first('razon_social') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Seudonimo <span class="required"></span></div>
    <div class="col-md-10">
        <input type="text" name="seudonimo" id="seudonimo" value="{{ old('seudonimo', @$empresa->seudonimo) }}" placeholder="Seudonimo" required class="form-control">
        @if ($errors->has('seudonimo'))
        <div class="invalid-feedback">{{ $errors->first('seudonimo') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Ciudad <span class="required"></span></div>
    <div class="col-md-8 row">
        <div class="col-md-4">
            <select class="form-control form-ajax" name="departamento" @if(@$distrito) data-value="{{ @$distrito->coddepa }}" @endif data-ajax="/empresas/getProvincias" required>
                @foreach ($departamentos as $departamento)
                <option value="{{ $departamento->id }}">{{ $departamento->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control form-ajax" name="provincia" @if(@$distrito) data-value="{{ substr(@$distrito->ubigeo, 0, 4) }}" @endif data-ajax="/empresas/getDistritos" required>
                @foreach ($provincias as $provincia)
                <option value="{{ $provincia->id }}">{{ $provincia->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" @if(@$distrito) data-value="{{ @$distrito->ubigeo }}" @endif name="ubigeo_id" required>
                @foreach ($distritos as $distrito)
                <option value="{{ $distrito->id }}">{{ $distrito->value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Dirección <span class="required"></span></div>
    <div class="col-md-10">
        <input type="text" name="direccion" id="direccion" value="{{ old('direccion', @$empresa->direccion) }}" placeholder="Dirección" required class="form-control">
        @if ($errors->has('direccion'))
        <div class="invalid-feedback">{{ $errors->first('direccion') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Referencia</div>
    <div class="col-md-10">
        <input type="text" name="referencia" id="referencia" value="{{ old('referencia', @$empresa->referencia) }}" placeholder="Referencia" class="form-control">
        @if ($errors->has('referencia'))
        <div class="invalid-feedback">{{ $errors->first('referencia') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Telefonos</div>
    <div class="col-md-10">
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', @$empresa->telefono) }}" placeholder="Telefonos" class="form-control">
        @if ($errors->has('telefono'))
        <div class="invalid-feedback">{{ $errors->first('telefono') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Correo</div>
    <div class="col-md-10">
        <input type="text" name="correo_electronico" value="{{ old('correo_electronico', @$empresa->correo_electronico) }}" placeholder="Correo electrónico" class="form-control">
        @if ($errors->has('correo_electronico'))
        <div class="invalid-feedback">{{ $errors->first('correo_electronico') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Web</span></div>
    <div class="col-md-10">
        <input type="text" name="web" value="{{ old('web', @$empresa->web) }}" placeholder="Web" class="form-control">
        @if ($errors->has('web'))
        <div class="invalid-feedback">{{ $errors->first('web') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Aniversario</div>
    <div class="col-md-10">
        <input type="date" name="aniversario" value="{{ old('aniversario', @$empresa->aniversario) }}" placeholder="Aniversario" class="form-control">
        @if ($errors->has('aniversario'))
        <div class="invalid-feedback">{{ $errors->first('aniversario') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Sector <span class="required"></span></div>
    <div class="col-md-10">
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
</div>


<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">Categoria <span class="required"></span></div>
    <div class="col-md-10">
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
</div>


<div class="col-12">
<div class="form-group row">
    <div class="col-md-2">¿Es agente retencion?</div>
    <div class="col-md-10">
        <input type="checkbox" name="es_agente_retencion" value="1" placeholder="Es agente retencion" @if (@$empresa->es_agente_retencion)
        checked
        @endif
        >
        @if ($errors->has('es_agente_retencion'))
        <div class="invalid-feedback">{{ $errors->first('es_agente_retencion') }}</div>
        @endif
    </div>
</div>
</div>

<div class="col-12">
<div style="width:500px;margin:0 auto;">
    <div class="form-group row">
        <div class="col-6" style="text-align:center;">
            <button type="submit" class="btn btn-default" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                Guardar
            </button>
        </div>
        <div class="col-6" style="text-align:center;">
            <button type="submit" class="btn btn-default" style="color: #fff; background-color: #ccc;">
                Cancelar
            </button>
        </div>
    </div>
</div>
</div>
