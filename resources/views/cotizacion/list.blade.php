          <div class="table-responsive">
          <table class="table table-sm mb-0 table-bordered table-vcenter "  style="width:100%">
            <thead>
              <tr>
               <th colspan="7" class="table-head"><a class="link-primary" href="" target="_blank">Cotizaciones  </a></th>
              </tr>
              <tr>
                  <th>Código</th>
                  <th>M.Total</th>
                  <th>M.Fecha</th>
                  <th>Validez</th>
                </tr>
              </thead>
              <tbody id="table-body" >
                @foreach ( $listado as $cotizacion )
                <tr>
                  <td><a href="{{ route('cotizaciones.show',['cotizacion' =>  $cotizacion->id ])}}" >{{ $cotizacion->codigo }}</td>
                  <td class="text-success" align="left" >{{ $cotizacion->monto_total }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->fecha ) }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->validez ) }}</td>
                <!--  <td>
                    <div class="dropdown">
                      <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/cotizaciones/{{$cotizacion->id}}"><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                        <a class="dropdown-item" href="/cotizaciones/{{$cotizacion->id}}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                        <a class="dropdown-item" data-confirm-remove="{{ route('cotizaciones.destroy', ['cotizacion' => $cotizacion->id ]) }}" href="#" >
                         <i class="bx bx-trash mr-1"></i> Eliminar</a>
                      </div>
                    </div>
                  </td>-->
              </tr> 
              @endforeach 
              </tbody>
              </table>
         {{-- <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div> --}}
           </div>
          </div>
