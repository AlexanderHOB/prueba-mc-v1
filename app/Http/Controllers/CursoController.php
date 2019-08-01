<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
class CursoController extends Controller
{
    public function index(Request $request )
    {

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $cursos=Curso::orderBy('id','asc')->paginate(10);
        }else{
            $cursos= Curso::where($criterio,'like','%'.$buscar.'%')->orderBy('id','asc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total' =>          $cursos->total(),
                'current_page'=>    $cursos->currentPage(),
                'per_page'=>        $cursos->perPage(),
                'last_page'=>       $cursos->lastPage(),
                'from' =>           $cursos->firstItem(),
                'to' =>             $cursos->lastItem()
            ],
            'cursos' => $cursos
        ];
        
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $curso = new Curso();
        $curso->nombre=$request->nombre;
        $curso->save();

    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $curso=Curso::findOrFail($request->id);
        $curso->nombre=$request->nombre;
        $curso->save();
    }
    public function selectCurso(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $cursos=Curso::select('id','nombre')->orderBy('nombre','asc')->get();
        return ['cursos'=>$cursos];
    }
}
