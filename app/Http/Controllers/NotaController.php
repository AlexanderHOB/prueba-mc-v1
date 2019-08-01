<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Nota;
class NotaController extends Controller
{
    public function index(Request $request )
    {

         if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $notas=Nota::join('estudiantes','estudiantes.id','=','notas.estudiante_id')
            ->join('competencias','competencias.id','=','notas.competencia_id')
            ->join('cursos','cursos.id','=','notas.curso_id')
            ->select('notas.id','estudiantes.id as idestudiante','estudiantes.nombres','estudiantes.dni','notas.bimestre','notas.calificacion','competencias.id as idcompetencia','competencias.nombre','cursos.nombre as nombreCurso')
            ->orderBy('notas.id','asc')->paginate(10);
        }else{  
            $notas=Nota::join('estudiantes','estudiantes.id','=','notas.estudiante_id')
            ->join('competencias','competencia.id','=','notas.competencia_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','notas.bimestre','notas.calificacion','competencias.id as idcompetencia')
            ->where('nota.estudiante_id','like','%'.$buscar.'%')
            ->orderBy('estudiantes.id','asc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total' =>          $notas->total(),
                'current_page'=>    $notas->currentPage(),
                'per_page'=>        $notas->perPage(),
                'last_page'=>       $notas->lastPage(),
                'from' =>           $notas->firstItem(),
                'to' =>             $notas->lastItem()
            ],
            'notas' => $notas
        ];
    }
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            $detalles = $request->data;
            
            foreach($detalles as $ep=>$det)
            {
                for($i=0;$i<count($det['competencia']);$i++){
                    $nota = new Nota();
                    $nota->competencia_id = $det['competencia'][$i];
                    $nota->estudiante_id = $det['id'];
                    $nota->curso_id = $det['idcurso'];
                    $nota->calificacion = $det['nota']['nota'.$i];
                    $nota->bimestre = $det['bimestre'];
                    $nota->save();
                }
            }
        
            DB::commit();
            return [
                'id' => $nota->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
        
                for($i=0;$i<count($request['competencia']);$i++){
                    $nota = Nota::findOrFail($request['id']);
                    $nota->competencia_id   = $request['competencias'][$i];
                    $nota->estudiante_id    = $request['id'];
                    $nota->curso_id         = $request['curso_id'];
                    $nota->calificacion     = $request['notas'][$i];
                    $nota->bimestre         = $request['bimestre'];
                    $nota->save();
                }

        
            DB::commit();
            return [
                'id' => $nota->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}

