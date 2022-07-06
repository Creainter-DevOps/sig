<?php

function gs_file($extension = 'pdf') {
  return uniqid() . '.' . $extension;
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
function gs($file) {
  if(strpos($file, 'gs://') !== false) {
    $temporal = '/tmp/' . md5($file) . '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if(file_exists($temporal)) {
      return $temporal;
    }
    Helper::gsutil_cp($file, $temporal);
    return $temporal;
  } else if(file_exists($file)) {
    return $file;
  }
}

