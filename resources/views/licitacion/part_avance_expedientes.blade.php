          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce table-sm">
              <thead>
                <tr>
                  <th>Rótulo</th>
                  <th>Fecha</th>
                  <th>Elaborado</th>
                  <th>Finalización</th>
                  <th>Procesado</th>
                  <th>Usuario</th>
                </tr>
              </thead>
              <tbody>
              @foreach(App\Documento::expedientesTrabajando() as $d)
              <tr>
                <td><a href="/expediente/{{ $d->id }}/inicio">{{ $d->rotulo }}</a></td>
                <td>{{ fecha($d->elaborado_desde) }}</td>
                <td>{{ hora($d->elaborado_desde) }}</td>
                <td>{{ $d->duracion_elaborado }}</td>
                <td>{{ $d->duracion_procesado }}</td>
                <td>{{ $d->usuario }}</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
