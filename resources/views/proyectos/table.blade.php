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
                  <td colspan="3">{{ $proyecto->cliente()->rotulo() }}</td>
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
                  <td><input type="date" name="fecha_consentimiento" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_consentimiento" value="{{ $proyecto->fecha_consentimiento }}"></td>
                  <th>Firma de Contrato</th>
                  <td><input type="date" name="fecha_firma" data-editable="/proyectos/{{ $proyecto->id }}?_update=fecha_firma" value="{{ $proyecto->fecha_firma }}"></td>
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
