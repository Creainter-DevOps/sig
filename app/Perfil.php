<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use App\Traits\hasFillable;
use App\Facades\DB;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Actividad;
use Auth;
use App\Scopes\MultiTenant;


class Perfil extends Model
{
  use Notifiable,HasApiTokens,HasRoles,hasFillable;

  protected $connection = 'interno';
  protected $table = 'public.usuario_empresa';
  private $metas = null;

  const UPDATED_AT = null;
  const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'credencial_id','empresa_id','usuario_id','habilitado','linea','anexo','celular','cargo','firma','tenant_id','correo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'credencial_id' => 'integer',
      'empresa_id' => 'integer',
      'usuario_id' => 'string',
      'habilitado' => 'integer',
      'linea' => 'string',
      'anexo' => 'string',
      'celular' => 'string',
      'cargo' => 'string',
      'firma' => 'string',
      'correo'  => 'string',
      'tenant_id'   => 'integer',
    ];

    private function dinamicFillable() {
      return [
        'habilitado' => true,
        'linea' => true,
        'anexo' => true,
        'celular' => true,
      ];
    }
    public static function pagination() {
      return DB::PaginationQuery("
        SELECT
          UE.*,
          E.razon_social,
          osce.fn_usuarios_a_rotulo(1, UE.usuario_id) usuarios
        FROM public.usuario_empresa UE
        LEFT JOIN osce.credencial C ON C.id = UE.credencial_id
        LEFT JOIN osce.empresa E ON E.id = UE.empresa_id
        WHERE UE.tenant_id = :tid
        ORDER BY E.razon_social ASC, UE.habilitado DESC, C.usuario ASC, UE.correo ASC, UE.cargo ASC
      ", [
        'tid' => Auth::user()->tenant_id,
      ])
      ->hydrate('App\Perfil');
    }
    public static function tablefy($ce) {
      return $ce
      ->on('edit', 'usuario_id', function($row) {
        return [
          'type' => 'select',
          'attrs' => ['multiple' => 'multiple', 'size' => 5],
          'options' => User::permitidos()->pluck('usuario','id'),
        ];
      })
      ->on('save', 'usuario_id', function($row, $res) {
        $editar = [];
        $editar['usuario_id'] = DB::raw("'{" . implode(',', $res->value) . "}'");
        $row->update($editar);
        return true;
      })
      ->on('edit', 'empresa_id', function($row) {
        return [
          'type' => 'select',
          'attrs' => [],
          'options' => Empresa::propias()->pluck('razon_social','id'),
        ];
      })
      ->on('edit', 'credencial_id', function($row) {
        return [
          'type' => 'select',
          'attrs' => [],
          'options' => Credencial::propias()->pluck('usuario','id'),
        ];
      })
      ->on('edit', 'habilitado', function($row) {
        return [
          'type' => 'select',
          'attrs' => [],
          'options' => [
            0 => 'No',
            1 => 'Si',
          ]
        ];
      })
      ;
    }
    protected static function booted()
    {
        static::addGlobalScope(new MultiTenant);
    }
}
