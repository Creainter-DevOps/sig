@extends('expediente.theme')
@section('contenedor')
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item">
                <a class="nav-link" href="/expediente/{{ $cotizacion->id }}/paso01">
                  Anexos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/expediente/{{ $cotizacion->id }}/paso02">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/expediente/{{ $cotizacion->id }}/paso03">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso04">
                  Magia
                </a>
              </li>
            </ul>
            @include('documento.mesa', compact('documento','workspace'))
            <div style="position: absolute;bottom: 15px;right: 20px;">
              <form method="post" action="{{ route('expediente.paso03',['cotizacion' => $cotizacion->id ]) }}"  >
               @csrf
               <button class="btn btn-primary" type="submit">Procesar</a>
               </form>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection
