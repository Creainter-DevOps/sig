<div style="margin-top: -25px;text-align: right;">
  <button type="button" class="btn btn-sm m-0" data-popup="/cotizaciones/crear?oportunidad_id={{ $oportunidad->id }}">
    <i class="bx bx-plus"></i>Nueva Cotización
  </button>
</div>
          <div class="table-responsive">
          <table class="table table-sm mb-0 table-bordered table-vcenter "  style="width:100%">
            <thead>
              <tr>
               <th colspan="7" class="table-head"><a class="link-primary" href="" target="_blank">Cotizaciones</a></th>
              </tr>
              <tr class="text-center">
                  <th>Empresa</th>
                  <th>Número</th>
                  <th>Monto</th>
                  <th>Emitida</th>
                  <th>Validez</th>
                  <th>Folder</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach ($oportunidad->cotizaciones() as $cotizacion)
              @if(!empty($cotizacion->proyecto()->id))
                <tr style="background:#bfffcd;">
              @else
                <tr>
              @endif
                  <td>{{ $cotizacion->empresa()->seudonimo }}</td>
                  <td class="text-center">{{ $cotizacion->numero }}</td>
                  <td class="text-center">{{ $cotizacion->monto() }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->fecha ) }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->validez ) }}</td>
                  <td class="text-center"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $cotizacion->folder()) !!}';">Folder</a></td>
<td style="width: 75px;text-align: center;">
         @if(!empty($cotizacion->proyecto()->id))
         <a href="{{ route( 'proyectos.show', [ 'proyecto' => $cotizacion->proyecto()->id ] ) }}"><i class="bx bx-share"></i></a>
         @else
         <a href="{{  route('cotizaciones.proyecto', ['cotizacion' => $cotizacion->id] ) }} " ><i class="bx bx-folder"></i></a>
         @endif

         <a href="javascript:void(0)" data-popup="{{ route( 'cotizaciones.edit', [ 'cotizacion' => $cotizacion->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('cotizaciones.destroy', [ 'cotizacion' => $cotizacion->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
              </tr> 
              @endforeach 
              </tbody>
              </table>
         {{-- <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div> --}}
           </div>
          </div>
