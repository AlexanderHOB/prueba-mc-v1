<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card ">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Registro de Notas
                       <button type="button" @click="abrirModal('estudiante','buscar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Buscar
                        </button>
                    </div>
                    <div class="card-body table-responsive-lg">
                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="col-md-3">
                                        <p> <b> Docente: </b> {{profesor}}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p> <b>Asignatura: </b> {{nombreCurso}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p> <b>Grado: </b> {{grado}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p> <b>Seccion: </b> {{seccion}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p>Bimestre</p>
                                        <select v-model="bimestre" disabled>
                                            <option selected>Segundo</option>
                                            <option >Primer</option>
                                            <option>Tercer</option>
                                            <option>Cuarto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-sm">
                                <thead>
                                    <tr>
                                        <th>Dni</th>
                                        <th class="columna-nombre">Estudiantes</th>
                                        <th class="columna" v-for="competencia in arrayCompetencia" :key="competencia.id" v-text="competencia.nombre"></th>
                                        <th>Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="estudiante in arrayEstudiante" :key="estudiante.id" >
                                    
                                        <td v-text="estudiante.dni"></td>
                                        <td v-text="estudiante.nombres"></td>
                                        <td v-for="(nota,index) in estudiante.nota" :key="nota.id">
                                            <span style="color:red;" v-show="estudiante.nota[index]>20 ||estudiante.nota[index]<0">Nota Incorrecta</span>
                                            <input type="number" min="0" max="20" class="form-control input-sm inputWidth" step="any"   v-model.number="estudiante.nota[index]" >
                                        </td>
                                        <template v-if="arrayCompetencia.length==1">                                                                                            
                                            <td>
                                            {{estudiante.promedio=estudiante.nota.nota0}}
                                            </td>
                                        </template>                                           
                                        <template v-if="arrayCompetencia.length==3">                                         
                                            <td>
                                            {{estudiante.promedio=estudiante.nota.nota0}}
                                            </td>
                                        </template>
                                        <template v-if="arrayCompetencia.length==4">
                                            
                                            <td>
                                            {{estudiante.promedio=((estudiante.nota.nota0+estudiante.nota.nota1)/2).toFixed(1)}}
                                            </td>
                                        </template>
                                        <template v-if="arrayCompetencia.length==5">
                                            
                                            <td>
                                            {{estudiante.promedio=((estudiante.nota.nota0+estudiante.nota.nota1+estudiante.nota.nota2)/3).toFixed(1)}}
                                            </td>
                                        </template>
                                        <template v-if="arrayCompetencia.length==6">
                                        
                                            <td>
                                            {{estudiante.promedio=((estudiante.nota.nota0+estudiante.nota.nota1+estudiante.nota.nota2+estudiante.nota.nota3)/4).toFixed(1)}}
                                            </td>
                                        </template> 
                                        
                                        <div class="ocultar">
                                            {{estudiante.idcurso=idcurso}}
                                            {{estudiante.idprofesor=idprofesor}}
                                            {{estudiante.bimestre=bimestre}}
                                            {{estudiante.competencia=competencia}}
                                        </div>

                                    </tr>
                                    
                                    
                                </tbody>
                            </table>
                            <div v-show="errorNota" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjNota" :key="error.id" v-text="error">

                                        </div>
                                    </div>
                                </div>
                        </div>  
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarNota() ">Guardar Notas</button>
                            
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title " v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Grado (*)</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idsalonprofesorcurso">
                                            <option value="0" disabled >Seleccione</option>
                                            <option v-for="salon in arraySalon" :key="salon.id" :value="salon.id" v-text="'Grado: '+ salon.grado +' | Seccion: '+ salon.seccion+' | Curso: '+salon.nombreCurso">
                                                
                                            </option>
                                        </select>                                        
                                    </div>
                                </div>
        
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="getIdCurso(idsalonprofesorcurso,'id') ">BUSCAR</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCompetencia()">GRACIAS</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                
            </div>
            <!--Fin del modal-->
             <!--Inicio del modal registros enviados-->
            <div class="modal fade modal-height" tabindex="-1" :class="{'mostrar' : completado}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title " v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="jumbotron alert alert-success">
                                <div class="container ">
                                    <h2> <span class="badge badge-success">   DOCENTE: </span>{{profesor}}</h2>
                                    <h3> LOS DATOS FUERON ENVIADOS CORRECTAMENTE! 😊👍 </h3>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                
            </div>
            </div>
           
        </main>
</template>

<script>
    export default {
        props:['ruta'],

        data(){
            return{
                idestudiante:0,
                idsalonprofesorcurso:0,
                idsalon:0,
                grado:'',
                seccion:'',
                idprofesor:0,
                profesor:'',
                idcurso:0,
                nombreCurso:'',
                idcompetencia:0,
                arraygetSalon:[],
                arraySalon:[],
                arrayNota:[],
                arrayCompetencia:[],
                arrayEstudiante:[],
                modal:1,
                completado:0,
                tituloModal:'Buscar Salon, Grado y Curso',
                tipoAccion:1,
                errorNota:0,
                errorMostrarMsjNota:[],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio:'nombre',
                buscar:'',
                calificacion:0,
                competencia:[ ],
                bimestre:'Segundo',
                uploadPercentage:0,
            }
        },

        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods:{
            calcularPromedio: function(array){
                var resultado=0.0;
                let len=array.length-2;
                for(var i=0;i<len;i++){
                    resultado=resultado+(array['nota'+i]);
                    console.log(resultado);
                }
                resultado=(resultado/len).toFixed(1);
                return resultado;
            },
            listarEstudiante(page,buscar,criterio){
                let me=this;
                var url=this.ruta+'/estudiante?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayEstudiante=respuesta.estudiantes.data;
                    me.pagination=respuesta.pagination;
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEstudiante(page,buscar,criterio);
            },
            selectSalones(){
                let me=this;
                var url=this.ruta+'/salonProfesor';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySalon = respuesta.salones;
                    

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getIdCurso(buscar,criterio){
                 if (this.validarNota()){
                    return;
                }
                let me=this;
                me.arrayCompetencia=[];
                var arrayDatos=[];
                var url=this.ruta+'/getSalonProfesor?&buscar='+ buscar + '&criterio='+ criterio;
                // var urlE='/estudiante?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
               
                axios.get(url).then(function (response) {

                    var respuesta=response.data;
                    me.arraygetSalon = respuesta.getsalones;
                    arrayDatos=respuesta.getsalones;
                    me.idcurso=arrayDatos[0]['curso_id'];
                    me.idsalon=arrayDatos[0]['salon_id'];
                    me.idprofesor=arrayDatos[0]['profesor_id'];
                    me.profesor=arrayDatos[0]['nombre'];
                    me.grado=arrayDatos[0]['grado'];
                    me.seccion=arrayDatos[0]['seccion'];
                    me.nombreCurso=arrayDatos[0]['nombreCurso'];


                    
                    me.buscarCompetencia(me.idcurso);
                    me.buscarEstudiantes(1,me.idsalon,'salon_id');
                })        
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                //obtener datos del curso

            },
            buscarCompetencia(buscar){
                let me=this;
                var url=this.ruta+'/competencia/getcompetencia?buscar='+ buscar;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayCompetencia=respuesta.competencias;
                    me.idcompetencia=me.arrayCompetencia[0]['id'];
                    for(let i=0;i<me.arrayCompetencia.length;i++){
                        me.competencia.push(me.arrayCompetencia[i]['id']);

                    }
                    
                })
                
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            buscarEstudiantes(page,buscar,criterio){
                let me=this;
                var url=this.ruta+'/estudiante?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayEstudiante=respuesta.estudiantes.data;
                    me.pagination=respuesta.pagination;
                    //Generar la matriz de notas dentro del arreglo de estudiante
                    for(let i=0;i<me.arrayEstudiante.length;i++){
                     me.arrayEstudiante[i]['nota']={};

                        for(let j=0;j<me.arrayCompetencia.length;j++){
                            me.arrayEstudiante[i]['nota']['nota'+j]=0;
                        }
                        
                    }
                    me.agregarDetalle(me.arrayEstudiante);
                    me.cerrarModal();

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            agregarDetalle(data=[]){
                let me =this;
                me.arrayNota.push({
            
                    idestudiante:me.idestudiante,
                    curso_id:me.idcurso,
                    calificacion:me.calificacion,
                    
                })
            },
             
            registrarNota(){
                if (this.validarNota()){
                    return;
                }
                swal({
                title: 'Atención! Los datos enviados no se podrán modificar',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    
                    axios.post(this.ruta+'/nota/registrar',{
                    'data':me.arrayEstudiante
                    },{
                    onUploadProgress: function( progressEvent ) {
                    this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                     console.log(this.uploadPercentage);
                     }.bind(this)
                     }
                     )
                    .then(function (response) {
                        console.log('Success');

                        swal(
                            'Enviado!',
                            'El registro ha sido activado con éxito.',
                            'success'
                        
                        );
                        
                        me.abrirModal('estudiante','exito');
                        // me.buscarEstudiantes(1,1000,'salon_id');

                    }).catch(error => {
                        console.log(error.response)
                    }); 

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelado',
                        'El registro no fue enviado',
                        'error'
                        )
                }
                })
                
            },
            
             validarNota(){
                this.errorNota=0;
                this.errorMostrarMsjNota =[];

                if (this.idsalonprofesorcurso==0) this.errorMostrarMsjNota.push("Seleccione una opción.");
                for(let i=0; i<this.arrayEstudiante.length;i++){
                    for(let j=0;j<this.arrayCompetencia.length;j++){
                        if(this.arrayEstudiante[i]['nota']['nota'+j]>20||this.arrayEstudiante[i]['nota']['nota'+i]<0) this.errorMostrarMsjNota.push("Inserte Nota correcta en el registro Nº: "+(i+1) + " Competencia Nº: "+(j+1));
                    }
                }
                if (this.errorMostrarMsjNota.length) this.errorNota = 1;

                return this.errorNota;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "estudiante":
                    {
                        switch(accion){
                            case 'buscar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Buscar Registro por Grado Seccion y Nombre';
                                
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'exito':
                            {
                                //console.log(data);
                                this.completado=1;
                                this.tipoAccion=2;
                                this.arrayCompetencia=[];
                                this.arrayEstudiante=[];
                                this.competencia=[];
                                break;
                            }
                        }
                    }
                }
                this.selectSalones();
            },
        
            cerrarModal(){
                this.completado=0;
                this.modal=0;
                this.tituloModal='';
                this.nombre = '';
		        this.errorNota=0;
                this.uploadPercentage=0;
            },
            
        },
        mounted() {
            this.selectSalones();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        top:0;
        position:fixed !important;
    }
    .mostrar{
        display:list-item !important;
        opacity: 1 !important;
        top:0;
        position:fixed !important;
        background-color: #3c29297a !important;

    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color:red !important;
        font-weight: bold;
    }
    .ocultar{
        display:none;
    }
    .inputWidth{
        width: 100%;
        border: 1.2px solid #262626;
    }
    .columna{
        width: 10%;
    }
    .columna-nombre{
        width: 35%;
    }
    .modal-height{
        height: 250vh;
    }
</style>
