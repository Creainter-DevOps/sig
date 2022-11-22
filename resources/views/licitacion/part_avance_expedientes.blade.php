          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce table-sm">
              <thead>
                <tr>
                  <th>Rótulo</th>
                  <th>Fecha</th>
                  <th>Usuario</th>
                  <th>Elab.</th>
                  <th>Procesado</th>
                  <th>Folio</th>
                  <th>Size</th>
                  <th>Revisado</th>
                  <th>Enviado</th>
                </tr>
              </thead>
              <tbody>
              @foreach(App\Documento::expedientesTrabajando() as $d)
              <tr data-link="/oportunidades/{{ $d->oportunidad_id }}/">
                <td><a href="/documentos/{{ $d->id }}/expediente/inicio" title="{{ $d->descripcion }}">{{ $d->rotulo }}</a></td>
                <td>{{ fecha($d->fecha) }}</td>
                <td><div style="background:#5c5a58;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->usuario }}</div></td>
                <td><div title="Desde las {{ hora($d->elaborado_desde) }}">{{ $d->duracion_elaborado }}</div></td>
@if(empty($d->finalizado_el))
<td colspan="5" style="text-align:center">En Mesa de Trabajo por {{ $d->usuario }}</td>
@else
<td>{{ $d->duracion_procesado }}</td>
@if(!empty($d->procesado_desde) && empty($d->procesado_hasta))
                <td colspan="4" style="text-align:center;"><i class="bx bx-loader bx-spin" style="font-size:14px;"></i> Procesando {{ $d->folio }} pags.</td>
@else
                <td>{{ $d->folio }}</td>
                <td>{{ byteConvert($d->filesize) }}</td>
                <td>
@if(!empty($d->revisado_el))
@if($d->revisado_status)
<div title="{{ $d->revisado_el }}" style="background:#61e561;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->revisado_por }}</div>
@else
<div title="{{ $d->revisado_el }}" style="background:#ff6159;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->revisado_por }}</div>
@endif
@else
@if(!empty($d->finalizado_el))
    <div title="Es requerido revisar el Expediente" style="background:#ffa83b;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">Revisar</div>
@endif
@endif
                </td>
                <td>
@if(!empty($d->propuesta_por))
  <div title="{{ $d->revisado_el }}" style="background:#61e561;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->propuesta_por }}</div>
@else
@if(!empty($d->revisado_el))
  @if(!empty($d->revisado_status))
    <div title="Es requerido enviar el expediente" style="background:#ffa83b;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">Requiere</div>
  @endif
@endif
@endif
                </td>
@endif                
@endif
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
