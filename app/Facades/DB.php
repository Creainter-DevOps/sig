<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as originalDB;
use App\Helpers\Helper;

class DB extends originalDB
{
  public static function cache($time, $query, $params = [])
    {
      $hash = 'query_' . md5($query);
      if(Helper::json_has($hash)) {
        if(Helper::json_timeout($hash, $time)) {
          return Helper::json_load($hash);
        }
      }
      $rp = DB::select($query, $params);
      Helper::json_save($hash, $rp);
      return $rp;
    }
}
