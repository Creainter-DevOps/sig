<?php

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
    $filename = md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
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
function gs_async($file, $folder = null, &$commands = null) {
  $path_basic    = config('constants.ruta_temporal');
  $path_temporal = $folder ?? config('constants.ruta_temporal');

  if(strpos($file, 'gs://') !== false) {
    $filename = md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
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

