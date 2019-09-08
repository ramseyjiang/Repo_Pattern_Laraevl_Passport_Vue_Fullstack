<template>
	<nav class="navbar navbar-expand-md navbar-light bg-light">
		<div class="container">
			<router-link class="navbar-brand" :to="{ name: '/' }">
				Laravel+Vue SAP
			</router-link>
			<button
				class="navbar-toggler"
				type="button"
				data-toggle="collapse"
				data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent"
				aria-expanded="false"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto">
					<li class="nav-item" v-if="!isLoggedIn">
						<router-link class="nav-link" :to="{ name: 'login' }">
							Login
						</router-link>
					</li>
					<li class="nav-item" v-if="!isLoggedIn">
						<router-link
							class="nav-link"
							:to="{ name: 'register' }"
						>
							Register
						</router-link>
					</li>
					<li class="nav-item dropdown" v-if="isLoggedIn">
						<a
							id="navbarDropdown"
							class="nav-link dropdown-toggle"
							role="button"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="false"
						>
							{{ userName }}<span class="caret"></span>
						</a>

						<div
							class="dropdown-menu dropdown-menu-right"
							aria-labelledby="navbarDropdown"
						>
							<a class="dropdown-item" @click="logout()">
								Logout
							</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</template>

<script>
export default {
	data() {
		return {
			userId: 0,
			userName: '',
		};
	},
	mounted() {
		//It is used to display user login status after refresh.
		this.getUserInfo();

		//The bus is used to trigger the isLoggedIn() after a user login or register.
		this.$bus.$on('login', () => {
			this.getUserInfo();
		});
	},
	computed: {
		//It is used to check login display on the nav or the guest display on the nav
		isLoggedIn() {
			return this.userId;
		},
	},
	methods: {
		getUserInfo() {
			var user = JSON.parse(localStorage.getItem('user'));
			this.userId = user !== null ? user.id : 0;
			this.userName = user !== null ? user.name : null;
		},
		logout() {
			axios.get(baseUrl + '/api/logout').then(res => {
				localStorage.removeItem('user');
				localStorage.removeItem('access_token');
				this.getUserInfo();

				//It is used to control some buttons not display after logout.
				this.$bus.$emit('login');
				this.$router.push('/');
			});
		},
	},
};
</script>
