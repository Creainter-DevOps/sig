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
                <td>{{ $d->duracion_procesado }}</td>
                <td>{{ $d->folio }}</td>
                <td>{{ byteConvert($d->filesize) }}</td>
                <td>
@if(!empty($d->revisado_el))
@if($d->revisado_status)
<div title="{{ $d->revisado_el }}" style="background:#61e561;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->revisado_por }}</div>
@else
<div title="{{ $d->revisado_el }}" style="background:#ff6159;text-align:center;border-radius:5px;color:#fff;font-size: 11px;display: inline;padding: 3px 6px;">{{ $d->revisado_por }}</div>
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
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
