<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');
    //Notificaciones 
    Route::post('/notification/get', 'NotificationController@get'); 
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Almacenero']], function () {
        //Router de Estudiante
        Route::get('/estudiante', 'EstudianteController@index');
        Route::get('/estudiante/show', 'EstudianteController@showAllStudents');

        Route::get('/estudiante/nota', 'EstudianteController@getEstudiante');
        Route::get('/estudiante/listarpdf', 'EstudianteController@listarpdf');
        Route::get('/estudiante/listarboleta', 'EstudianteController@listarBoleta');



        //Router de Curso
        Route::get('/curso', 'CursoController@index');
        Route::post('/curso/registrar', 'CursoController@store');
        Route::put('/curso/actualizar', 'CursoController@update');
        Route::get('/curso/selectCurso', 'CursoController@selectCurso');

        //Router de docente
        Route::get('/docente', 'DocenteController@index');

        //Router de competencia
        Route::get('/competencia', 'CompetenciaController@index');
        Route::post('/competencia/registrar', 'CompetenciaController@store');
        Route::put('/competencia/actualizar', 'CompetenciaController@update');
        Route::get('/competencia/getcompetencia','CompetenciaController@getCompetencia');

        //Router Salones Profesor
        Route::get('/salonProfesor', 'ProfesorSalonController@selectSalones');
        Route::get('/salonProfesor/admin', 'ProfesorSalonController@selectSalonesAdmin');
        Route::get('/salonProfesor/adminPrimero', 'ProfesorSalonController@selectSalonesAdminPrimero');
        Route::get('/getSalonProfesor', 'ProfesorSalonController@getProfesorSalonCurso');
        Route::get('/getSalonProfesor/primero', 'ProfesorSalonController@selectSalonesPrimero');

        //Router de Notas
        Route::get('/nota', 'NotaController@index');
        Route::post('/nota/registrar', 'NotaController@store');
    });

    Route::group(['middleware' => ['Vendedor']], function () {
        //Router de Estudiante
        Route::get('/estudiante', 'EstudianteController@index');
        Route::get('/estudiante/nota', 'EstudianteController@getEstudiante');
        Route::get('/estudiante/listarpdf', 'EstudianteController@listarpdf');
        Route::get('/estudiante/listarboleta', 'EstudianteController@listarBoleta');



        //Router de Curso
        Route::get('/curso', 'CursoController@index');
        Route::post('/curso/registrar', 'CursoController@store');
        Route::put('/curso/actualizar', 'CursoController@update');
        Route::get('/curso/selectCurso', 'CursoController@selectCurso');

        //Router de docente
        Route::get('/docente', 'DocenteController@index');

        //Router de competencia
        Route::get('/competencia', 'CompetenciaController@index');
        Route::post('/competencia/registrar', 'CompetenciaController@store');
        Route::put('/competencia/actualizar', 'CompetenciaController@update');
        Route::get('/competencia/getcompetencia','CompetenciaController@getCompetencia');

        //Router Salones Profesor
        Route::get('/salonProfesor', 'ProfesorSalonController@selectSalones');
        Route::get('/salonProfesor/admin', 'ProfesorSalonController@selectSalonesAdmin');
        Route::get('/getSalonProfesor', 'ProfesorSalonController@getProfesorSalonCurso');
        Route::get('/getSalonProfesor/primero', 'ProfesorSalonController@selectSalonesPrimero');

        //Router de Notas
        Route::get('/nota', 'NotaController@index');
        Route::post('/nota/registrar', 'NotaController@store');
    });

    Route::group(['middleware' => ['Administrador']], function () {
        
        

        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        Route::get('/user/listarPdf','UserController@listarPdf')->name('usuarios_pdf');

        //Router de Estudiante
        Route::get('/estudiante', 'EstudianteController@index');
        Route::put('/estudiante/activar', 'EstudianteController@activar');
        Route::put('/estudiante/desactivar', 'EstudianteController@desactivar');

        Route::get('/estudiante/nota', 'EstudianteController@getEstudiante');
        Route::get('/estudiante/listarpdf', 'EstudianteController@listarpdf');
        Route::get('/estudiante/listarboleta', 'EstudianteController@listarBoleta');
        Route::get('/estudiante/listarpdfprimero', 'EstudianteController@listarPdfPrimero');
        Route::get('/estudiante/listarboletaprimero', 'EstudianteController@listarBoletaPrimero');
        Route::get('/estudiante/listarboletasalon', 'EstudianteController@listarBoletaSalon');


        //Router de Curso
        Route::get('/curso', 'CursoController@index');
        Route::post('/curso/registrar', 'CursoController@store');
        Route::put('/curso/actualizar', 'CursoController@update');
        Route::get('/curso/selectCurso', 'CursoController@selectCurso');

        //Router de docente
        Route::get('/docente', 'DocenteController@index');

        //Router de competencia
        Route::get('/competencia', 'CompetenciaController@index');
        Route::post('/competencia/registrar', 'CompetenciaController@store');
        Route::put('/competencia/actualizar', 'CompetenciaController@update');
        Route::get('/competencia/getcompetencia','CompetenciaController@getCompetencia');

        //Router Salones Profesor
        Route::get('/salonProfesor', 'ProfesorSalonController@selectSalones');
        Route::get('/salonProfesor/admin', 'ProfesorSalonController@selectSalonesAdmin');
        Route::get('/getSalonProfesor', 'ProfesorSalonController@getProfesorSalonCurso');
        Route::get('/getSalonProfesor/primero', 'ProfesorSalonController@selectSalonesPrimero');
        Route::get('/getSalonProfesor/actitudinal', 'ProfesorSalonController@selectSalonesActitudinal');


        
        //Router de Notas
        Route::get('/nota', 'NotaController@index');
        Route::post('/nota/registrar', 'NotaController@store');



    });
    
});
// Route::post('/nota/registrar', 'NotaController@store');

//Route::get('/home', 'HomeController@index')->name('home');
