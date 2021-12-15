<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%;font-size:10px;">
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="#" target="_blank">Cronograma Licitación</a></th>
  </tr>
            @foreach ($licitacion->cronograma() as $cro)
              <tr>
                <th>{{ $cro->descripcionEtapa }}</th>
                @if (!Helper::es_pasado($cro->fechaInicio, $class))
                  <td style="padding-right: 10px;{{ $class }};">{{ $cro->fechaInicio }} {{ $cro->horaInicio }}</td>
                @else
                  <td class="tachado" style="padding-right: 10px;{{ $class }};">{{ $cro->fechaInicio }} {{ $cro->horaInicio }}</td>
                @endif
                @if (!Helper::es_pasado($cro->fechaFin, $class))
                  <td style="{{ $class }};">{{ $cro->fechaFin }} {{ $cro->horaFin }}</td>
                @else
                  <td class="tachado" style="{{ $class }};">{{ $cro->fechaFin }} {{ $cro->horaFin }}</td>
                @endif
              </tr>
            @endforeach
              </table>
