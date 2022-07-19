<?php 
namespace App\Helpers;

use Config;
use Illuminate\Support\Str;
use PhpOffice\PhpWord; 
use App\Helpers\NumeroALetras;

class Helper
{
  public static function gsutil_exists($file) {
    $cmd = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
    $cmd .= ";/snap/bin/gsutil -q stat '$file'; echo $?";
    $out = shell_exec($cmd);
    $out = trim($out);
    return $out === '0';
  }
  public static function gsutil_cp($from, $to) {
    $cmd = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
    $cmd .= ";/snap/bin/gsutil cp '" . $from . "' '" . $to . "'";
    exec($cmd);
    return true;
  }
  public static function gsutil_mv($from, $to) {
    $cmd = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
    $cmd .= ";/snap/bin/gsutil mv '" . $from . "' '" . $to . "'";
    exec($cmd);
    return true;
  }
  public static function parallel_command($cmd, $data = null) {
    $stdout = static::json_path('pid_' . uniqid() . '.log');
    if(is_array($cmd)) {
      $cmd = '(' . implode('; ', $cmd) . ')';
    }
    $command =  $cmd . ' >> ' . $stdout . ' 2>&1 & echo $!; ';
    $pid = exec($command, $output);

    static::json_save('process_' . $pid, [
      'pid'          => $pid,
      'finished'     => false,
      'percent'      => 0,
      'start_time'   => time(),
      'command'      => $cmd,
      'data'         => $data,
      'last_query'   => null,
      'count_query'  => 0,
      'stdout'       => $stdout,
    ]);
    return $pid;
  }

  public static function parallel_terminate($pid) {
    $work = static::json_load('process_' . $pid);
    exec('kill -9 ' . $pid);
    $work['killed'] = time();
    static::json_save('process_' . $pid, $work);
    static::json_delete('process_' . $pid);
    return true;
  }

  public static function parallel_terminate_pool($pid_pool) {
    foreach($pid_pool as $p) {
      static::parallel_terminate($p);
    }
    return true;
  }
  public static function parallel_finished($pid) {
    $s = static::parallel_status($pid);
    return !empty($s) ? $s['finished'] : true;
  }
  public static function parallel_finished_pool($pid_pool) {
    if(!is_array($pid_pool)) {
      return static::parallel_finished($pid_pool);
    }
    foreach($pid_pool as $p) {
      $s = static::parallel_status($p);
      if($s === false) {
        continue;
      }
      if(!$s['finished']) {
        return false;
      }
    }
    return true;
  }
  public static function parallel_status($pid, $internal = false) {
    if(!is_numeric($pid))
      return false;
    if(!static::json_has('process_' . $pid)) {
      /* En caso se solicite un pid no reconocido */
      return false;
    }
    $work = static::json_load('process_' . $pid);
    if(file_exists('/proc/' . $pid)) {
      if($internal) {
        $work['last_query'] = time();
        $work['count_query']++;
      }
      $work['percent'] = 10 * (time() - $work['start_time']);
    } else {
      $work['percent']  = 100;
      $work['end_time'] = time();
      $work['finished'] = true;
      static::json_delete('process_' . $pid);
    }
    static::json_save('process_' . $pid, $work);
    return $work;
  }
  
  public static function parallel_status_pool($pid_pool) {
    if(!is_array($pid_pool)) {
      return static::parallel_status($pid_pool);
    }
    foreach($pid_pool as $p) {
      $status = static::parallel_status($p);
      if($status === false) {
        continue;
      }
      if(!$status['finished']) {
        return $status;
      }
    }
    return true;
  }
  public static function parallel_log($pid) {
    $proc = static::parallel_status($pid, true);
    if(!$proc) {
      return false;
    }
    if($proc['finished']) {
      return false;
    }
    $cmd = '/usr/bin/tail -n10 ' . $proc['stdout'];
    return shell_exec($cmd);
  }
  public static function parallel_log_pool($pid_pool) {
    if(!is_array($pid_pool)) {
      return static::parallel_log($pid_pool);
    }
    foreach($pid_pool as $p) {
      if(($d = static::parallel_log($p['pid'])) === false) {
        continue;
      }
      return $d;
    }
    return null;
  }

  public static function json_path($x, $path = null) {
    return ($path ?? '/tmp/') . $x;
  }

  public static function json_has($x, $path = null) {
    return file_exists(static::json_path($x, $path));
  }

  public static function json_timeout($x, $time, $path = null) {
    return filemtime(static::json_path($x, $path)) <= (time() - ($time * 1));
  }
  
  public static function json_load($x, $path = null) {
    if(!static::json_has($x, $path)) {
      return [];
    }
    return json_decode(file_get_contents(static::json_path($x, $path)), true);
  }

  public static function json_save($x, $data, $path = null) {
    return file_put_contents(static::json_path($x, $path), json_encode($data));
  }

  public static function json_delete($x, $path = null) {
    @unlink(static::json_path($x, $path));
    return true;
  }
public static function array_delete_keys($n, $m) {
  foreach($m as $k) {
    unset($n[$k]);
  }
  return $n;
}
public static function array_only_keys($n, $m) {
  $rp = array();
  foreach($m as $k) {
    $rp[$k] = isset($n[$k]) ? $n[$k] : null;
  }
  unset($n);
  return $rp;
}
  public static function array_group_by($a, $b){
    $_temp = array();
    $f = array_shift($b);
    $indice = is_array($f) ? $f['key'] : $f;
    foreach($a as $n) {
      if(!is_array($f)) {
        $_temp[$n[$indice]][] = $n;
      } else {
        if(!isset($_temp[$n[$indice]])) {
          $_temp[$n[$indice]] = !empty($f['only']) ? static::array_only_keys($n, $f['only']) : array();
          $_temp[$n[$indice]]['children'] = array();
        }
        $_temp[$n[$indice]]['children'][] = static::array_delete_keys($n, $f['only']);
      }
    }
    if(!empty($b)) {
      foreach($_temp as $n) {
        if(!is_array($f)) {
          $_temp[$n[$indice]] = static::array_group_by($_temp[$n[$indice]], $b);
        } else {
          $_temp[$n[$indice]]['children'] = static::array_group_by($_temp[$n[$indice]]['children'], $b);
        }
      }
    }
    return $_temp;  
  }

  public static function metadata($file, $cmd = '/usr/bin/exiftool', $antirec = 0) {

    $out = shell_exec($cmd . ' ' . $file);
    $out = explode("\n", $out);
    $out = array_filter($out, function($n) {
      return !empty($n);
    });

    $out = array_map(function($n) {
      $l = explode(':', $n, 2);
      $l = array_map('trim', $l);
      return $l;
    }, $out);
    $_out = [];
    foreach($out as $v) {
      if(isset($v[1])) {
        $_out[$v[0]] = $v[1];
      }
    }
    if(empty($_out['Pages']) && empty($_out['Page Count'])) {
      if($antirec == 0) {
        $_out = static::metadata($file, '/usr/bin/pdfinfo', 1);
      }
    }
    if(empty($_out['Pages'])) {
      if(!empty($_out['Page Count'])) {
        $_out['Pages'] = $_out['Page Count'];
      }
    }
    return $_out;
  }
  public static function pdf($theme, $input, $type = 'landscape')
  {
    if($type == 'L') {
      $type = 'landscape';
    } elseif($type == 'P') {
      $type = 'portrait';
    }
    $pdf = \PDF::loadView($theme, $input);
    $pdf->setPaper('A4', $type);
    $pdf->getDomPDF()->set_option("enable_php", true);
    return $pdf;
  }
  public static function dinero_a_texto($n, $moneda_id) {
    $n = number_format($n, 2, '.', '');
    return NumeroALetras::convertir($n, static::moneda($moneda_id), 'centimos', true);
  }
  public static function money($data, $moneda_id = 1) {
    $dd = number_format($data, 2, ".", " ");
    $dd = str_replace('.00','', $dd);
    if($moneda_id == 1) {
      return 'S/. ' . $dd;
    }
    return $dd . ' USD';
  }

  public static function moneda($moneda_id = null ) {

    $monedas= [
      1 => 'SOLES',
      2 => 'DOLARES'
    ];

    if( $moneda_id != null ){
      return $monedas[$moneda_id];  
    } else{
      return $monedas;
    } 
  }  

  public static function docx_fill_template($input, $data, $output) {
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($input);
    if(!empty($data['EMPRESA.IMAGEN_HEADER'])) {
      $templateProcessor->setImageValue('EMPRESA.IMAGEN_HEADER',
        [
          'path' => gs(config('constants.ruta_storage') .  $data['EMPRESA.IMAGEN_HEADER']),
          'height' => 50
        ]
      );
    }
    if(!empty($data['EMPRESA.IMAGEN_CENTRAL'])) {
      $templateProcessor->setImageValue('EMPRESA.IMAGEN_CENTRAL', gs(config('constants.ruta_storage') . $data['EMPRESA.IMAGEN_CENTRAL']));
    }
    $templateProcessor->setValues($data);
    return $templateProcessor->saveAs($output);
  }
  public static function file_name($filename) {
    $info = pathinfo($filename);
    return $info['basename'];
  }
  public static function replace_extension($filename, $new_extension, $append = '') {
    $info = pathinfo($filename);
    if($info['dirname'] == '.') {
      return $info['filename'] . $append . '.' . $new_extension;
    }
    return $info['dirname'] . '/' . $info['filename'] . $append . '.' . $new_extension;
  }
  public static function mkdir_p($path) {
    if(file_exists($path)) {
      return $path;
    }
    $path = static::normalizePath($path);
    if(substr($path, -1) != '/') {
      $path = dirname($path) . '/';
    }
    mkdir($path, 0755, true);
    return $path;
  }
  public static function normalizePath($path) {
    $parts = array();// Array to build a new path from the good parts
    $path = str_replace('\\', '/', $path);// Replace backslashes with forwardslashes
    $path = preg_replace('/\/+/', '/', $path);// Combine multiple slashes into a single slash
    $segments = explode('/', $path);// Collect path segments
    $test = '';// Initialize testing variable
    foreach($segments as $segment)
    {
        if($segment != '.')
        {
            $test = array_pop($parts);
            if(is_null($test))
                $parts[] = $segment;
            else if($segment == '..')
            {
                if($test == '..')
                    $parts[] = $test;

                if($test == '..' || $test == '')
                    $parts[] = $segment;
            }
            else
            {
                $parts[] = $test;
                $parts[] = $segment;
            }
        }
    }
    return implode('/', $parts);
}

public static function es_pasado($date, &$class = '')
{
  @list($day, $month, $year) = explode('/', $date);
  $unix = strtotime(implode('-', [$year, $month, $day]));
  $rp = $unix < strtotime(date('Y-m-d'));
  $class = '';
  if ($rp) {
  } else {
    if ($unix < time() + 60 * 60 * 24) {
      $class = 'color: red';
    } elseif ($unix < time() + 60 * 60 * 24 * 3) {
      $class = 'color: #e27301';
    } else {
      $class = 'color: blue';
    }
  }
  return $rp;
}
public static function fecha($x = null, $h = null) {
    $formato = 'd/m/Y';
    return !empty($x) ? date($formato, strtotime($x)) . (is_null($h) ? '' : ' ' . static::hora($x, $h)) : 'SIN FECHA';
 }
public static function fecha_letras($unix = null) {
  $unix = empty($unix) ? time() : (is_numeric($unix) ? $unix : strtotime($unix));
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  return date("d", $unix) . ' de ' . $meses[ date("n", $unix) - 1 ] . ' del ' . date("Y", $unix);
}
public static function subir_documento( $archivo, $name ){
  return  move_uploaded_file($archivo["tmp_name"], $name); 
}
 public static function tiempo_transcurrido($fecha = 'now') {
  global $DIAS, $MESES;
  if(empty($fecha)) {
    return '';
  }
  $fecha = !empty($fecha) ? (is_numeric($fecha) ? $fecha : strtotime($fecha)) : time();
  $ahora = time();
  if(empty($fecha)) {
      return NULl;
  }
  $MINUTO = 60;
  $HORA   = $MINUTO * 60;
  $DIA    = $HORA * 24;
  $MES    = $DIA * 30;
  $ANHO   = $MES * 12;

  $diferencia = $fecha - $ahora == 0 ? 1 : $fecha - $ahora;
  $signo      = $diferencia > 0;
  $prefijo    = $signo ? 'En ' : 'Hace ';
  $sufijo     = '';
  $diferencia = $signo ? $diferencia : $diferencia * -1;

  if($diferencia <= $MINUTO * 1) {
    $txt = 'instantes';
 // } elseif($diferencia <= $MINUTO * 9) {
//    $txt = 'breve momentos';
  } elseif($diferencia <= $HORA - 5 * $MINUTO) {
    $txt = round($diferencia/$MINUTO) . ' minutos';
  } elseif($diferencia <= $HORA + 5 * $MINUTO) {
    $txt = 'una hora';
  } elseif($diferencia <= $HORA * 4) {
    $txt = round($diferencia/$HORA) . ' horas';
  } elseif($diferencia <= $HORA * 12) {
    $prefijo = '';
    $txt     = 'Hoy, ' . date('h:i a', $fecha);
  } elseif($diferencia <= $DIA + 6 * $HORA) {
    $prefijo = '';
    $sufijo  = ', ' . date('h:i a', $fecha);
    $txt     = $signo ? 'Mañana' : 'Ayer';
  } elseif($diferencia <= $DIA * 4) {
    $txt     = round($diferencia/$DIA) . ' días';
  } elseif($diferencia <= $DIA * 6) {
    $prefijo = $signo ? '' : '';
#    $sufijo  = $signo ? ''      : ' pasado';
#    $txt     = $DIAS[date('w', $fecha)];
    $txt     = date('d/m/Y');
  } elseif($diferencia <= $DIA * 8) {
    $txt     = 'una semana';
  } elseif($diferencia <= $MES - 5 * $DIA) {
    $prefijo = $signo ? 'El próximo ' : 'El pasado ';
    $sufijo  = '';
    $txt     = $DIAS[date('w', $fecha)] . ' ' . date('d', $fecha);
  } elseif($diferencia <= $MES + 5 * $DIA) {
    $txt = 'un mes';
  } elseif($diferencia <= $ANHO - 2 * $MES) {
    $txt = round($diferencia/$MES) . ' meses';
  } elseif($diferencia <= $ANHO + 2 * $MES) {
    $txt = 'un año';
  } else {
    $prefijo = '';
    $sufijo  = '';
    $txt     = ucfirst($DIAS[date('w', $fecha)]) . ' ' . date('d', $fecha) . ' de ' . $MESES[date('n', $fecha)-1] . ' del ' . date('Y', $fecha);
  }
  return $prefijo . $txt . $sufijo;
}

  public static function hora($x = null, $formato = 'h:i A') {
    if($formato === true) {
      $formato = 'h:i A';
    }
    return !empty($x) ? date($formato, strtotime($x)) : 'SIN FECHA';
  }
    public static function applClasses()
    {
        // default data value
        $dataDefault = [
          'mainLayoutType' => 'vertical-menu',
          'theme' => 'light',
          'isContentSidebar'=> false,
          'pageHeader' => false,
          'bodyCustomClass' => '',
          'navbarBgColor' => 'bg-white',
          'navbarType' => 'fixed',          
          'isMenuCollapsed' => false,
          'footerType' => 'static',
          'templateTitle' => '',
          'isCustomizer' => true,
          'isCardShadow' => true,
          'isScrollTop' => true,
          'defaultLanguage' => 'en',
          'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];
        
        //if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($dataDefault, config('custom.custom'));

        // $fullURL = request()->fullurl();
        // $data = [];
        // if (App()->environment() === "production") {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, "demo-" . $i);
        //         if ($contains === true) {
        //             $data = config("demo-".$i.".custom");
        //         }
        //     }
        // }
        // $data = array_merge($dataDefault, $data);
        
        // all available option of materialize template
        $allOptions = [
          'mainLayoutType' => array('vertical-menu','horizontal-menu','vertical-menu-boxicons'),
          'theme' => array('light'=>'light','dark'=>'dark','semi-dark'=>'semi-dark'),
          'isContentSidebar'=> array(false,true),
          'pageHeader' => array(false,true),
          'bodyCustomClass' => '',
          'navbarBgColor' => array('bg-white','bg-primary', 'bg-success','bg-danger','bg-info','bg-warning','bg-dark'),
          'navbarType' => array('fixed'=>'fixed','static'=>'static','hidden'=>'hidden'),          
          'isMenuCollapsed' => array(false,true),
          'footerType' => array('fixed'=>'fixed','static'=>'static','hidden'=>'hidden'),
          'templateTitle' => '',
          'isCustomizer' => array(true,false),
          'isCardShadow' => array(true,false),
          'isScrollTop' => array(true,false),
          'defaultLanguage'=>array('en' => 'en','pt' => 'pt','fr' => 'fr','de' => 'de'),
          'direction' => array('ltr' => 'ltr','rtl' => 'rtl'),
        ];
        // navbar body class array
        $navbarBodyClass = [
          'fixed'=>'navbar-sticky',
          'static'=>'navbar-static',
          'hidden'=>'navbar-hidden',
        ];
        $navbarClass  = [
          'fixed'=>'fixed-top',
          'static'=>'navbar-static-top',
          'hidden'=>'d-none',
        ];
        // footer class
        $footerBodyClass = [
          'fixed'=>'fixed-footer',
          'static'=>'footer-static',
          'hidden'=>'footer-hidden',
        ];
        $footerClass = [
          'fixed'=>'footer-sticky',
          'static'=>'footer-static',
          'hidden'=>'d-none',
        ];

        //if any options value empty or wrong in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
          if (gettype($data[$key]) === gettype($dataDefault[$key])) {
            if (is_string($data[$key])) {
              if(is_array($value)){
                
                $result = array_search($data[$key], $value);
                if (empty($result)) {
                  $data[$key] = $dataDefault[$key];
                }
              }
            }
          } else {
            if (is_string($dataDefault[$key])) {
              $data[$key] = $dataDefault[$key];
            } elseif (is_bool($dataDefault[$key])) {
              $data[$key] = $dataDefault[$key];
            } elseif (is_null($dataDefault[$key])) {
              is_string($data[$key]) ? $data[$key] = $dataDefault[$key] : '';
            }
          }
        }

        //  above arrary override through dynamic data
        $layoutClasses = [
          'mainLayoutType' => $data['mainLayoutType'],
          'theme' => $data['theme'],
          'isContentSidebar'=> $data['isContentSidebar'],
          'pageHeader' => $data['pageHeader'],
          'bodyCustomClass' => $data['bodyCustomClass'],
          'navbarBgColor' => $data['navbarBgColor'],
          'navbarType' => $navbarBodyClass[$data['navbarType']],
          'navbarClass' => $navbarClass[$data['navbarType']],          
          'isMenuCollapsed' => $data['isMenuCollapsed'],
          'footerType' => $footerBodyClass[$data['footerType']],
          'footerClass' => $footerClass[$data['footerType']],
          'templateTitle' => $data['templateTitle'],
          'isCustomizer' => $data['isCustomizer'],
          'isCardShadow' => $data['isCardShadow'],
          'isScrollTop' => $data['isScrollTop'],
          'defaultLanguage' => $data['defaultLanguage'],
          'direction' => $data['direction'],
        ];

         // set default language if session hasn't locale value the set default language
         if(!session()->has('locale')){
            app()->setLocale($layoutClasses['defaultLanguage']);
          }

        return $layoutClasses;
    }
    // updatesPageConfig function override all configuration of custom.php file as page requirements.
    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';
        // $fullURL = request()->fullurl();
        // if(App()->environment() === 'production'){
        //     for ($i=1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-'.$i);
        //         if($contains === true){
        //             $demo = 'demo-'.$i;
        //         }
        //     }
        // }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set($demo . '.' . $custom . '.' . $config, $val);
                }
            }
        }
    }
    public static function fileTemp($extencion = 'pdf'){
       return config('constants.ruta_temporal') . uniqid() . "." . $extencion;   
    }


    /* Workspace */
    public static function workspace_get_id($id, $page) {
      return $id . '/' . $page;
    }

    public static function workspace_get_card( $matrix, $cid ) {
      return $matrix[$cid];
    }
    public static function workspace_space($matrix, $orden, $space) {
      $cids = static::workspace_get_range($matrix, $orden, null);
      foreach($cids as $cid) {
        $c = static::workspace_get_card($matrix, $cid);
        $c['orden'] += $space;
        $matrix[$cid] = $c;
      }
      return $matrix;
    }
    public static function formatoCard($x) {
      $default = [
        'documento' => null,
        'imagen' => null,
        'estampados' => [
          'visado' => [],
          'firma'  => [],
        ],
      ];
      if(!empty($x['is_part'])) {
        $default['estampados']['visado'][$x['page']] = [
          'x' => rand(10000, 20999) / 100000,
          'y' => rand(85000, 92999) / 100000,
        ];
      } else {
        for($i = 0; $i < $x['folio']; $i++) {
          $default['estampados']['visado'][$i] = [
            'x' => rand(10000, 20999) / 100000,
            'y' => rand(85000, 92999) / 100000,
          ];
        }
      }
      return array_merge($default, $x);
    }
    public static function workspace_move($matrix, $cidx, $orden, $space = 1) {

      $o_i = static::workspace_get_card($matrix, $cidx);
      $o_i = $o_i['orden'];

      if($o_i == $orden) {
        return $matrix;
      }
      if ($o_i > $orden) {
        $cids = static::workspace_get_range($matrix, $o_i, $orden);
        foreach($cids as $cid) {
          $c = static::workspace_get_card($matrix, $cid);
          $c['orden'] += $space;
          $matrix[$cid] = $c;
        }
      } else {
        $cids = static::workspace_get_range($matrix, $o_i, $orden);
        foreach($cids as $cid) {
          $c = static::workspace_get_card($matrix, $cid);
          $c['orden'] -= $space;
          $matrix[$cid] = $c;
        }
      }
      $matrix[$cidx]['orden'] = (int) $orden;
      return static::workspace_ordenar($matrix);
    }

    public static function workspace_ordenar($matrix) {
      uasort($matrix, function($item1,$item2) {
        return $item1['orden'] - $item2['orden'];
      });
      $i = 0;
      $matrix = array_map(function($n) use(&$i) {
        $n['orden'] = $i;
        $i++;
        return $n;
      }, $matrix);

      return $matrix;
    }
    public static function workspace_get_range($matrix, $o_i, $o_f = null) {
      $matrix = array_filter($matrix, function($c) use ($o_i, $o_f) {
        if($o_f === null) {
          return $c['orden'] >= $o_i;

        } elseif($o_i > $o_f) {
          return $c['orden'] <= $o_i && $c['orden'] >= $o_f;

        } else {
          return $c['orden'] <= $o_f && $c['orden'] > $o_i;
        }
      });
     return array_keys($matrix);
    }

}

