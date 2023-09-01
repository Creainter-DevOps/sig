<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use Auth;

class Correo extends Model
{
    protected $table = 'osce.correo';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'asunto','correo_hasta','correo_copia','asunto','texto','contacto_id','adjuntos_cantidad','adjuntos',
      'leido_el', 'leido_por',
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
        'adjuntos' => 'json'
      ];

    public function timeline(){
      return $this->hasMany('App\Actividad','contacto_id')->orderBy('id' , 'DESC')->get();   
    }

    public function persona() {
        return $this->belongsTo('App\Persona', 'persona_id')->first();
    }

    public function contacto() {
        return $this->belongsTo('App\Contacto', 'contacto_id')->first();
    }

    public function cliente() {
       return $this->belongsTo('App\Cliente', 'cliente_id')->first();
    }
    public function oportunidad() {
       return $this->belongsTo('App\Oportunidad', 'id', 'correo_id')->first();
    }
    public function credencial() {
       return $this->belongsTo('App\Credencial', 'credencial_id')->first();
    }


    public function getCargo() {
       return 'Representante Legal';
    }

    public function adjuntos(){
       return $this->belongsTo( 'App\Documento', 'id', 'correo_id')->get();
    }

    public function NombresApellidos(){
      return $this->nombres . " " . $this->apellidos; 
    }

    public static function search( $term ) {
        $term = strtolower(trim($term));
        return static:: where(function($query) use($term) {
            $query->WhereRaw("LOWER(nombres) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(apellidos) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(celular) LIKE ?",["%{$term}%"])
            ;
        });
    }
    public static function buzones() {
      return collect(DB::select("
SELECT CC.id, CC.usuario, CC.nombre,
(
	SELECT COUNT(1)
	FROM osce.correo C
	WHERE C.credencial_id = CC.id AND C.leido_el IS NULL
) noleidos,
(
	SELECT COUNT(1)
	FROM osce.correo C
	WHERE C.credencial_id = CC.id
) total
FROM osce.credencial CC
WHERE proveedor = 'CORREO' AND CC.tenant_id IS NOT NULL
AND CC.tenant_id = :tid
ORDER BY 4 DESC, 5 DESC, CC.empresa_id ASC, CC.usuario ASC, CC.id DESC", [
  'tid' => Auth::user()->tenant_id
]));
    }
    public static function buzon($credencial) {
      return DB::PaginationQuery("
        SELECT
          C.id,
          C.asunto,
          C.correo_desde,
          C.fecha,
          C.leido_el,
          osce.fn_usuario_rotulo(C.leido_por) leido_por
        FROM osce.correo C
        WHERE C.credencial_id = :cid
        --search AND (UPPER(C.asunto) LIKE CONCAT('%', UPPER(:q), '%') OR UPPER(C.texto) LIKE CONCAT('%', UPPER(:q), '%'))
        ORDER BY fecha DESC, id DESC
      ", [
#        'tenant' => Auth::user()->tenant_id,
      'cid' => $credencial->id,
//        'user'   => Auth::user()->id,
      ]);#->countEstimate();
    }
    
}
