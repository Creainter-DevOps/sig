          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce table-sm">
              <thead>
                <tr>
                  <th>Rótulo</th>
                  <th>Fecha</th>
                  <th>Usuario</th>
                  <th>Iniciado</th>
                  <th>Elaboración</th>
                  <th>Procesado</th>
                  <th>Revisado</th>
                  <th>Enviado</th>
                </tr>
              </thead>
              <tbody>
              @foreach(App\Documento::expedientesTrabajando() as $d)
              <tr data-link="/oportunidades/{{ $d->oportunidad_id }}/">
                <td><a href="/documentos/{{ $d->id }}/expediente/inicio">{{ $d->rotulo }}</a></td>
                <td>{{ fecha($d->elaborado_desde) }}</td>
                <td>{{ $d->usuario }}</td>
                <td>{{ hora($d->elaborado_desde) }}</td>
                <td>{{ $d->duracion_elaborado }}</td>
                <td>{{ $d->duracion_procesado }}</td>
                <td>
@if(!empty($d->revisado_el))
@if($d->revisado_status)
<div title="{{ $d->revisado_el }}" style="background:#61e561;text-align:center;border-radius:5px;color:#fff;">{{ $d->revisado_por }}</div>
@else
<div title="{{ $d->revisado_el }}" style="background:#ff6159;text-align:center;border-radius:5px;color:#fff;">{{ $d->revisado_por }}</div>
@endif
@endif

                </td>
                <td>
{{ $d->propuesta_por }}
</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
