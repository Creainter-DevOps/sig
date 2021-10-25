<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Datos Requeridos</h3>
    </div>
    <div class="block-content">
        @if(!empty($grupo))
        <form action="/permissions/grupo/{{ $grupo->id }}/edit" method="POST" class="form-horizontal">
            @else
            <form action="/permissions/grupo" method="POST" class="form-horizontal">
                @endif
                {!! csrf_field() !!}

                <div class="form-group row">
                    <div class="col-md-2">Nombre <span class="required"></span></div>
                    <div class="col-md-10">
                        <input type="text" name="nombre" value="{{ old('nombre', @$grupo->nombre) }}" placeholder="Nombre" required class="form-control">
                        @if ($errors->has('nombre'))
                        <div class="invalid-feedback">{{ $errors->first('nombre') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">Descripción <span class="required"></span></div>
                    <div class="col-md-10">
                        <textarea name="descripcion" placeholder="Grupo designado a ..." required class="form-control">{{ old('descripcion', @$grupo->descripcion) }}</textarea>
                        @if ($errors->has('descripcion'))
                        <div class="invalid-feedback">{{ $errors->first('descripcion') }}</div>
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

