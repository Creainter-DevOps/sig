<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Proyecto</a></th>
  </tr>
</thead>
              <tbody>
                <tr>
                  <th>Código</th>
                  <td><a href="javascript:void(0);" data-popup="/documentos/visor?path={{ $proyecto->folder(true) }}&pid={{ $proyecto->id }}">{{ $proyecto->codigo }}</a></td>
                  <th>Proveedor:</th>
                  <td>{{ $proyecto->empresa()->razon_social }}</td>
                </tr>
                <tr>
                  <th>Cliente</th>
                  <td colspan="3"><a href="/empresas/{{ $proyecto->cliente()->empresa_id }}">{{ $proyecto->cliente()->rotulo() }}</a></td>
                </tr>
                <tr>
                  <th>Color</th>
                  <td>
                    <input type="color" name="color" data-editable="/proyectos/{{ $proyecto->id }}?_update=color" value="{{ $proyecto->color }}">
                  </td>
                  <th>Alias:</th>
                  <td>
                    <input type="text" name="alias" data-editable="/proyectos/{{ $proyecto->id }}?_update=alias" value="{{ $proyecto->alias }}">
                  </td>
                </tr>
                 <tr>
                  <th>Fecha del Consentimiento</th>
                  <td>
                    <input type="date" name="fecha_consentimiento" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_consentimiento" value="{{ $proyecto->fecha_consentimiento }}">
                    <div style="text-align: center;font-size: 12px;">{{ $proyecto->fechaCalculadaConsentimiento() }}</div>
                  </td>
                  <th>Firma de Contrato</th>
                  <td>
                    <input type="date" name="fecha_firma" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_firma" value="{{ $proyecto->fecha_firma }}">
                    <div style="text-align: center;font-size: 12px;">{{ $proyecto->fechaCalculadaPerfeccionamiento() }}</div>
                  </td>
                  <!-- <input type="color" name="color" data-editable="/proyectos/{{ $proyecto->id }}?_update=color" value="{{ $proyecto->color }}"></td>-->
                </tr>
                <tr>
                  <th>Inicio de Servicio</th>
                  <td>
                    <input type="date" name="fecha_desde" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_desde" value="{{ $proyecto->fecha_desde }}">
                  </td>
                  <th>Fecha de Fin:</th>
                  <td>
                    <input type="date" name="fecha_hasta" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_hasta" value="{{ $proyecto->fecha_hasta }}">
                  </td>
                </tr>
                <tr>
                  <th>Responsables:</th>
                  <td colspan="3">
                    <div class="form-row">
                      <div class="col-md-4">
                        <label for="responsable_financiero">Financiero</label>
                        <select class="form-control" name="responsable_financiero" data-editable="/proyectos/{{ $proyecto->id }}?_update=responsable_financiero" data-value="{{ $proyecto->responsable_financiero }}">
                          <option value="">No asignado</option>
                          @foreach(App\Actividad::usuarios() as $u)
                          <option value="{{ $u->id }}">{{ $u->usuario }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="responsable_entregable">Entregable</label>
                        <select class="form-control" name="responsable_entregable" data-editable="/proyectos/{{ $proyecto->id }}?_update=responsable_entregable" data-value="{{ $proyecto->responsable_entregable }}">
                          <option value="">No asignado</option>
                          @foreach(App\Actividad::usuarios() as $u)
                          <option value="{{ $u->id }}">{{ $u->usuario }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="responsable_tecnico">Técnico</label>
                        <select class="form-control" name="responsable_tecnico" data-editable="/proyectos/{{ $proyecto->id }}?_update=responsable_tecnico" data-value="{{ $proyecto->responsable_tecnico }}">
                          <option value="">No asignado</option>
                          @foreach(App\Actividad::usuarios() as $u)
                          <option value="{{ $u->id }}">{{ $u->usuario }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th>Cuentas:</th>
                  <td colspan="3">
                    <div class="form-row">
                      <div class="col-md-4">
                        <label for="cuenta_corriente_id">Corriente</label>
                        <select class="form-control" name="cuenta_corriente_id" data-editable="/proyectos/{{ $proyecto->id }}?_update=cuenta_corriente_id" data-value="{{ $proyecto->cuenta_corriente_id }}">
                          <option value="">No asignado</option>
                          @foreach(App\Contable::cuentas($proyecto->empresa_id) as $u)
                          <option value="{{ $u->id }}">{{ $u->rotulo }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="cuenta_detraccion_id">Detracción</label>
                        <select class="form-control" name="cuenta_detraccion_id" data-editable="/proyectos/{{ $proyecto->id }}?_update=cuenta_detraccion_id" data-value="{{ $proyecto->cuenta_detraccion_id }}">
                          <option value="">No asignado</option>
                          @foreach(App\Contable::cuentas($proyecto->empresa_id) as $u)
                          <option value="{{ $u->id }}">{{ $u->rotulo }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="porcentaje_detraccion">% Detracción</label>
                        <input type="number" class="form-control" name="porcentaje_detraccion" data-editable="/proyectos/{{ $proyecto->id }}?_update=porcentaje_detraccion" value="{{ $proyecto->porcentaje_detraccion }}" min="0" max="12">
                      </div>
                    </div>
                  </td>
                </tr>
    <tr>
      <th>Estado</th>
      <td colspan="3">
         <select class="form-control select-data" data-editable="/proyectos/{{ $proyecto->id }}?_update=estado" data-value="{{ $proyecto->estado }}">
@foreach(App\Proyecto::selectEstados() as $k => $n)
          <option value="{{ $k }}" style="color:#fff;background-color: {{ $n['color'] }};">{{ $n['name'] }}</option>
@endforeach
         </select>
      </td>
    </tr>
  </tbody>
</table>
