
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery'); 

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('estudiante', require('./components/Estudiante.vue'));
Vue.component('curso', require('./components/Curso.vue'));
Vue.component('docente', require('./components/Docente.vue'));
Vue.component('competencia', require('./components/Competencia.vue'));
Vue.component('nota', require('./components/Nota.vue'));
Vue.component('notaprimero', require('./components/NotaPrimero.vue'));
Vue.component('notaactitudinal', require('./components/NotaActitudinal.vue'));

Vue.component('registro', require('./components/Registro.vue'));
Vue.component('registroprimero', require('./components/RegistroPrimero.vue'));
Vue.component('registroactitudinal', require('./components/RegistroActitudinal.vue'));
Vue.component('registroadminprimero', require('./components/RegistroAdminPrimero.vue'));

Vue.component('registroadmin', require('./components/RegistroAdmin.vue'));

Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('ayuda', require('./components/Ayuda.vue'));
Vue.component('acerca', require('./components/Acerca.vue'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        ruta: ''
        // ruta:''
    }        
});
