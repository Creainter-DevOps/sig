            <table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%;font-size:12px;">
              <thead>
                <th>Item</th>
                <th>Descripción</th>
                <th>Participé</th>
                <th>Resultado</th>
                <th>Referencial</th>
              </thead>
              <tbody>
            @foreach($licitacion->relacionadas() as $e)
            <tr>
              <td class="text-center"><a href="/licitaciones/{{ $e->id }}">{{ $e->nomenclatura }}</a></td>
              <td>{{ substr($e->rotulo, 0, 30) }}</td> 
              <td class="text-center">{{ !empty($e->con_oportunidad) ? 'SI' : '' }}</td>
              <td class="text-center">{{ $e->ganadora() }}</td>
              <td class="text-center">{{ Helper::money($e->valor_referencial) }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>
