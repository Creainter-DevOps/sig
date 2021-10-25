<?php

namespace App;

use App\Persona;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'osce.contacto';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telefono', 'correo_electronico', 'cargo_id', 'cliente_id', 'persona_id'
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
    public function persona() {
        return $this->belongsTo('App\Persona', 'persona_id')->first();
    }
    public function getCargo() {
        return 'Representante Legal';
    }
}
