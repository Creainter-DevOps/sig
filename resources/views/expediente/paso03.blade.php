@extends('expediente.theme')
@section('contenedor')
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        @php
        $space = App\User::space();
        @endphp
        @if($space > 93)
        <div style="color: #ffffff;background: #f97b7b;font-size: 25px;text-align: center;padding: 15px;">{{ $space }}% del disco usado, avisar a José!</div>
        @else
        <div style="position: absolute;top: 5px;left: 6px;font-size: 12px;color: #000000;background: #87ff85;padding: 5px 10px;border-radius: 5px;">{{ $space }}% del disco usado</div>
        @endif
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
            <div style="position: fixed;bottom: 140px;right: 393px;z-index: 99999;background: rgb(0 0 0 / 20%);padding: 10px;border-radius: 5px;">
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
