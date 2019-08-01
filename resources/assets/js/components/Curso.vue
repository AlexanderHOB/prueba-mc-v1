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
                        <i class="fa fa-align-justify"></i> Cursos
                       <button type="button" @click="abrirModal('curso','registrar')" class="btn btn-secondary">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarCurso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary" @click="listarCurso(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="50px">Opciones</th>
                                        <th width="50px">Id</th>
                                        <th>Nombres</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="curso in arrayCurso" :key="curso.id">
                                        <td>
                                            <button type="button" @click="abrirModal('curso','actualizar',curso)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        </td>
                                        <td v-text="curso.id"></td>
                                        <td v-text="curso.nombre"></td>
                                
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
                                    <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Curso">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" placeholder="Descripcion">
                                    </div>
                                </div>
                                <div v-show="errorCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCurso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCurso()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCurso()">Actualizar</button>
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
                curso_id:0,
                nombre:'',
                arrayCurso:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCurso:0,
                errorMostrarMsjCurso:[],
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
            
            listarCurso(page,buscar,criterio){
                let me=this;
                var url=this.ruta+'/curso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayCurso=respuesta.cursos.data;
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
                me.listarCurso(page,buscar,criterio);
            },
            
            registrarCurso(){
                if (this.validarCurso()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta+'/curso/registrar',{
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCurso(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCurso(){
               if (this.validarCurso()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta+'/curso/actualizar',{
                    'nombre': this.nombre,
                    'id': this.curso_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCurso(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            }, 
            validarCurso(){
                this.errorCurso=0;
                this.errorMostrarMsjCurso =[];

                if (this.idcategoria==0) this.errorMostrarMsjCurso.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjCurso.push("El nombre del curso no puede estar vacío.");
                if (this.errorMostrarMsjCurso.length) this.errorCurso = 1;

                return this.errorCurso;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "curso":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Curso';
                                this.nombre='';
                                
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Curso';
                                this.tipoAccion=2;
                                this.curso_id=data['id'];
                                this.nombre=data['nombre'];
                                break;
                            }
                        }
                    }
                }
            },
        
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre = '';
		        this.errorCurso=0;
            },
            
        },

        mounted() {
            this.listarCurso(1,this.buscar,this.criterio);
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
