<!DOCTYPE html>
<html>
<head>
<title><?= $cotizacion->nomenclatura() ?></title>
<style>
body {  font-family: Helvetica, sans-serif; font-size: 12px; }
h1 { font-size: 16px; }
h2 { font-size: 14px; }
h3 { font-size: 12px; }
h4 { font-size: 10px; }
.mayuscula { text-transform: uppercase; }
.texto-izquierda { text-align: left; }
.texto-centrado { text-align: center; }
.texto-derecha { text-align: right; }
.negrita { font-weight: bold; }
.borde { border: solid 1px #333; }
table.tabla { border-collapse: collapse; }
table.tabla thead { border-top: solid 1px #333; border-bottom: solid 1px #333; }
table.tabla td, table.tabla th { padding: 5px 3px; }
.w-100 { width: 100%; }
.w-50 { width: 50%; }
.w-25 { width: 25%; }
@page { margin: 100px 50px 70px 50px; }
#header { position: fixed; left: 10px; top: -70px; height: 50px; }
.badge {
  font-size: 10px;
  font-weight: bold;
}
.badge-light-success {
  color: #23bd70;
}
.badge-light-danger {
  color: #ff3536;
}
.badge-light-warning {
  color: #ffe426;
}
</style>
</head>
<body>
<div id="header">
    <img src="https://www.creainter.com.pe/assets/images/logo/logo-dark.png" style="width:150px;" />
</div>
@yield('content')
<script type="text/php">
    if (isset($pdf)) {
        $text = "Página {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Helvetica");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2 + 15;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
        $pdf->page_text($pdf->get_width() - 160, 30, 'Generado el ' . date('d/m/Y H:i:s'), null, 8);
    }
</script>
</body>
</html>
