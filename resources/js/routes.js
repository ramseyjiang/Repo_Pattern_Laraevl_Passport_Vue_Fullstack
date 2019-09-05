import Vue from 'vue';

//pages
import Nav from './components/common/Nav.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import Dashboard from './components/common/Dashboard.vue';
import BlogList from './components/blog/List.vue';
import BlogEdit from './components/blog/Edit.vue';

Vue.component('Nav', Nav);
Vue.component('Register', Register);
Vue.component('Login', Login);
Vue.component('Dashboard', Dashboard);
Vue.component('BlogList', BlogList);
Vue.component('BlogEdit', BlogEdit);

// Routes
export default [
	{ path: '/', name: '/', component: BlogList, props: false },
	{ path: '/login', name: 'login', component: Login, props: false },
	{ path: '/register', name: 'register', component: Register, props: false },
	{ path: '/dash', name: 'dash', component: Dashboard, props: false },
	{ path: '/blogs', name: 'blogs', component: BlogList, props: false },
	{ path: '/addBlog', name: 'addBlog', component: BlogEdit, props: false },
	{ path: '/editBlog', name: 'editBlog', component: BlogEdit, props: false },
	{ path: '/viewBlog', name: 'viewBlog', component: BlogEdit, props: false },
	{ path: '*', redirect: { name: '/' } },
];
