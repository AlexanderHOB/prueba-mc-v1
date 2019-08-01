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
                        <i class="fa fa-align-justify"></i> Competencia
                       <button type="button" @click="abrirModal('competencia','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body table-responsive-lg">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombres</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCompetencia(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary" @click="listarCompetencia(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th width="80px">Editar</th>
                                        <th>Curso</th>
                                        <th>Competencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(competencias, index) in arrayCompetencia" :key="competencias.id">
                                        <td>{{index+1}}</td>
                                        <td>
                                            <button type="button" @click="abrirModal('competencia','actualizar',competencias)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        </td>
                                        <td v-text="competencias.nombreCurso"></td>
                                        <td v-text="competencias.nombre"></td>

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
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de Competencia(*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Curso (*)</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcurso">
                                            <option value="0" disabled >Seleccione</option>
                                            <option v-for="curso in arrayCurso" :key="curso.id" :value="curso.id" v-text="curso.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                

                                <div v-show="errorCompetencia" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCompetencia" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCompetencia()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCompetencia()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            </div>
           
        </main>
</template>

<script>
    export default {
        props:['ruta'],
        data(){
            return{
                competencia_id:0,
                idcurso:0,
                arrayCurso:[],
                nombre:'',
                arrayCompetencia:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCompetencia:0,
                errorMostrarMsjCompetencia:[],
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
                buscar:''
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
            
            listarCompetencia(page,buscar,criterio){
                let me=this;
                var url=this.ruta+'/competencia?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayCompetencia=respuesta.competencias.data;
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
                me.listarCompetencia(page,buscar,criterio);
            },
            selectCurso(){
                let me=this;
                var url=this.ruta+'/curso/selectCurso';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCurso = respuesta.cursos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarCompetencia(){
                if (this.validarCompetencia()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta+'/competencia/registrar',{
                    'curso_id': this.idcurso,
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCompetencia(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCompetencia(){
               if (this.validarCompetencia()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta+'/competencia/actualizar',{
                    'curso_id': this.idcurso,
                    'nombre': this.nombre,
                    'id': this.competencia_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCompetencia(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
             validarCompetencia(){
                this.errorCompetencia=0;
                this.errorMostrarMsjCompetencia =[];

                if (this.idcurso==0) this.errorMostrarMsjCompetencia.push("Seleccione un Curso.");
                if (!this.nombre) this.errorMostrarMsjCompetencia.push("El nombre del artículo no puede estar vacío.");

                if (this.errorMostrarMsjCompetencia.length) this.errorCompetencia = 1;

                return this.errorCompetencia;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "competencia":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Competencia';
                                this.nombre='';
                                
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Competencia';
                                this.tipoAccion=2;
                                this.competencia_id=data['id'];
                                this.idcurso=data['curso_id'];
                                this.nombre=data['nombre'];
                                break;
                            }
                        }
                    }
                }
                this.selectCurso();
            },
        
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.competencia_id=0;
                this.idcurso=0;
                this.nombre = '';
		        this.errorCompetencia=0;
                
            },
            
        },
        mounted() {
            this.listarCompetencia(1,this.buscar,this.criterio);
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
        position:absolute !important;
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
</style>
