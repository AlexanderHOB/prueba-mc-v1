<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
   	
    protected $fillable = [
    	'id',
    	'nombre',
    ];
    public $timestamps = false;
    
	
    public function ProfesorCurso(){
    	return $this->hasMany('App\profesorCurso');
    }
    public function Notas(){
    	return $this->hasMany('App\Nota');
    }
    public function Competencias(){
    	return $this->hasMany('App\Competencia');
    }
    public function ProfesorSalon(){
    	return $this->hasMany('App\profesorSalon');
    }

}
