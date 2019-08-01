<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Competencia;
class CompetenciaController extends Controller
{
    public function index(Request $request )
    {

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $competencias=Competencia::join('cursos','cursos.id','=','competencias.curso_id')
            ->select('competencias.id','competencias.nombre','cursos.nombre as nombreCurso','cursos.id as curso_id')
            ->orderBy('cursos.nombre','asc')->paginate(10);
        }else{
            $competencias=Competencia::join('cursos','cursos.id','=','competencias.curso_id')
            ->select('competencias.id','competencias.nombre','cursos.nombre as nombreCurso','cursos.id as curso_id')
            ->where('cursos.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('cursos.nombre','asc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total' =>          $competencias->total(),
                'current_page'=>    $competencias->currentPage(),
                'per_page'=>        $competencias->perPage(),
                'last_page'=>       $competencias->lastPage(),
                'from' =>           $competencias->firstItem(),
                'to' =>             $competencias->lastItem()
            ],
            'competencias' => $competencias
        ];
        
    }
    public function selectCompetencia(Request $request){
        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $competencias=Competencia::join('cursos','cursos.id','=','competencias.curso_id')
            ->select('competencias.id','competencias.nombre','cursos.nombre as nombreCurso','cursos.id as curso_id')
            ->orderBy('competencias.id','asc')->paginate(10);
        }else{
            $competencias=Competencia::join('cursos','cursos.id','=','competencias.curso_id')
            ->select('competencias.id','competencias.nombre','cursos.nombre as nombreCurso','cursos.id as curso_id')
            ->where('competencias.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('competencias.id','asc')->paginate(10);
        }
        return['competencias'=>$competencias];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
       
        $competencia = new Competencia();
        $competencia->nombre=$request->nombre;
        $competencia->curso_id=$request->curso_id;
        $competencia->save();
    }
    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $competencia=Competencia::findOrFail($request->id);
        $competencia->nombre=$request->nombre;
        $competencia->curso_id=$request->curso_id;
        $competencia->save();
    }

    public function getCompetencia(Request $request){
        $buscar= $request->buscar;
        $competencias=Competencia::join('cursos','cursos.id','=','competencias.curso_id')
            ->select('competencias.id','competencias.nombre','cursos.nombre as nombreCurso','cursos.id as curso_id')
            ->where('competencias.curso_id','=',$buscar)
            ->orderBy('competencias.id','asc')
            ->get();
            return ['competencias'=> $competencias];
    }
}
