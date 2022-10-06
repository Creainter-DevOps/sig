<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as originalDB;
use App\Helpers\Helper;

class DB extends originalDB
{
  public static function collect($query, $params = [])
    {
      $time_start = microtime(true);
      $opo = collect(DB::select($query, $params));
      $opo->execute = new \stdClass();

      $diff = microtime(true) - $time_start;
      $sec = intval($diff);
      $micro = $diff - $sec;
      $opo->execute->time = strftime('%T', mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
      return $opo;
    }
  public static function cache($time, $query, $params = [])
    {
      $hash = 'query_' . md5($query);
      if(Helper::json_has($hash)) {
        if(!Helper::json_timeout($hash, $time)) {
          return Helper::json_load($hash);
        }
      }
      $rp = DB::select($query, $params);
      Helper::json_save($hash, $rp);
      return $rp;
    }
}
