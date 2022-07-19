@extends('expediente.theme')
@section('contenedor')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="/expediente/{{ $cotizacion->id }}/paso01">
                  Anexos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso02">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso03">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso04">
                  Magia
                </a>
              </li>
            </ul>
            <div class="wizard-horizontal">
                <div class="row">
                      <div class="col-6">
                        <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                          @if(!empty($cotizacion->oportunidad()->licitacion_id))
                          <iframe class="doc" src="https://docs.google.com/gview?embedded=true&url={{ ('https://sig.creainter.com.pe/static/seace/' . $licitacion->bases_integradas) }}" frameborder='0' style="height:600px"></iframe>
                          @else
                          Solo Oportunidad
                          @endif
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Plantillas
                            </h4>
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                <div class=" mr-1">{{ $cotizacion->empresa()->razon_social }}</div>
                              </li>
                            </ul>
                          </div>
                          <form class="form" action="{{ route('expediente.paso01', ['cotizacion' => $cotizacion->id])}}" method="post">
                            @csrf
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="list-anexos">
                              @foreach($plantillas as $p) 
                              <li class="widget-todo-item" data-id="{{$p->id }}" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <div class="checkbox checkbox-shadow">
                                      @if (isset($workspace['paso01'][$p->id]))
                                        <input type="checkbox" class="checkbox__input" id="check_anexo{{$p->id}}" name="anexos[{{$p->id}}]" checked>
                                      @else     
                                        <input type="checkbox" class="checkbox__input" id="check_anexo{{$p->id}}" name="anexos[{{$p->id}}]">
                                      @endif
                                      <label for="check_anexo{{$p->id}}">{{ $p->tipo }}</label>
                                    </div>
                                    <span class="widget-todo-title ml-50">{{ $p->rotulo }}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1">{{ $p->usuario }}</div>
                                  </div>
                                </div>
                              </li>
                              @endforeach
                            </ul>
                          </div>
                          <button class="btn btn-primary text-white" type="submit"  id="save">Generar</button>
                          </form>
                        </div>
                      </div>
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
