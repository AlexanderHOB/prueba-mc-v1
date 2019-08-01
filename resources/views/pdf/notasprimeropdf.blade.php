<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Notas</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            /* font-size: 0.5rem; */
            font-size: 12px;
            font-weight: normal;
            /* line-height: 1.5; */
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            /* margin-bottom: 1rem; */
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
            margin-bottom: 15px;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            /* padding: 0.48rem; */
            padding: 4.5px;
            vertical-align: top;
            border-top: 1px solid #000;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #000;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
        }
        th, td {
            font-size: 11px;
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        div.firma {
          font-family: calibri;
          font-size: 11px;
          margin-top: 50px;
        }
        div.director {
          margin-top: -6px;
          margin-right: 70px;
          float: right;
          width:140px;
          margin-left: 100px;
        }
        div.tutor {
          width: 160px;
          margin-left: 115px;
        }
        .centrar{
            text-align: center;
            font-size: 1.71em;
        }
        .container{
          width: 65%;
          margin-left: 120px;
        }
        .image{
          width:100px;
          height: 100px;
          position: absolute;
        }
      
        .image-escudo{
          left: 15px;
          top:120px;
        }
        .image-boleta{
          right:15px;
          top:120px;
        }
        
    </style>
</head>
<body>
    <div class="contenedor">
      <h4 class="centrar ">INFORME DE PROGRESO DEL APRENDIZAJE DEL ESTUDIANTE - 2019 </h4>
      <div class="container">
            <img src="img/escudo-boleta.png" alt="escudo" class="image image-escudo">
            <table class="table table-bordered table-striped table-sm">
              <tr>
                  <th>DRE:</th>
                  <th>DRE Junín</th>
                  <th>UGEL:</th>
                  <th>Huancayo</th>
              </tr>
              <tr>
                  <th>Nivel:</th>
                  <th>Secundario</th>
                  <th>Codigo Modular</th>
                  <th>0372599-0</th>
              </tr>
              <tr>
                  <th>Institución Educativa</th>
                  <th colspan="3">Mariscal Castilla</th>
              </tr>
              @foreach ($estudiante as $e)
                  <tr>
                      <td> <b>Grado: </b></td>
                      <td>{{$e->grado}}</td>
                      <td><b>Seccion:</b> </td>
                      <td>{{$e->seccion}}</td>
                  </tr>
                  <tr>
                      <td><b> Apellidos y Nombres del estudiante </b></td>
                      <td colspan="3">{{$e->nombres}}</td>
                  </tr>
                  <tr>
                      <td><b>Codigo de Matricula: </b></td>
                      <td>{{$e->dni}}</td>
                      <td><b>DNI: </b></td>
                      <td>{{$e->dni}}</td>
                  </tr>
              @endforeach
            </table>
            <img src="img/mc-boleta.png" alt="insignia" class="image image-boleta">    
      </div>
      
          <div>
            <table class="table table-bordered table-striped table-sm">
              <thead class="titler">
                <tr>
                    <th rowspan="2" class="t1" style="text-align:center; vertical-align:middle;">AREA CURRICULAR</th>
                    <th rowspan="2" class="t7" style="text-align:center; vertical-align:middle;">COMPETENCIAS</th>
                    <th colspan="4" class="t8" style="text-align:center; vertical-align:middle;">CALIFICATIVO POR PERIODO</th>
                    <th rowspan="2" class="t9" style="text-align:center; vertical-align:middle;">Calif. final del área</th>
                  </tr>
                  <tr>
                    <th class="t1">1</th>
                    <th class="t1">2</th>
                    <th class="t1">3</th>
                    <th class="t1">4</th>
                  </tr>
              </thead>
                <tbody>
                {{-- condicional de curso desarrollo --}}
                @if(count($desarrollo)!=0)
                  <tr>
                    <th rowspan="2" class="t5" style=" vertical-align:middle; font-size:14px;">Desarrollo Personal, Ciudadania y Cívica</th>
                    <td>Construye su identidad.</td>
                    <td><b>{{$desarrollo[0]['calificacion']}}</b></td>                   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td rowspan="2"></td>
                  </tr>
                  <tr>
                    <td>Convive y participa democraticamente en la búsqueda del bien común.</td>
                    <td><b>{{$desarrollo[1]['calificacion']}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  
                  @else
                  <tr>
                      <th rowspan="2" class="t5">Desarrollo Personal, Ciudadania y Cívica</th>
                      <td>Construye su identidad.</td>
                      <td></td>                   
                      <td></td>
                      <td></td>
                      <td></td>
                      <td rowspan="2"></td>
                    </tr>
                    <tr>
                      <td>Convive y participa democraticamente en la búsqueda del bien común.</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    
                  @endif
                  <!--Curso 2-->
                  {{-- condicional del curso de ciencia social --}}
                  @if(count($cienciaSocial)!=0)
                  <tr>
                      <th rowspan="3" class="t5" style=" vertical-align:middle; font-size:14px;">Ciencias Sociales</th>
                      <td>Construye interpretaciones históricas.</td>
                      <td><b>{{$cienciaSocial[0]['calificacion']}}</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td rowspan="3"></td>
                    </tr>
                    <tr>
                      <td>Gestiona responsablemente el espacio y el ambiente.</td>
                      <td><b>{{$cienciaSocial[1]['calificacion']}}</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Gestiona responsablemente los recursos económicos.</td>
                      <td><b>{{$cienciaSocial[2]['calificacion']}}</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    
                    @else
                    <tr>
                        <th rowspan="3" class="t5">Ciencias Sociales</th>
                        <td>Construye interpretaciones históricas.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="3"></td>
                      </tr>
                      <tr>
                        <td>Gestiona responsablemente el espacio y el ambiente.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Gestiona responsablemente los recursos económicos.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      
                    @endif
                    <!--Curso 3-->
                    {{-- condicional del curso de educacion para el trabajo --}}
                    @if(count($ept)!=0)
                    <tr>
                        <th rowspan="1" class="t5" style=" vertical-align:middle; font-size:14px;">Educación para el Trabajo</th>
                        <td>Gestiona proyectos de emprendimiento económico o social.</td>
                        <td><b>{{$ept[0]['calificacion']}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="1"></td>
                    </tr>
                    
                    @else
                    <tr>
                        <th rowspan="1" class="t5">Educación para el Trabajo</th>
                        <td>Gestiona proyectos de emprendimiento económico o social.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="1"></td>
                    </tr>
                    
                    @endif                   
                      <!--Curso 4-->
                      {{-- condicional del curso de educacion fisica --}}
                      @if(count($ef)!=0)
                      <tr>
                        <th rowspan="3" class="t5" style=" vertical-align:middle; font-size:14px;" >Educación Física</th>
                        <td>Se desenvuelve de manera autónoma a través de su motricidad.</td>
                        <td><b>{{$ef[0]['calificacion']}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="3"></td>
                      </tr>
                      <tr>
                        <td>Asume una vida saludable.</td>
                        <td><b>{{$ef[1]['calificacion']}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Interactúa a través de sus habilidades sociomotrices.</td>
                        <td><b>{{$ef[2]['calificacion']}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      
                      @else 
                      <tr>
                          <th rowspan="3" class="t5">Educación Física</th>
                          <td>Se desenvuelve de manera autónoma a través de su motricidad.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td rowspan="3"></td>
                        </tr>
                        <tr>
                          <td>Asume una vida saludable.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Interactúa a través de sus habilidades sociomotrices.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                      @endif
                        <!--Curso 5-->
                      {{-- condicional de comunicacion --}}
                      @if(count($comunicacion)!=0)
                        <tr>
                          <th rowspan="3" class="t5" style=" vertical-align:middle; font-size:14px;">Comunicación</th>
                          <td>Se comunica oralmente en su lengua materna.</td>
                          <td><b>{{$comunicacion[0]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td rowspan="3"></td>
                        </tr>
                        <tr>
                          <td>Lee diversos tipos de textos en su lengua materna.</td>
                          <td><b>{{$comunicacion[1]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Escribe diversos tipos de textos en su lengua materna.</td>
                          <td><b>{{$comunicacion[2]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                        @else 
                        <tr>
                            <th rowspan="3" class="t5">Comunicación</th>
                            <td>Se comunica oralmente en su lengua materna.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="3"></td>
                          </tr>
                          <tr>
                            <td>Lee diversos tipos de textos en su lengua materna.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Escribe diversos tipos de textos en su lengua materna.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                      @endif
                        <!--Curso 6-->
                        {{-- condicional el arte --}}
                      @if(count($arte)!=0)
                        <tr>
                            <th rowspan="2" class="t5" style="vertical-align:middle;">Arte y Cultura</th>
                            <td>Aprecia de manera crítica manifestaciones artístico-culturales.</td>
                            <td><b>{{$arte[0]['calificacion']}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2"></td>
                          </tr>
                          <tr>
                            <td>Crea proyectos desde los lenguajes artísticos.</td>
                            <td><b>{{$arte[1]['calificacion']}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                        @else
                        <tr>
                            <th rowspan="2" class="t5">Arte y Cultura</th>
                            <td>Aprecia de manera crítica manifestaciones artístico-culturales.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2"></td>
                          </tr>
                          <tr>
                            <td>Crea proyectos desde los lenguajes artísticos.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                        @endif                   
                          <!--Curso 7-->
                      <tr>
                          <th rowspan="3" class="t5">Castellano como segunda lengua</th>
                          <td>Se comunica oralmente en castellano como segunda lengua.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          
                          <td rowspan="3"></td>
                        </tr>
                        <tr>
                          <td>Lee diversos tipos de textos escritos en castellano como segunda lengua.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Escribe diversos tipos de textos en castellano como segunda lengua.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                        <!--Curso 8-->
                        {{-- condicional del curso Ingles --}}
                        @if(count($ingles)!=0)                     
                        <tr>
                          <th rowspan="3" class="t5" style=" vertical-align:middle; font-size:14px;">Inglés como lengua extranjera</th>
                          <td>Se comunica oralmente en inglés como lengua extranjera.</td>
                          <td><b>{{$ingles[0]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td rowspan="3"></td>
                        </tr>
                        <tr>
                          <td>Lee diversos tipos de textos escritos en ingles como lengua extranjera.</td>
                          <td><b>{{$ingles[1]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Escribe diversos tipos de textos escritos en inglés como lengua extranjera.</td>
                          <td><b>{{$ingles[2]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                        @else
                        <tr>
                            <th rowspan="3" class="t5" >Inglés como lengua extranjera</th>
                            <td>Se comunica oralmente en inglés como lengua extranjera.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="3"></td>
                          </tr>
                          <tr>
                            <td>Lee diversos tipos de textos escritos en ingles como lengua extranjera.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Escribe diversos tipos de textos escritos en inglés como lengua extranjera.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                        @endif                   
                        <!--Curso 9-->
                        {{-- condicional de matematica --}}
                        @if(count($matematica)!=0)
                        <tr>
                            <th rowspan="4" class="t5" style=" vertical-align:middle; font-size:14px;">Matemática</th>
                            <td>Resuelve problemas de cantidad.</td>
                            <td><b>{{$matematica[0]['calificacion']}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="4"></td>
                          </tr>
                          <tr>
                            <td>Resuelve problemas de regularidad, equivalencia y cambio.</td>
                            <td><b>{{$matematica[1]['calificacion']}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Resuelve problemas de forma, movimiento y localización.</td>
                            <td><b>{{$matematica[2]['calificacion']}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                              <td>Resuelve problemas de gestión de datos e incertidumbre.</td>
                              <td><b>{{$matematica[3]['calificacion']}}</b></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          
                        @else
                        <tr>
                            <th rowspan="4" class="t5">Matemática</th>
                            <td>Resuelve problemas de cantidad.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="4"></td>
                          </tr>
                          <tr>
                            <td>Resuelve problemas de regularidad, equivalencia y cambio.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Resuelve problemas de forma, movimiento y localización.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                              <td>Resuelve problemas de gestión de datos e incertidumbre.</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          
                        @endif
                        
                        <!--Curso 10-->
                        {{-- condicional de cta --}}
                        @if(count($cta)!=0)
                        <tr>
                          <th rowspan="3" class="t5" style=" vertical-align:middle; font-size:14px;">Ciencia y Tecnología</th>
                          <td>Indaga mediante métodos científicos para construir sus conocimientos.</td>
                          <td><b>{{$cta[0]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td rowspan="3"></td>
                        </tr>
                        <tr>
                          <td>Explica el mundo físico basándose en conocimientos sobre los seres vivos, materia y energía, biodiversidad, Tierra y universo.</td>
                          <td><b>{{$cta[1]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Diseña y construye soluciones tecnológicas para resolver problemas de su entorno.</td>
                          <td><b>{{$cta[2]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                        @else
                        <tr>
                            <th rowspan="3" class="t5">Ciencia y Tecnología</th>
                            <td>Indaga mediante métodos científicos para construir sus conocimientos.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="3"></td>
                          </tr>
                          <tr>
                            <td>Explica el mundo físico basándose en conocimientos sobre los seres vivos, materia y energía, biodiversidad, Tierra y universo.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Diseña y construye soluciones tecnológicas para resolver problemas de su entorno.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                        @endif
                        {{-- Curso 11 --}}
                        {{-- condicional de religion --}}
                        @if(count($religion)!=0)
                        <tr>
                          <th rowspan="2" class="t5" style=" vertical-align:middle; font-size:14px;">Educación Religiosa</th>
                          <td>Construye su identidad como persona humana, amada por Dios, digna, libre y trascendente, comprendiendo la doctrina de su propia religión, abierto al diálogo con las que le son cercanas.</td>
                          <td><b>{{$religion[0]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td rowspan="2"></td>
                        </tr>
                        <tr>
                          <td>Asume la experiencia del encuentro personal y comunitario con Dios en su proyecto de vida en coherencia con su creencia religiosa.</td>
                          <td><b>{{$religion[1]['calificacion']}}</b></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        
                        @else 
                        <tr>
                            <th rowspan="2" class="t5">Educación Religiosa</th>
                            <td>Construye su identidad como persona humana, amada por Dios, digna, libre y trascendente, comprendiendo la doctrina de su propia religión, abierto al diálogo con las que le son cercanas.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2"></td>
                          </tr>
                          <tr>
                            <td>Asume la experiencia del encuentro personal y comunitario con Dios en su proyecto de vida en coherencia con su creencia religiosa.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          
                        @endif
                        <!--Curso 12-->
                          <tr>
                              <th rowspan="2" class="t5"></th>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td rowspan="2"></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                                                    
                          <!--Curso 13-->
                          <tr>
                            <th rowspan="2" class="t10"></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2"></td>
                          </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                           
                            <!--Curso 14-->
                            {{-- condicional de competencias transversales --}}
                            @if(count($desarrollo)!=0 && count($cienciaSocial)!=0 && count($ept)!=0 && count($ef)!=0 && count($comunicacion)!=0 && count($arte)!=0 && count($ingles)!=0 && count($matematica)!=0 && count($cta)!=0 && count($religion)!=0 && count($actitudinal)!=0 )
                            <tr>
                              <th rowspan="2" class="t5" style=" vertical-align:middle; font-size:14px;">Competencias Transversales</th>
                              <td>Se desenvuelve en entornos virtuales generados por las TIC.</td>
                              <td><b>
                                @php 
                                  $array=array(
                                  $desarrollo[2]['calificacion'],
                                  $cienciaSocial[3]['calificacion'],
                                  $ept[1]['calificacion'],
                                  $ef[3]['calificacion'],
                                  $comunicacion[3]['calificacion'],
                                  $arte[2]['calificacion'],
                                  $ingles[3]['calificacion'],
                                  $matematica[4]['calificacion'],
                                  $cta[3]['calificacion'],
                                  $religion[2]['calificacion']);
                                  $ct=array_count_values($array);
                                  arsort($ct);
                                @endphp
                                {{
                                  $ct1=key($ct)
                                }}
                              </b></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td rowspan="2"></td>
                            </tr>
                            
                            <tr>
                              <td>Gestiona su aprendizaje de manera autónoma.</td>
                              <td><b>
                                @php 
                                  $array=array(
                                    $desarrollo[3]['calificacion'],
                                    $cienciaSocial[4]['calificacion'],
                                    $ept[2]['calificacion'],
                                    $ef[4]['calificacion'],
                                    $comunicacion[4]['calificacion'],
                                    $arte[3]['calificacion'],
                                    $ingles[4]['calificacion'],
                                    $matematica[5]['calificacion'],
                                    $cta[4]['calificacion'],
                                    $religion[3]['calificacion']);
                                  $ct3=array_count_values($array);
                                  arsort($ct3);
                                @endphp
                                {{
                                  $ct2=key($ct3)
                                }}
                                
                              </b> </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            @elseif (count($desarrollo)!=0 && count($cienciaSocial)!=0 && count($ept)!=0 && count($ef)!=0 && count($comunicacion)!=0 && count($arte)!=0 && count($ingles)!=0 && count($matematica)!=0 && count($cta)!=0 && $religion[3]['calificacion']=='EXO' && count($actitudinal)!=0)
                            <tr>
                              <th rowspan="2" class="t5" style=" vertical-align:middle; font-size:14px;">Competencias Transversales</th>
                              <td>Se desenvuelve en entornos virtuales generados por las TIC.</td>
                              <td><b>
                                @php 
                                  $array=array(
                                  $desarrollo[2]['calificacion'],
                                  $cienciaSocial[3]['calificacion'],
                                  $ept[1]['calificacion'],
                                  $ef[3]['calificacion'],
                                  $comunicacion[3]['calificacion'],
                                  $arte[2]['calificacion'],
                                  $ingles[3]['calificacion'],
                                  $matematica[4]['calificacion'],
                                  $cta[3]['calificacion']);
                                  $ct=array_count_values($array);
                                  arsort($ct);
                                @endphp
                                {{
                                  $ct1=key($ct)
                                }}
                              </b></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td rowspan="2"></td>
                            </tr>
                            
                            <tr>
                              <td>Gestiona su aprendizaje de manera autónoma.</td>
                              <td><b>
                                @php 
                                  $array=array(
                                    $desarrollo[3]['calificacion'],
                                    $cienciaSocial[4]['calificacion'],
                                    $ept[2]['calificacion'],
                                    $ef[4]['calificacion'],
                                    $comunicacion[4]['calificacion'],
                                    $arte[3]['calificacion'],
                                    $ingles[4]['calificacion'],
                                    $matematica[5]['calificacion'],
                                    $cta[4]['calificacion']);
                                  $ct3=array_count_values($array);
                                  arsort($ct3);
                                @endphp
                                {{
                                  $ct2=key($ct3)
                                }}
                                
                              </b> </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            @else 
                            <tr>
                                <th rowspan="2" class="t5">Competencias Transversales</th>
                                <td>Se desenvuelve en entornos virtuales generados por las TIC.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td rowspan="2"></td>
                              </tr>
                              
                              <tr>
                                <td>Gestiona su aprendizaje de manera autónoma.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                        
                            @endif
                          <!--Curso 14-->
                          {{-- condicional de actitudinal --}}
                          @if(count($actitudinal)!=0)
                          <tr>
                            <th style=" vertical-align:middle; font-size:14px;">Calificativo Actitudinal</th>
                            <td>Actitudes Observables</td>                 
                            <td><b>{{$actitudinal[0]['calificacion']}}
                            </b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        @else 
                        <tr>
                          <th>Actitudinal Calificativo</th>
                          <td>Actitudinal</td>                 
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        @endif        
                </tbody>
                </table>
                <table class="table table-bordered table-striped table-sm">
                        <tr>
                            <td class="periodo">Periodo</td>
                            <td class="concl">Conclusión descriptiva por periodo</td>
                            <td class="sign">FIRMA</td>
                        </tr>
                        <tr>
                            <td class="num">1</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">2</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">3</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">4</td>
                            <td></td>
                            <td></td>
                        </tr>                            
                    </table>
                    <table class="table table-bordered table-striped table-sm ">
                        <tr>
                            <td rowspan="2" class="periodo2">Periodo</td>
                            <td colspan="2" class="inas">Inasistencias</td>
                            <td colspan="2" class="tard">Tardanzas</td>
                        </tr>
                        <tr>
                            <td class="inas">Justificadas</td>
                            <td class="inas">Injustificadas</td>
                            <td class="tard">Justificadas</td>
                            <td class="tard">Injustificadas</td>
                        </tr>
                        <tr>
                            <td class="num">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="num">4</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>                            
                    </table>
                    <div class="firma">
                      <div class="director">
                        <hr class="d">
                        <p>Firma y sello del Director(a)</p>
                      </div>
                      <div class="tutor">
                        <hr>
                        <p>Firma y sello del Docente o Tutor(a)</p>
                      </div>
            
                    </div>
            </div>
    </div>
    
</body>
</html>