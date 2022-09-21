@extends('layouts.pdf')
@section('content')
  <h1 class="mayuscula texto-centrado">RELACIÓN DE ACTIVIDADES</h1>
  <div>
    Cuenta: <b>{{ '@' . $usuario->usuario}}</b><br/>
    Fecha:  {{ Helper::fecha($fecha_desde) }} - {{ Helper::fecha($fecha_hasta) }}<br />
  </div><br />
  <table class="tabla w-100">
    <thead>
      <tr class="texto-centrado">
        <th style="width:20px">#</th>
        <th style="width:120px;">Fecha</th>
        <th style="width:80px;">Estado</th>
        <th>Actividad</th>
      </tr>
    </thead>
    <tbody>
    @foreach($pendientes as $k => $r)
      <tr>
        <th>{{ $k + 1 }}</td>
        <td>{{ Helper::fecha($r->fecha . ' ' . $r->hora, true) }}</td>
        @if($r->estado == 1)
        <td><span style="color:#565656;">{{ $r->renderEstado() }}</span></td>
        @elseif($r->estado == 2)
        <td><span style="color:#e79046;">{{ $r->renderEstado() }}</span></td>
        @elseif($r->estado == 3)
        <td><span style="color:#269900;">{{ $r->renderEstado() }}</span></td>
        @elseif($r->estado == 4)
        <td><span style="color:#6ba6ff;">{{ $r->renderEstado() }}</span></td>
        @else
        <td>{{ $r->renderEstado() }}</td>
        @endif
        @if(!empty($r->importancia))
        <td><i style="color:#ffbb22;">Importante</i> {{ $r->texto }}</td>
        @else
        <td>{{ $r->texto }}</td>
        @endif
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection
