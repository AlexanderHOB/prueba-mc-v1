<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
class DocenteController extends Controller
{
    public function index(Request $request )
    {

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $personas=Persona::join('profesorsalon','profesorsalon.profesor_id','=','personas.id')
            ->join('cursos','profesorsalon.curso_id','=','cursos.id')
            ->join('salones','profesorsalon.salon_id','=','salones.id')
            ->select('personas.id','personas.nombre','personas.dni','salones.seccion','salones.grado','profesorsalon.id as key', 'cursos.nombre as nombreCurso' )
            ->orderBy('personas.id','asc')->paginate(20);
        }else{
            $personas=Persona::join('profesorsalon','profesorsalon.profesor_id','=','personas.id')
            ->join('cursos','profesorsalon.curso_id','=','cursos.id')
            ->join('salones','profesorsalon.salon_id','=','salones.id')
            ->select('personas.id','personas.nombre','personas.dni','salones.seccion','salones.grado','profesorsalon.id as key', 'cursos.nombre as nombreCurso' )
            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('personas.id','asc')->paginate(20);
        }
        
        return [
            'pagination' => [
                'total' =>          $personas->total(),
                'current_page'=>    $personas->currentPage(),
                'per_page'=>        $personas->perPage(),
                'last_page'=>       $personas->lastPage(),
                'from' =>           $personas->firstItem(),
                'to' =>             $personas->lastItem()
            ],
            'personas' => $personas
        ];
        
    }
}

