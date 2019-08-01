<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $table = 'salones';
    protected $fillable = [
    	'estudiante_id',
    	'profesor_id',
    	'curso_id',
    	'seccion',
    	'grado'
    ];
    public function ProfesorSalon(){
    	return $this->hasMany('App/profesorSalon');
    }
    public function Estudiante(){
    	return $this->hasMany('App/Estudiante');
    }
}
