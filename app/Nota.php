<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    
    protected $fillable = [
    	'competencia_id',
    	'estudiante_id',
    	'curso_id',
    	'calificacion',
    	'bimestre'
    ];
    public $timestamps = false;

    public function Curso(){
        return $this->belongsTo('App\Curso');
    }
	public function Compentencia(){
        return $this->belongsTo('App\Competencia');
    }
    public function Estudiante(){
        return $this->belongsTo('App\Estudiante');
    }
}
