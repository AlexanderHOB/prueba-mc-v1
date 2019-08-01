<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $fillable = [
    	'id',
    	'nombre',
    	'curso_id',
    ];
    public $timestamps = false;
    public function Curso(){
        return $this->belongsTo('App\Curso');
    }
    public function Notas(){
    	return $this->hasMany('App\Nota');
    }
}
