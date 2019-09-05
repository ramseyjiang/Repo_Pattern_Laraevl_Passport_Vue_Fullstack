/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import style
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

//import js and vue components
import './bootstrap';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import VueRouter from 'vue-router';
import routes from './routes';
import Index from './Index';

//Set site url globally
window.baseUrl = `${process.env.MIX_APP_URL}`;

// Set Vue globally
window.Vue = Vue;

//define a global EventBus
const EventBus = new Vue();
Object.defineProperties(Vue.prototype, {
	$bus: {
		get: function() {
			return EventBus;
		},
	},
});

//Set axios request headers for api axios requests
axios.defaults.headers.common['Authorization'] =
	`Bearer ` + localStorage.getItem('access_token');

Vue.use(VueRouter);
Vue.use(BootstrapVue);

//load Index
Vue.component('Index', Index);

const router = new VueRouter({
	// base: 'figtest/public/index.php/',	//if deploy it on AWS, this line should config the same with your cloud path.
	history: true,
	mode: 'history',
	fallback: true,
	routes: routes,
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: '#app',
	router: router,
});
