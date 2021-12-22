            <form action="/clientes/{{ $cliente->id }}/add-representante" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-content" style="width:800px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRepresentanteModalLabel">Nuevo Contacto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Cliente <span class="required"></span>
                                </div>
                                <div class="col-md-4 form-group">
                                {{ $cliente->empresa()->razon_social }}
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Documento <span class="required"></span>
                                </div>
                                <div class="col-md-4">
                                    <select name="tipo_documento_id" style="width: 100px;" class="form-control">
                                        <option value="1">DNI</option>
                                        <option value="2">Carné de Extranjería</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="text"
                                    name="numero_documento"
                                    placeholder="Número de documento"
                                    required
                                    class="form-control">
                                    @if ($errors->has('numero_documento'))
                                    <div class="invalid-feedback">{{ $errors->first('numero_documento') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Nombres <span class="required"></span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"
                                        name="nombres"
                                        placeholder="Nombres"
                                        required
                                        class="form-control">
                                        @if ($errors->has('nombres'))
                                        <div class="invalid-feedback">{{ $errors->first('nombres') }}</div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Apellidos <span class="required"></span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"
                                        name="apellidos"
                                        placeholder="Apellidos"
                                        required
                                        class="form-control">
                                        @if ($errors->has('apellidos'))
                                        <div class="invalid-feedback">{{ $errors->first('apellidos') }}</div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Correo electrónico <span class="required"></span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"
                                        name="correo_electronico"
                                        placeholder="Correo"
                                        required
                                        class="form-control">
                                        @if ($errors->has('correo_electronico'))
                                        <div class="invalid-feedback">{{ $errors->first('correo_electronico') }}</div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Telefonos <span class="required"></span>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"
                                        name="telefono"
                                        placeholder="telefono"
                                        required
                                        class="form-control">
                                        @if ($errors->has('telefono'))
                                        <div class="invalid-feedback">{{ $errors->first('telefono') }}</div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Genero <span class="required"></span>
                                </div>
                                <div class="col-md-2 row">
                                    <input type="radio" name="genero" value="M" checked style="margin-top:5px;">
                                    <label> Masculino</label>
                                </div>
                                <div class="col-md-3 row">
                                    <input type="radio" name="genero" value="F" style="margin-top:5px;">
                                    <label> Femenino</label>
                                </div>
                                <div class="col-md-5 row">
                                    <label style="margin-right: 20px;">Cumpleanos</label>
                                    <input type="date" name="cumpleanhos" id="Representante_cumpleanos">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-3 text-right">
                                    Tipo de Contacto <span class="required"></span>
                                </div>
                                <div class="col-md-9">
                                    <select name="cargo_id" style="width: 100%;" class="form-control">
                                        <option value="1">Representante Legal</option>
                                        <option value="2">Marketing</option>
                                        <option value="3">Marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>

