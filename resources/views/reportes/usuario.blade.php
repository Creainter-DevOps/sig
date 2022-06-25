@extends('layouts.reporte')
@section('content')
  <?php foreach ( $actividades as $usuario => $actividad ) : ?> 
  <table class="tabla w-100" border="1" style="position:stiky"  >
    <tr>
      <td colspan="3" class="texto-centrado"  >Usuario: <?= $usuario  ?> </td>
    </tr>
        <tr>  
          <td> Fecha </td>
          <td> Actividad</td>
          <td> N° Acciones </td>
        </tr>
        <?php  foreach ( $actividad as $ac ) : ?>   
        <tr>
          <td> <?= $ac['created_on'] ?></td>
          <td> <?= $ac['tipo'] ?></td>
          <td> <?= $ac['acciones'] ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  <p></p>
  <?php endforeach  ?>   
@endsection
