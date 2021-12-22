    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Registro Rápido de Cliente</h3>
        </div>
        <div class="block-content">
            <form action="/clientes" method="POST" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group row">
                    <div class="col-md-2">RUC <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="number" min="0" max="99999999999" name="ruc" id="ruc" value="{{ old('ruc', @$empresa->ruc) }}" placeholder="RUC" required class="form-control">
                        @if ($errors->has('ruc'))
                        <div class="invalid-feedback">{{ $errors->first('ruc') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">Razón social <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', @$empresa->razon_social) }}" placeholder="Razón social" required class="form-control">
                        @if ($errors->has('razon_social'))
                        <div class="invalid-feedback">{{ $errors->first('razon_social') }}</div>
                        @endif
                    </div>
                </div>

                <div style="width:500px;margin:0 auto;">
                    <div class="form-group row">
                        <div class="col-6" style="text-align:center;">
                            <button type="submit" class="btn btn-default btn-sm" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                                Registrar
                            </button>
                        </div>
                        <div class="col-6" style="text-align:center;">
                            <a class="btn btn-secondary btn-sm" href="/clientes/crear">
                                Ir a registro detallado
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
