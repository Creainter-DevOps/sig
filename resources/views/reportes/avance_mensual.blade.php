<html lang="es-PE">
<head>
<style>
table {
  font-size: 12px;  
}
th, td {
  border: 1px solid #b3b3b3;
  text-align:center;

}
h1 {
  padding: 10px;
  font-size: 17px;
}
.tr_par {
}
.tr_impar {
}
header {
                position: fixed;
                top: -20px;
                left: 0px;
                right: 0px;
                height: 100px;
                text-align: right;
            }

.logo {
  height: 40px;
}
</style>
</head>
<body>
<header>
<img src="/var/www/html/adjudica.com.pe/public/images/logo-web.png" class="logo" />
</header>
<main>
<h1>Adjudica: Metricas Mensuales</h1>
<table>
  <thead>
    <tr>
      <th style="width:100px;">Fecha</th>
      <th style="width:80px;">Usuario</th>
      <th style="width:100px;">Oportunidades</th>
      <th style="width:100px;">Cotizaciones</th>
      <th style="width:100px;">Proceso</th>
      <th style="width:100px;">Revisado</th>
      <th style="width:100px;">Terminado</th>
      <th style="width:100px;">Adelanto</th>
      <th style="width:100px;">Enviado</th>
      <th style="width:100px;">Enviado Fuera</th>
    </tr>
  </thead>
  @php
    $i = 0;
  @endphp
  @foreach($listado as $o)
    @php
      $i++;
    @endphp
    <tbody>
    @if($i % 2 === 0)
    <tr class="tr_par">
    @else
    <tr class="tr_impar">
    @endif
      <td>{{ $o->dia }}</td>
      <td>{{ $o->usuario }}</td>
      <td>{{ $o->oportunidades }}</td>
      <td>{{ $o->cotizaciones }}</td>
      <td>{{ !empty($o->proceso) ? $o->proceso : '' }}</td>
      <td>{{ !empty($o->revisado) ? $o->revisado : '' }}</td>
      <td>{{ !empty($o->terminado) ? $o->terminado : '' }}</td>
      <td>{{ !empty($o->adelanto) ? $o->adelanto : '' }}</td>
      <td>{{ !empty($o->enviado) ? $o->enviado : '' }}</td>
      <td>{{ !empty($o->enviado_fuera) ? $o->enviado_fuera : '' }}</td>
    </tr>
  @endforeach
</table>
</main>
</body>
</html>
