<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profesorSalon extends Model
{
    protected $table = 'profesorsalon';
    protected $fillable = [
        'id',
        'salon_id',
        'profesor_id',
        'curso_id'
    ];
    public function Profesor(){
        return $this->belongsTo('App\Persona');
    }
    public function Salon(){
        return $this->belongsTo('App\Salon');
    }
    public function Curso(){
        return $this->belongsTo('App\Curso');
    }
}
