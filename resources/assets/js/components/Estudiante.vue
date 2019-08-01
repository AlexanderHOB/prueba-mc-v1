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
                        <i class="fa fa-align-justify"></i> Estudiante
                       
                    </div>
                    <div class="card-body table-responsive-lg">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombres">Nombres</option>
                                      <option value="dni">Dni</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEstudiante(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary" @click="listarEstudiante(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="150px">Opciones</th>
                                        <th>Dni</th>
                                        <th>Nombres</th>
                                        <th>Seccion</th>
                                        <th>Grado</th>
                                        <th width="100px">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="estudiante in arrayEstudiante" :key="estudiante.id">
                                        <td>
                                            <button type="button" @click="cargarPdf(estudiante.id)" class="btn btn-info">
                                                <i class="icon-doc"></i>&nbsp;Reporte
                                            </button>
                                            <template v-if="estudiante.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEstudiante(estudiante.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarEstudiante(estudiante.id)">
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="estudiante.dni"></td>
                                        <td v-text="estudiante.nombres"></td>
                                        <td v-text="estudiante.seccion"></td>
                                        <td v-text="estudiante.grado"></td>
                                        <template v-if="estudiante.estado">
                                            <td><span class="badge badge-success">Activo</span></td>
                                        </template>
                                        <template v-else>
                                            <td><span class="badge badge-danger" >Desactivado</span></td>
                                        </template>

                                
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
            </div>
           
        </main>
</template>

<script>
    export default {
        props:['ruta'],        
        data(){
            return{
                estudiante_id:0,
                nombre:'',
                nombres:'',
                codigo:'',
                dni:'',
                seccion:'',
                grado:'',
                arrayEstudiante:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorEstudiante:0,
                errorMostrarMsjEstudiante:[],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio:'nombres',
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
             cargarPdf(idestudiante){
                window.open(this.ruta+'/estudiante/listarboleta?idestudiante='+idestudiante ,'_blank');
            },
            listarEstudiante(page,buscar,criterio){
                let me=this;
                var url=this.ruta+'/estudiante/show?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
            desactivarEstudiante(id){
               swal({
                title: 'Esta seguro de desactivar este Estudiante?',
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

                    axios.put(this.ruta + '/estudiante/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEstudiante(1,'','nombres');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
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
            activarEstudiante(id){
               swal({
                title: 'Esta seguro de activar el registro del estudiante?',
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

                    axios.put(this.ruta + '/estudiante/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEstudiante(1,'','nombres');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
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
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEstudiante(page,buscar,criterio);
            },
        },
        mounted() {
            this.listarEstudiante(1,this.buscar,this.criterio);
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
