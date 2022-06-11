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
                  <th>Items</th>
                  <th>Monto</th>
                  <th style="width:80px;">Emitida</th>
                  <th>Folder</th>
                  <th style="width:140px"></th>
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
                  <td class="text-center">{{ count($cotizacion->items()) }}</td>
                  <td class="text-center">{{ $cotizacion->monto() }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->fecha) }}</td>
                  <td class="text-center"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $cotizacion->folder()) !!}';">Folder</a></td>
<td style="width: 75px;text-align: center;">
         @if(!empty($cotizacion->proyecto()->id))
         <a href="{{ route( 'proyectos.show', [ 'proyecto' => $cotizacion->proyecto()->id ] ) }}" title="Ver el Proyecto"><i class="bx bx-share"></i></a>
         @else
         <a href="{{ route('cotizaciones.proyecto', ['cotizacion' => $cotizacion->id] ) }} " title="Convertir a Proyecto"><i class="bx bx-folder"></i></a>
         @endif
            <a href="{{ route('cotizacion.enviar',[ 'cotizacion'=> $cotizacion->id ])}}" title="Enviar propuesta" > <i class="bx bxs-up-arrow-square" ></i></a> 
         <a class="verDetalle" onclick="verDetalle(this)" data-target="#modalCotizacionDetalle"  data-id= "{{ $cotizacion->id }}"  href="javascript:void(0)" data-size="modal-lg"
data-toggle="modal" >
<i class="bx bxs-detail" title="detalle"></i></a> 
         <a href="{{ route( 'cotizacion.exportar', [ 'cotizacion' => $cotizacion->id ] ) }}" target="_blank" title="Exportar"><i class="bx bx-printer"></i></a>
         <a href="javascript:void(0)" data-popup="{{ route( 'cotizaciones.edit', [ 'cotizacion' => $cotizacion->id ] ) }}" title="Editar"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('cotizaciones.destroy',['cotizacion' => $cotizacion->id ])}}" title="Eliminar"><i class="bx bx-trash"></i></a>
      </td>
              </tr> 
              @endforeach 
              </tbody>
              </table>
         {{-- <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div> --}}
           </div>
          </div>
