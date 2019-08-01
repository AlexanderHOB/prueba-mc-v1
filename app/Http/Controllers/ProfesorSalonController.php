<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProfesorSalon;

class ProfesorSalonController extends Controller
{
    public function selectSalones(Request $request){
        if(!$request->ajax()) return redirect('/');
        $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
        ->join('personas','personas.id','=','profesorsalon.profesor_id')
        ->join('cursos','cursos.id','=','profesorsalon.curso_id')
        ->select('profesorsalon.id','profesorsalon.profesor_id','profesorsalon.curso_id','profesorsalon.salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
        ->orderBy('profesorsalon.id','asc')
        ->where('personas.id','=',auth()->id())
        ->where('salones.grado','<>','Primero')
        ->get();
        return ['salones'=>$salones];
    }
    public function selectSalonesPrimero(Request $request){
        if(!$request->ajax()) return redirect('/');
        $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
        ->join('personas','personas.id','=','profesorsalon.profesor_id')
        ->join('cursos','cursos.id','=','profesorsalon.curso_id')
        ->select('profesorsalon.id','profesorsalon.profesor_id','profesorsalon.curso_id','profesorsalon.salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
        ->orderBy('profesorsalon.id','asc')
        ->where('salones.grado','=','Primero')
        ->where('personas.id','=',auth()->id())
        ->get();
        return ['salones'=>$salones];
    }
    public function selectSalonesActitudinal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $actitudinalid=12;
        $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
        ->join('personas','personas.id','=','profesorsalon.profesor_id')
        ->join('cursos','cursos.id','=','profesorsalon.curso_id')
        ->select('profesorsalon.id','profesorsalon.profesor_id','profesorsalon.curso_id','profesorsalon.salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
        ->where('cursos.id','=',$actitudinalid)
        ->where('personas.id','=',auth()->id())
        ->orderBy('profesorsalon.id','asc')
        ->get();
        return ['salones'=>$salones];
    }
    public function selectSalonesAdmin(Request $request){
        if(!$request->ajax()) return redirect('/');
        $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
        ->join('personas','personas.id','=','profesorsalon.profesor_id')
        ->join('cursos','cursos.id','=','profesorsalon.curso_id')
        ->select('profesorsalon.id','profesorsalon.profesor_id','profesorsalon.curso_id','profesorsalon.salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
        ->where('salones.grado','<>','Primero')
        ->orderBy('salones.id','asc')
        ->get();
        return ['salones'=>$salones];
    }
    public function selectSalonesAdminPrimero(Request $request){
        if(!$request->ajax()) return redirect('/');
        $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
        ->join('personas','personas.id','=','profesorsalon.profesor_id')
        ->join('cursos','cursos.id','=','profesorsalon.curso_id')
        ->select('profesorsalon.id','profesorsalon.profesor_id','profesorsalon.curso_id','profesorsalon.salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
        ->where('salones.grado','=','Primero')
        ->orderBy('salones.id','asc')
        ->get();
        return ['salones'=>$salones];
    }
    public function getProfesorSalonCurso(Request $request){
        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
            ->join('personas','personas.id','=','profesorsalon.profesor_id')
            ->join('cursos','cursos.id','=','profesorsalon.curso_id')
            ->select('profesorsalon.id','profesor_id','curso_id','salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
            ->orderBy('profesorsalon.id','asc')
            ->where('personas.id','=',auth()->id())
            ->get();
        }else{
            $salones=profesorSalon::join('salones','salones.id','=','profesorsalon.salon_id')
            ->join('personas','personas.id','=','profesorsalon.profesor_id')
            ->join('cursos','cursos.id','=','profesorsalon.curso_id')
            ->select('profesorsalon.id','profesor_id','curso_id','salon_id','personas.nombre','salones.grado','salones.seccion','cursos.nombre as nombreCurso')
            ->where('profesorsalon.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('profesorsalon.id','asc')
            ->get();
        }
        
        return [
    
            'getsalones' => $salones
        ];
        
    
    }
}
