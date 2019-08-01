<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function showAllStudents(Request $request )
    {

         if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $estudiantes=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.estado','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->orderBy('estudiantes.id','asc')->paginate(40);
        }else{
            $estudiantes=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.estado','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('estudiantes.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('estudiantes.id','asc')->paginate(40);
        }
        
        return [
            'pagination' => [
                'total' =>          $estudiantes->total(),
                'current_page'=>    $estudiantes->currentPage(),
                'per_page'=>        $estudiantes->perPage(),
                'last_page'=>       $estudiantes->lastPage(),
                'from' =>           $estudiantes->firstItem(),
                'to' =>             $estudiantes->lastItem()
            ],
            'estudiantes' => $estudiantes
        ];
        
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->estado = '0';
        $estudiante->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->estado = '1';
        $estudiante->save();
    }
    public function index(Request $request )
    {

         if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $estudiantes=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('estudiantes.estado','=',1)            
            ->orderBy('estudiantes.id','asc')->paginate(40);
        }else{
            $estudiantes=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('estudiantes.'.$criterio,'=',$buscar)
            ->where('estudiantes.estado','=',1)
            ->orderBy('estudiantes.id','asc')->paginate(40);
        }
        
        return [
            'pagination' => [
                'total' =>          $estudiantes->total(),
                'current_page'=>    $estudiantes->currentPage(),
                'per_page'=>        $estudiantes->perPage(),
                'last_page'=>       $estudiantes->lastPage(),
                'from' =>           $estudiantes->firstItem(),
                'to' =>             $estudiantes->lastItem()
            ],
            'estudiantes' => $estudiantes
        ];
        
    }
    public function getEstudiante(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $buscar= $request->buscar;
        $buscar1= $request->buscar1;
        $bimestre=$request->bimestre;
        if($buscar==''){
            
            $estudiantes=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion order by notas.id) AS calificacion')
            ->groupBy('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->paginate(40);

        }else{
            $estudiantes=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion order by notas.id) AS calificacion')
            ->groupBy('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->where('estudiantes.salon_id','=',$buscar)
            ->where('notas.curso_id','=',$buscar1)
            ->where('notas.bimestre','=',$bimestre)
            ->orderBy('estudiantes.nombres','asc')->paginate(40);
        }
        
        return [
            'pagination' => [
                'total' =>          $estudiantes->total(),
                'current_page'=>    $estudiantes->currentPage(),
                'per_page'=>        $estudiantes->perPage(),
                'last_page'=>       $estudiantes->lastPage(),
                'from' =>           $estudiantes->firstItem(),
                'to' =>             $estudiantes->lastItem()
            ],
            'estudiantes' => $estudiantes,
        ];
        
    
    }
    public function listarPdf(){
        

        $estudiantes=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->groupBy('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();

        $pdf = \PDF::loadView('pdf.notaspdf',['estudiantes'=>$estudiantes])->setPaper('a4', 'portrait');

        return $pdf->download($estudiante[0]['nombres'].'.pdf');
    }
    public function listarPdfPrimero(){
        

        $estudiantes=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->groupBy('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();

        $pdfprimero = \PDF::loadView('pdf.notasprimeropdf',['estudiantes'=>$estudiantes])->setPaper('a4', 'portrait');

        return $pdfprimero->download($estudiante[0]['nombres'].'.pdf');
    }
    public function listarBoleta(Request $request){

            $idestudiante=$request->idestudiante;
            $bimestre=$request->bimestre;
            $Desarrolloid=1;
            $CienciaSocialid=2;
            $EPTid=3;
            $EFid=4;
            $Comunicacionid=5;
            $Arteid=6;
            $Inglesid=8;
            $Matematicaid=9;
            $CTAid=10;
            $Religionid=11;
            $Actitudinalid=12;
            $notas=[];   
            
            $estudiante=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('estudiantes.id','=', $idestudiante)
            ->orderBy('estudiantes.id','asc')->get();

            $Desarrollo=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Desarrolloid)
            ->where('notas.bimestre','=',$bimestre)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['desarrollo']['Primer']=$Desarrollo;

            $CienciaSocial=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)
            ->where('notas.curso_id','=', $CienciaSocialid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['cienciaSocial']['Primer']=$CienciaSocial;

            $EPT=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $EPTid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['ept']['Primer']=$EPT;

            $EF=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $EFid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['ef']['Primer']=$EF;

            $Comunicacion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Comunicacionid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['comunicacion']['Primer']=$Comunicacion;

            $Arte=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Arteid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['arte']['Primer']=$Arte;

            $Ingles=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Inglesid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['ingles']['Primer']=$Ingles;

            $Matematica=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Matematicaid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['matematica']['Primer']=$Matematica;

            $CTA=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $CTAid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['cta']['Primer']=$CTA;

            $Religion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Religionid)
            ->orderBy('notas.competencia_id','asc')->get();

            $notas['religion']['Primer']=$Religion;

            $Actitudinal=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.bimestre','=',$bimestre)            
            ->where('notas.curso_id','=', $Actitudinalid)
            ->orderBy('notas.competencia_id','asc')->get();
        
            $notas['actitudinal']['Primer']=$Actitudinal;
        
            $pdf = \PDF::loadView('pdf.notaspdf',
            ['estudiante'=>$estudiante,
            // 'desarrollo'=>$Desarrollo,
            // 'cienciaSocial'=>$CienciaSocial,
            // 'ept'=>$EPT,
            // 'ef'=>$EF,
            // 'comunicacion'=>$Comunicacion,
            // 'arte'=>$Arte,
            // 'ingles'=>$Ingles,
            // 'matematica'=>$Matematica,
            // 'cta'=>$CTA,
            // 'religion'=>$Religion,
            // 'actitudinal'=>$Actitudinal
            'notas'=>$notas
             ])->setPaper('a4', 'portrait');
            return $pdf->download($estudiante[0]['nombres'].'.pdf');
            // return [['estudiante'=>$estudiante,
            // 'desarrollo'=>$Desarrollo,
            // 'cienciaSocial'=>$CienciaSocial,
            // 'ept'=>$EPT,
            // 'ef'=>$EF,
            // 'comunicacion'=>$Comunicacion,
            // 'arte'=>$Arte,
            // 'ingles'=>$Ingles,
            // 'matematica'=>$Matematica,
            // 'cta'=>$CTA,
            // 'religion'=>$Religion,
            // 'notas'=>$notas,
            // 'actitudinal'=>$Actitudinal
            //  ]];
    }
    public function listarBoletaPrimero(Request $request){
        
        
        $idestudiante=$request->idestudiante;
        
            $Desarrolloid=1;
            $CienciaSocialid=2;
            $EPTid=3;
            $EFid=4;
            $Comunicacionid=5;
            $Arteid=6;
            $Inglesid=8;
            $Matematicaid=9;
            $CTAid=10;
            $Religionid=11;
            $Actitudinalid=12;
            
            $estudiante=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('estudiantes.id','=', $idestudiante)
            ->orderBy('estudiantes.id','asc')->get();
                      
            $Desarrollo=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Desarrolloid)
            ->orderBy('notas.competencia_id','asc')->get();
            $CienciaSocial=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $CienciaSocialid)
            ->orderBy('notas.competencia_id','asc')->get();
            $EPT=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $EPTid)
            ->orderBy('notas.competencia_id','asc')->get();
            $EF=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $EFid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Comunicacion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Comunicacionid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Arte=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Arteid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Ingles=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Inglesid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Matematica=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Matematicaid)
            ->orderBy('notas.competencia_id','asc')->get();
            $CTA=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $CTAid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Religion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Religionid)
            ->orderBy('notas.competencia_id','asc')->get();
            $Actitudinal=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.calificacion','notas.curso_id','notas.competencia_id')
            ->where('estudiantes.id','=', $idestudiante)
            ->where('notas.curso_id','=', $Actitudinalid)
            ->orderBy('notas.competencia_id','asc')->get();
        
            $pdf = \PDF::loadView('pdf.notasprimeropdf',
            ['estudiante'=>$estudiante,
            'desarrollo'=>$Desarrollo,
            'cienciaSocial'=>$CienciaSocial,
            'ept'=>$EPT,
            'ef'=>$EF,
            'comunicacion'=>$Comunicacion,
            'arte'=>$Arte,
            'ingles'=>$Ingles,
            'matematica'=>$Matematica,
            'cta'=>$CTA,
            'religion'=>$Religion,
            'actitudinal'=>$Actitudinal
             ])->setPaper('a4', 'portrait');
            return $pdf->download($estudiante[0]['nombres'].'.pdf');
            // return [['estudiante'=>$estudiante,
            // 'desarrollo'=>$Desarrollo,
            // 'cienciaSocial'=>$CienciaSocial,
            // 'ept'=>$EPT,
            // 'ef'=>$EF,
            // 'comunicacion'=>$Comunicacion,
            // 'arte'=>$Arte,
            // 'ingles'=>$Ingles,
            // 'matematica'=>$Matematica,
            // 'cta'=>$CTA,
            // 'religion'=>$Religion,
            // // 'actitudinal'=>$Actitudinal
            //  ]];
    }
    public function listarBoletaSalon(Request $request){
        

        $buscar= $request->buscar;
        $buscar1= $request->buscar1;
        $idestudiante=$request->idestudiante;
        $idsalon=$request->idsalon;
            $Desarrolloid=1;
            $CienciaSocialid=2;
            $EPTid=3;
            $EFid=4;
            $Comunicacionid=5;
            $Arteid=6;
            $Inglesid=8;
            $Matematicaid=9;
            $CTAid=10;
            $Religionid=11;
            $Actitudinalid=12;
            
            $estudiante=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->select('estudiantes.id','estudiantes.nombres','estudiantes.dni','salones.seccion','salones.grado')
            ->where('salones.id','=', $idsalon)
            ->orderBy('estudiantes.id','asc')->get();
                      
            $Desarrollo=Estudiante::join('salones','salones.id','=','estudiantes.salon_id')
            ->join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('salones.id','=', $idsalon)
            ->where('notas.curso_id','=', $Desarrolloid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            
            
            
            
            $CienciaSocial=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $CienciaSocialid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();

            $EPT=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $EPTid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $EF=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $EFid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Comunicacion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Comunicacionid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Arte=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Arteid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Ingles=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Inglesid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Matematica=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Matematicaid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $CTA=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $CTAid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Religion=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Religionid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
            $Actitudinal=Estudiante::join('notas','notas.estudiante_id','=','estudiantes.id')
            ->select('estudiantes.id','notas.curso_id')
            ->selectRaw('GROUP_CONCAT(notas.calificacion) AS calificacion')
            ->where('estudiantes.salon_id','=', $idsalon)
            ->where('notas.curso_id','=', $Actitudinalid)
            ->groupBy('estudiantes.id','notas.curso_id')
            ->orderBy('estudiantes.id','asc')->get();
        
            // $pdf = \PDF::loadView('pdf.notaspdf',
            // ['estudiante'=>$estudiante,
            // 'desarrollo'=>$Desarrollo,
            // 'cienciaSocial'=>$CienciaSocial,
            // 'ept'=>$EPT,
            // 'ef'=>$EF,
            // 'comunicacion'=>$Comunicacion,
            // 'arte'=>$Arte,
            // 'ingles'=>$Ingles,
            // 'matematica'=>$Matematica,
            // 'cta'=>$CTA,
            // 'religion'=>$Religion,
            // 'actitudinal'=>$Actitudinal
            //  ])->setPaper('a4', 'portrait');
            // return $pdf->stream('nota.pdf');
            return [['estudiante'=>$estudiante,
            'desarrollo'=>$Desarrollo,
            'cienciaSocial'=>$CienciaSocial,
            'ept'=>$EPT,
            'ef'=>$EF,
            'comunicacion'=>$Comunicacion,
            'arte'=>$Arte,
            'ingles'=>$Ingles,
            'matematica'=>$Matematica,
            'cta'=>$CTA,
            'religion'=>$Religion,
            'actitudinal'=>$Actitudinal
             ]];
    }
}
