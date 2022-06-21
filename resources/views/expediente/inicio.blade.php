@extends('expediente.theme')
@section('contenedor')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <div class="wizard-horizontal">
                <div class="row">
                      @if (empty( $cotizacion->documento_id ) ) 
                      <div class="col-12 col-sm-12">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Datos y recursos requeridos
                            </h4>
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                <div class=" mr-1">{{ $cotizacion->empresa()->razon_social }}</div>
                              </li>
                            </ul>
                          </div>
                          <form class="form" action="{{ route('expediente.inicio', ['cotizacion' => $cotizacion->id])}}" method="post">
                            @csrf
                          <div class="card-body px-0 py-1" style="display:flex;justify-content:center; ">
                            <ul class="widget-todo-list-wrapper" id="list-anexos">
                                <li  style="display:flex;" > 
                                  @if ( isset($validaciones['empresa_logos'])) 
                                    <i class="bx bx-check-circle font-medium-3 mr-50" style="color:green; font-size:15px; "></i>
                                  @else
                                    <i class="bx bxs-x-circle  font-medium-3 mr-50" style="color:red; font-size:15px; "></i>
                                  @endif  
                                  <p>Logos de empresa</p>
                                </li>
                                @if ( isset( $validaciones['sellos_firmas']))
                                <li style="display:flex;" > 
                                  <i class="bx bx-check-circle font-medium-3 mr-50" style="color:green; font-size:15px; "></i>
                                  @else
                                    <i class="bx bxs-x-circle  font-medium-3 mr-50" style="color:red; font-size:15px; "></i>
                                  @endif  
                                  <p>Sellos y firmas</p>
                                </li>

                                <li style="display:flex;" > 
                                @if ( isset( $validaciones['representante']))
                                  <i class="bx bx-check-circle font-medium-3 mr-50" style="color:green; font-size:15px; "></i>
                                @else 
                                  <i class="bx bxs-x-circle  font-medium-3 mr-50" style="color:red; font-size:15px; "></i>
                                @endif
                                  <p> Datos de representante</p>
                                  
                                </li>
                                <li style="display:flex;"> 
                                @if ( isset( $validaciones['montos']))
                                  <i class="bx bx-check-circle font-medium-3 mr-50" style="color:green; font-size:15px; "></i>
                                  @else
                                     <i class="bx bxs-x-circle  font-medium-3 mr-50" style="color:red; font-size:15px; "></i>
                                  @endif 
                                  <p>Costos y montos de cotizacion</p>
                                 
                                </li>

                             </ul>
                          </div>
                          <div style="display:flex;justify-content:center;" >
                            @if (sizeof($validaciones )>=4 )
                              <button class="btn btn-primary text-white" type="submit"  id="save">Crear expediente</button>
                            @endif
                          </div>
                          </form>
                        </div>
                      </div>
                      @endif
                      @if ( !empty ( $cotizacion->documento_id ))
                      <div class="col-12">
                        <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                        <iframe  class="doc" src='https://sig.creainter.com.pe/storage/{{ $cotizacion->documento()->archivo }}' width='1366px' height='823px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
                        </div>
                      </div>
                      @endif
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('page-scripts')
  @parent
<script>
function verify_check_widget() {
  if ($(this).is(':checked')) {
    $(this).closest('.widget-todo-item').find('.widget-more').stop().slideDown();
  } else {
    $(this).closest('.widget-todo-item').find('.widget-more').stop().slideUp();
  }
}
$(".checkbox__input").each(verify_check_widget);
$(".checkbox__input").on('click', verify_check_widget);
</script>
@endsection
