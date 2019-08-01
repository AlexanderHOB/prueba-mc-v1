<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    protected $fillable = [
        'id',
        'salon_id',
    	'nombres',
    	'dni',
    ];
    public function Notas(){
    	return $this->hasMany('App\Nota');
    }
    public function Salon(){
    	return $this->belongsTo('App\Salon');
    }

}
