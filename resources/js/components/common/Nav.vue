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
					<li class="nav-item" v-show="userId == 0">
						<router-link class="nav-link" :to="{ name: 'login' }">
							Login
						</router-link>
					</li>
					<li class="nav-item" v-show="userId == 0">
						<router-link
							class="nav-link"
							:to="{ name: 'register' }"
						>
							Register
						</router-link>
					</li>
					<li class="nav-item dropdown" v-show="userId">
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
	created() {
		if (user) {
			this.userId = user.id;
			this.userName = user.name;
		}
	},
	methods: {
		logout() {
			axios.post(baseUrl + '/logout').then(res => {
				localStorage.removeItem('access_token');
				// If use this.$router.push('/'); it needs to use transfer data between components.
				location.href = '/';
			});
		},
	},
};
</script>
