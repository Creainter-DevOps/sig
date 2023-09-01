<?php
function tiempo_transcurrido($fecha) {
    // Convertir la fecha proporcionada a un objeto de fecha y hora
    $fecha_actual = new DateTime();
    $fecha_dada = new DateTime($fecha);

    // Calcular la diferencia entre la fecha proporcionada y la fecha actual
    $intervalo = $fecha_dada->diff($fecha_actual);

    // Obtener los componentes del intervalo
    $anios = $intervalo->y;
    $meses = $intervalo->m;
    $dias = $intervalo->d;
    $horas = $intervalo->h;
    $minutos = $intervalo->i;

    // Construir el texto corto basado en el tiempo transcurrido
    if ($dias >= 2) {
        return $fecha_dada->format('d/m/Y');
    } elseif ($dias == 1) {
        return 'Ayer, ' . $fecha_dada->format('h:i A');
    } elseif ($horas > 0) {
        return $fecha_dada->format('h:i A');
    } elseif ($minutos > 0) {
        return 'hace ' . $minutos . ' minuto' . (($minutos > 1) ? 's' : '');
    } else {
        // Si es el mismo día, mostrar la hora en formato "H:i"
        return ($fecha_dada->format('Y-m-d') === $fecha_actual->format('Y-m-d')) ? $fecha_dada->format('H:i') : $fecha_dada->format('d/m/Y, H:i');
    }
}
if(!function_exists('fecha')) {
function fecha($x) {
  $x = strtotime($x);
  if(empty($x)) {
    return null;
  }
  return date('d/m/Y', $x);
}
}
if(!function_exists('byteConvert')) {
function byteConvert($bytes){
  if ($bytes == 0) {
    return "0.00 B";
  }
  $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
  $e = floor(log($bytes, 1024));
  return round($bytes/pow(1024, $e), 2).$s[$e];
}
}
if(!function_exists('hora')) {
function hora($x) {
  $x = strtotime($x);
  if(empty($x)) {
    return null;
  }
  return date('h:i A', $x);
}
}
function SendMail($perfil, $data) {
  require_once(config('constants.internal') . 'conf.php');

  require_once(ABS_LIBRERIAS . 'xmail.php');

  $credenciales = [
    'servidor_smtp' => $perfil->servidor_smtp,
    'puerto_smtp'   => $perfil->puerto_smtp,
    'usuario'       => $perfil->usuario,
    'clave'         => $perfil->clave,
    'correo'        => $perfil->correo,
    'nombre'        => $perfil->nombre,
  ];
  if(!empty($perfil->cargo)) {
    $data['body'] .= '<br>';
    $data['body'] .= '<p style="color:' . $perfil->color_primario . ';margin-bottom:0;">' . $perfil->nombre . '</p>';
    $data['body'] .= '<p style="margin-top:0;">' . $perfil->cargo . '</p>';
    $data['body'] .= '<p style="color:' . $perfil->color_primario . ';font-size:11px;">www.creainter.com.pe | ' . $perfil->correo . ' | Celular: ' . $perfil->celular . ' | Fijo: ' . $perfil->linea . ' Anexo ' . $perfil->anexo . '</p>';
    $data['body'] .= '<img src="' . config('constants.app_url') . '/static/cloud/' . $perfil->logo . '" style="height: 45px;">';
  }
  return xMailSend(XMAIL_SEND_NOW, $credenciales, $data);
}
function contextInternal() {
  require_once(config('constants.internal') . 'conf.php');
}
function file_ext($file) {
  return strtolower(pathinfo($file, PATHINFO_EXTENSION));
}
function gs_file($extension = 'pdf') {
  return date('Y_m_d') . '-' . uniqid() . '.' . $extension;
}
function gs_exists($file) {
  if(strpos($file, 'gs://') !== false) {
    $temporal = '/tmp/' . md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if(file_exists($temporal)) {
      return true;
    }
    return Helper::gsutil_exists($file);
  } else if(file_exists($file)) {
    return true;
  }
  return false;
}

function gs($file, $folder = null) {

  $path_basic    = config('constants.ruta_temporal');
  $path_temporal = $folder ?? config('constants.ruta_temporal');

  if(strpos($file, 'gs://') !== false) {
    $filename = 'gs_' . md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $temporal = $path_temporal . $filename;
    if(file_exists($temporal)) {
      return $temporal;
    }
    Helper::gsutil_cp($file, $temporal);
    if($path_basic != $path_temporal) {
      #symlink($temporal, $path_basic . $filename);
    }
    return $temporal;

  } else if(file_exists($file)) {
    return $file;
  }
}


function quitar_tildes($str){
  return strtolower(str_replace(
    array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ','Ò'),
    array('a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n','o'),
    trim($str)
  ));
}

function gs_async($file, $folder = null, &$commands = null) {
  $path_basic    = config('constants.ruta_temporal');
  $path_temporal = $folder ?? config('constants.ruta_temporal');

  if(strpos($file, 'gs://') !== false) {
    $filename = 'gs_' . md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $temporal = $path_temporal . $filename;
    if(file_exists($temporal)) {
      return $temporal;
    }
    $commands[] = "/snap/bin/gsutil cp '" . $file . "' '" . $temporal . "'";
    if($path_basic != $path_temporal && false) {
      #symlink($temporal, $path_basic . $filename);
    }
    return $temporal;

  } else if(file_exists($file)) {
    return $file;
  }
}

