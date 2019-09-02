import Vue from 'vue';
import VueRouter from 'vue-router';

//pages
import Nav from './components/common/Nav.vue';
import Register from './components/common/Register.vue';
import Login from './components/common/Login.vue';
import Dashboard from './components/common/Dashboard.vue';

Vue.component('Nav', Nav);
Vue.component('Register', Register);
Vue.component('Login', Login);
Vue.component('Dashboard', Dashboard);

// Routes
const routes = [
	{
		path: '/',
		name: '/',
		component: Login,
		props: false,
	},
	{
		path: '/login',
		name: 'login',
		component: Login,
		props: false,
	},
	{
		path: '/register',
		name: 'register',
		component: Register,
		props: false,
	},
	{
		path: '/dashboard',
		name: 'dashboard',
		component: Dashboard,
		props: false,
	},
];

const router = new VueRouter({
	history: true,
	mode: 'history',
	fallback: true,
	routes,
});

export default router;
