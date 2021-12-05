<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,HasRoles;

    protected $table = 'public.usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'clave','tenant_id',
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
        'email_verified_at' => 'datetime',
      ];

//    public function getAuthIdentifier() {
//        return $this->getKey();
//    }
    public function getAuthPassword() {
      return $this->clave;
    }
    public function username() {
      return 'usuario';
    }
    public function tenants() {
      return $this->hasMany('App\Empresa', 'tenant_id', 'tenant_id')->get();
    }
    public static function search($term ) {
      $term = strtolower(trim($term));
      return  static::where( function ($query ) use( $term ) {
        $query->WhereRaw('LOWER(usuario) LIKE ?', ["%{$term}%"]);
      });
    }

}
