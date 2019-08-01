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
                                        <select v-model="bimestre">
                                            <option >Primer</option>
                                            <option selected>Segundo</option>
                                            <option>Tercer</option>
                                            <option>Cuarto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="200px">Opciones</th>
                                        <th>Dni</th>
                                        <th>Estudiantes</th>
                                        <th v-for="competencia in arrayCompetencia" :key="competencia.id" v-text="competencia.nombre"></th>
                                        <th>Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="estudiante in arrayEstudiante" :key="estudiante.id" >
                                        <td>
                                            <button type="button" @click="cargarPdf(estudiante.id)" class="btn btn-info">
                                                <i class="icon-doc"></i>&nbsp;Reporte
                                            </button>
                                            <button type="button" @click="abrirModal('estudiante','actualizar',estudiante)" class="btn btn-warning">
                                                <i class="icon-pencil"></i>&nbsp;
                                            </button>
                                        </td>
                                        <td v-text="estudiante.dni"></td>
                                        <td v-text="estudiante.nombres"></td>

                                         <td v-for="(competencia,index) in arrayCompetencia" :key="competencia.id">
                                            <p v-text="estudiante.calificacion[index]"></p>
                                        </td>
                                        <td>
                                            {{estudiante.promedio=calcularPromedio(estudiante.calificacion)}}
                                        </td>
                                            
                                            
                                            <div class="ocultar">
                                                {{estudiante.idcurso=idcurso}}
                                                {{estudiante.idprofesor=idprofesor}}
                                                {{estudiante.bimestre=bimestre}}
                                                {{estudiante.competencia=competencia}}
                                            </div>

                                    </tr>
                                    
                                    
                                </tbody>
                            </table>
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
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Bimestre</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="bimestre">
                                            <option >Primer</option>
                                            <option selected>Segundo</option>
                                            <option>Tercer</option>
                                            <option>Cuarto</option>
                                        </select>
                                    </div>
                                </div>
                                
            
                                <div v-show="errorNota" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjNota" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="getIdCurso(idsalonprofesorcurso,'id') ">BUSCAR</button>
                            
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalActualizar}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-4 form-control-label" for="text-input">Nombre (*)</label>
                                    <div class="col-md-8">
                                       <p v-text="actualizar['nombres']" class="form-control"></p>                                  
                                    </div>
                                </div>
                                <div class="form-group row" v-for="(competencia,index) in arrayCompetencia" :key="competencia.id">
                                    <label class="col-md-8 form-control-label" for="text-input">{{competencia['nombre']}}</label>
                                    <input type="number"  class="col-md-3 form-control" v-model="actualizar['notas'][index]"  />
                                </div>
            
                                <div v-show="errorNota" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjNota" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="actualizarNota(idsalonprofesorcurso,'id') ">Actualizar</button>
                            
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
                nota:[],
                competencia:[],
                bimestre:'',
                modalActualizar:0,
                actualizar:{
                    'id':0,
                    'nombres':'',
                    'dni':0,
                    'notas':[],
                    'curso_id':0,
                    'bimestre':'',
                    'competencias':[],
                }
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

            },
            
        },
        methods:{
            cargarPdf(idestudiante){
                window.open(this.ruta+'/estudiante/listarboleta?idestudiante='+idestudiante+'&bimestre='+this.bimestre ,'_blank');
            },
            calcularPromedio: function(array){
                var resultado=0.0;
                let len=array.length-2;
                for(var i=0;i<len;i++){
                    resultado=resultado+(array[i]);
                    
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
                    me.buscarEstudiantes(1,me.idsalon,me.idcurso,me.bimestre);
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
                    me.competencia=[];
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
            buscarEstudiantes(page,buscar,buscar1,bimestre){
                let me=this;
                var url=this.ruta+'/estudiante/nota?page=' + page + '&buscar='+ buscar + '&buscar1='+buscar1+'&bimestre='+bimestre;
                axios.get(url).then(function (response) {
                    var numsplit=me.competencia.length;
                    var respuesta=response.data;
                    me.arrayEstudiante=respuesta.estudiantes.data;
                    me.pagination=respuesta.pagination;
                    for(let i = 0 ; i<me.arrayEstudiante.length;i++){
                        me.arrayEstudiante[i]['calificacion']=me.arrayEstudiante[i]['calificacion'].split(',',numsplit).map(Number);
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
                title: 'Enviar, solo si completaste todo el registro de notas, no se podra modificar luego',
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
                    }).then(function (response) {
                    me.abrirModal('estudiante','exito');
                    }).catch(function (error) {
                    console.log(error);
                    });                                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
                
            },
            actualizarNota(){
                if (this.validarNota()){
                    return;
                }
                swal({
                title: '¿Esta seguro de actualizar estas notas?',
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
                    axios.put(this.ruta+'/nota/actualizar',{
                    'data':me.actualizar
                    }).then(function (response) {
                    me.abrirModal('estudiante','exito');
                    }).catch(function (error) {
                    console.log(error);
                    });                                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
                
            },
             validarNota(){
                this.errorNota=0;
                this.errorMostrarMsjNota =[];

                if (this.idsalonprofesorcurso==0) this.errorMostrarMsjNota.push("Seleccione una opción.");
                for(let i; i<this.arrayEstudiante.length;i++){
                    if(!this.arrayEstudiante[i]['nota']) this.errorMostrarMsjNota.push("Inserte Nota en todo los casilleros");
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
                                this.modal=1;
                                this.tituloModal='Los registros fueron enviados';
                                this.tipoAccion=2;
                                this.competencia_id=data['id'];
                                this.idcurso=data['curso_id'];
                                this.nombre=data['nombre'];
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modalActualizar=1;
                                this.tituloModal='Actualizar Nota';
                                this.actualizar['id']=      data['id'];
                                this.actualizar['nombres']=data['nombres'];
                                for(var i=0;i<data['calificacion'].length;i++){
                                    this.actualizar['notas'][i]=data['calificacion'][i];
                                }
                                this.actualizar['curso_id'] = data['curso_id'];
                                this.actualizar['bimestre'] = data['bimestre'];
                                for(var i=0;i<data['competencia'].length;i++){
                                    this.actualizar['competencias'][i]=data['competencia'][i];
                                }
                                console.log(data);
                                break;
                            }
                        }
                    }
                }
                this.selectSalones();
            },
        
            cerrarModal(){
                this.modal=0;
                this.modalActualizar=0;
                this.tituloModal='';
                // this.competencia_id=0;
                this.nombre = '';
		        this.errorCompetencia=0;
                
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
        position: absolute !important;
    }
    .mostrar{
        display:list-item !important;
        opacity: 1 !important;
        top:0;
        position:fixed !important;
        background-color: #3c29297a !important;
        vertical-align: center;
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
</style>
