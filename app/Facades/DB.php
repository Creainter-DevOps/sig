<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as originalDB;
//use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Helper;
use App\Facades\Pagination;

class DB extends originalDB
{

  public static function PaginationQuery($query, $params = []) {
    $opo = new PaginationQuery;
    $opo->query($query, $params);
    return $opo;
  }
  public static function pagination($query, $params = []) {
    $cantidad = "SELECT count(*) total FROM (" . $query . ")x";
    $cantidad = static::collect($cantidad, $params)->first();
    $opo = new LengthAwarePaginator([], $cantidad->total, 50);
    $query = "SELECT * FROM (" . $query . ")x LIMIT " . $opo->perpage() . " OFFSET " . (($opo->currentPage() - 1) * 50);
    $data = static::collect($query, $params);
    $opo = new LengthAwarePaginator($data->all(), $cantidad->total, 50);
    return $opo;
  }
  public static function collect($query, $params = [])
    {
      $time_start = microtime(true);
      //try {
        $opo = collect(DB::select($query, $params));
      //} catch(\Illuminate\Database\QueryException $err) {
      //  $opo = collect([]);
      //}
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
