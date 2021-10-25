<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Datos Requeridos</h3>
    </div>
    <div class="block-content">
        @if(!empty($controlador))
        <form action="/permissions/controlador/{{ $controlador->id }}/edit" method="POST" class="form-horizontal">
            @else
            <form action="/permissions/controlador" method="POST" class="form-horizontal">
                @endif
                {!! csrf_field() !!}

                <div class="form-group row">
                    <div class="col-md-2">Rótulo <span class="required"></span></div>
                    <div class="col-md-10">
                    <input type="text" name="controlador_padre_id" value="{{ old('controlador_padre_id', @$controlador->controlador_padre_id) }}" @if(!empty($controlador->controlador_padre_id))
                data-value="{{ $controlador->padre()->rotulo() }}"
                @endif
                placeholder="Modulo padre"
                class="form-control autocomplete"
                data-ajax="/permissions/autocomplete_modulo/">
                        @if ($errors->has('controlador_padre_id'))
                        <div class="invalid-feedback">{{ $errors->first('controlador_padre_id') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">Rótulo <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="text" name="rotulo" value="{{ old('rotulo', @$controlador->rotulo) }}" placeholder="Rótulo" required class="form-control">
                        @if ($errors->has('rotulo'))
                        <div class="invalid-feedback">{{ $errors->first('rotulo') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">Link <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="text" name="link" value="{{ old('link', @$controlador->link) }}" placeholder="Link" required class="form-control">
                        @if ($errors->has('link'))
                        <div class="invalid-feedback">{{ $errors->first('link') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">Permisos <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="text" name="permisos" value="{{ old('link', @$controlador->permisos) }}" placeholder="edit,remove" required class="form-control">
                        @if ($errors->has('permisos'))
                        <div class="invalid-feedback">{{ $errors->first('permisos') }}</div>
                        @endif
                    </div>
                </div>
                <div style="width:500px;margin:0 auto;">
                    <div class="form-group row">
                        <div class="col-6" style="text-align:center;">
                            <button type="submit" class="btn btn-default" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                                Guardar
                            </button>
                        </div>
                        <div class="col-6" style="text-align:center;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #fff; background-color: #ccc;">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>

