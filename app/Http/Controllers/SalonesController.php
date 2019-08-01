<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salon;
class SalonesController extends Controller
{
    public function index(Request $request )
    {

         if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $salones=Salon::join('personas','salones.profesor_id','=','personas.id')
            ->select('salones.id','salones.seccion','salones.dni','salones.seccion','salones.grado')
            ->orderBy('salones.id','asc')->paginate(10);
        }else{
            $salones=Salon::join('salones','salones.estudiante_id','=','salones.id')
            ->select('salones.id','salones.nombres','salones.dni','salones.seccion','salones.grado')
            ->where('salones.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('salones.id','asc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total' =>          $salones->total(),
                'current_page'=>    $salones->currentPage(),
                'per_page'=>        $salones->perPage(),
                'last_page'=>       $salones->lastPage(),
                'from' =>           $salones->firstItem(),
                'to' =>             $salones->lastItem()
            ],
            'salones' => $salones
        ];
        
    }
    
}
