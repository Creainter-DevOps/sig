@extends('layouts.pdf')
@section('content')
  <table class="w-100" style="position:relative;top:-10px;">
    <tr>
      <td>
        <div style="width:85%">
        <b>{{ $cotizacion->empresa()->razon_social }}</b><br/>
        <b>RUC: {{ $cotizacion->empresa()->ruc }}</b><br />
        {{ strtoupper($cotizacion->empresa()->direccion) }}<br />
        TELÉFONO: {{ $cotizacion->empresa()->telefono }}<br />
        </div><br/>
      </td>
      <td style="width:250px;vertical-align:top;" rowspan="2">
        <div style="text-align:center;font-size:18px;padding:5px;border:2px solid {{ $cotizacion->empresa()->color_primario }};margin-bottom:10px;">
          <h1 style="text-align:center;font-size:25px;margin-top:3px;margin-bottom:2px;">DETALLE DE PRECIOS</h1>
          <?= $cotizacion->nomenclatura() ?>
        </div>
        <table class="w-100">
          <tr>
            <th>FECHA</th>
            <td><?= Helper::fecha($cotizacion->fecha) ?></td>
          </tr>
          @if(!empty($cotizacion->validez))
          <tr>
            <th>VENCIMIENTO</th>
            <td><?= Helper::fecha($cotizacion->validez) ?></td>
          </tr>
          @endif
          <tr>
            <th>MONEDA</th>
            <td><?= $cotizacion->moneda_id == 1 ? 'SOLES' : 'DOLARES' ?></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <div style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;padding:2px;text-align:center;"><b>CLIENTE</b></div>
        <b>{{  $cotizacion->oportunidad()->empresa()->razon_social }}</b><br/>
        RUC: {{ $cotizacion->oportunidad()->empresa()->ruc }} <br />
        {{ $cotizacion->oportunidad()->empresa()->direccion }}.<br />
        <br/>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;padding:2px;text-align:center;"><b>PROYECTO / LICITACIÓN</b></div>
        <b>{{  strtoupper($cotizacion->oportunidad()->rotulo) }}</b><br/>
        @if(!empty($cotizacion->oportunidad()->licitacion_id))
        Nomenclatura: {{ $cotizacion->oportunidad()->licitacion()->nomenclatura }}<br/>
        @endif
        @if(!empty($cotizacion->oportunidad()->correo_id))
          Remitente: {{ $cotizacion->oportunidad()->correo()->correo_desde }}<br/>
        @endif
      </td>
    </tr>
  </table>
  <table class="w-100">
    <thead>
      <tr style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;">
        <th style="width:40px;">ORDEN</th>
        <th>DESCRIPCIÓN</th>
        <th style="width:50px;">UNID.</th>
        <th style="width:80px;">V.UNIT.</th>
        <th style="width:50px;">CANT.</th>
        <th style="width:80px;">SUB.</th>
      </tr>
    </thead>
    <tbody>
      @if(count($cotizacion->items()) == 0)
      <tr>
          <td class="texto-centrado">1</td>
          <td>
            @if(!empty($cotizacion->oportunidad()->licitacion_id))
              {{ strtoupper($cotizacion->oportunidad()->rotulo) }}<br />
            @endif
            @if(!empty($cotizacion->plazo_instalacion) || !empty($cotizacion->plazo_servicio) || !empty($cotizacion->plazo_garantia))
            @if(!empty($cotizacion->plazo_instalacion))
            <!-- INSTALACION -->
            <b>PLAZO DE ENTREGA:</b> {{ $cotizacion->plazo_instalacion }}<br />
            @endif
            @if(!empty($cotizacion->plazo_servicio))
            <!-- SERVICIO -->
            <!--<b>EJECUCIÓN:</b> {{ $cotizacion->plazo_servicio }}<br />-->
            <!--<b>DURACIÓN DE SERVICIO:</b> {{ $cotizacion->plazo_servicio }}<br />-->
            <b>PLAZO DE SERVICIO:</b> {{ $cotizacion->plazo_servicio }}<br/>
            @endif
            @if(!empty($cotizacion->plazo_garantia))
            <b>GARANTÍA:</b> {{ $cotizacion->plazo_garantia }}<br />
            @endif
            @if(!empty($cotizacion->observacion))
                <b>OBS.:</b>
                {!! nl2br($cotizacion->observacion) !!}<br />
            @endif
            @else
              <b>MONTO SUMA ALZADA</b>
            @endif
          </td>
          <td>UN</td>
          <td class="texto-centrado">{{ Helper::money($cotizacion->monto, $cotizacion->moneda_id) }}</td>
          <td class="texto-centrado">1</td>
          <td class="texto-centrado">{{ Helper::money($cotizacion->monto, $cotizacion->moneda_id) }}</td>
        </tr>
      @else
        @foreach($cotizacion->items() as $k => $p)
      <tr>
        <td class="texto-centrado">{{ $k + 1 }}</td>
        <td>
          <b>{{ $p->productor()->nombre }}:</b><br/> {!! nl2br($p->descripcion) !!}<br />
          @if(!empty($p->productor()->marca))
            <b>MARCA/FABRICANTE:</b> {{ $p->productor()->marca }}<br />
          @endif
          @if(!empty($p->productor()->modelo))
            <b>MODELO/SERIE:</b> {{ $p->productor()->modelo }}<br />
          @endif
        </td>
        <td clasS="texto-centrado">{{ $p->unidad ?? 'UN' }}</td>
        <td class="texto-centrado">{{  Helper::money($p->monto) }}</td>
        <td class="texto-centrado">{{  $p->cantidad }}</td>
        <td class="texto-centrado">{{ Helper::money( $p->monto * $p->cantidad) }}</td>
      </tr>
        @endforeach
        @endif
    </tbody>
  </table><br />
  <table>
    <tr>
      <td style="width:450px;">
            @if((!empty($cotizacion->plazo_instalacion) || !empty($cotizacion->plazo_servicio) || !empty($cotizacion->plazo_garantia)))
            @if(!empty($cotizacion->plazo_instalacion))
            <!-- INSTALACION -->
            <b>PLAZO DE ENTREGA:</b> {{ $cotizacion->plazo_instalacion }}<br />
            @endif
            @if(!empty($cotizacion->plazo_servicio))
            <!-- SERVICIO -->
            <b>EJECUCIÓN:</b> {{ $cotizacion->plazo_servicio }}<br />
            @endif
            @if(!empty($cotizacion->plazo_garantia))
            <b>GARANTÍA:</b> {{ $cotizacion->plazo_garantia }}<br />
            @endif
            @endif

      </td>
      <td>
        <table>
          <tr>
            <th style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;width:100px;">SUBTOTAL</th>
            <td style="width:100px;text-align:right;"><?= Helper::money($cotizacion->subtotal, $cotizacion->moneda_id) ?></td>
          </tr>
          <tr>
            <th style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;">I.G.V.</th>
            <td style="width:100px;text-align:right;"><?= Helper::money($cotizacion->igv, $cotizacion->moneda_id) ?></td>
          </tr>
          <tr>
            <th style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;">TOTAL</th>
            <td style="width:100px;text-align:right;"><?= Helper::money($cotizacion->monto, $cotizacion->moneda_id) ?></td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
  <br />
  <table class="w-100">
    <tr>
      <th style="background:{{ $cotizacion->empresa()->color_primario }};color:#ffffff;">TÉRMINOS Y CONDICIONES</th>
    </tr>
    <tr>
      <td>
        @if(!empty($cotizacion->terminos))
          {!! nl2br($cotizacion->terminos) !!}
        @else
          El precio de la oferta en SOLES incluye todos los tributos, seguros, transporte, inspecciones, pruebas y, de ser el caso, los costos laborales conforme a la legislación vigente, así como cualquier otro concepto que pueda tener incidencia sobre el costo del servicio a contratar.
        @endif
      </td>
    </tr>
  </table>
@endsection
