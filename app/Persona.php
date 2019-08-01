<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = 
	    [
	    'id',
	    'nombre',
	    'email',
	    'celular',
	    'dni'
		];

    public function user()
    {
        return $this->hasOne('App\User');
    }
    public function ProfesorCurso()
    {
    	return $this->hasMany('App\profesorCurso');
    }
    public function ProfesorSalon()
    {
    	return $this->hasMany('App\profesorSalon');
    }

}
