<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						Register
					</div>

					<div class="card-body">
						<form @submit.prevent="register">
							<div class="form-group row">
								<label
									for="name"
									class="col-md-4 col-form-label text-md-right"
								>
									Name
								</label>

								<div class="col-md-6">
									<input
										type="text"
										class="form-control"
										name="name"
										placeholder="Please input name"
										:class="{ 'is-invalid': invalids.name }"
										v-model="form.name"
										required
										autofocus
									/>
									<span class="invalid-feedback" role="alert">
										<strong>{{ errors.name }}</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label
									for="username"
									class="col-md-4 col-form-label text-md-right"
								>
									Username
								</label>

								<div class="col-md-6">
									<input
										type="text"
										class="form-control"
										name="username"
										placeholder="Please input username"
										:class="{
											'is-invalid': invalids.username,
										}"
										v-model="form.username"
										required
										autofocus
									/>
									<span class="invalid-feedback" role="alert">
										<strong>{{ errors.username }}</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label
									for="email"
									class="col-md-4 col-form-label text-md-right"
								>
									Email
								</label>
								<div class="col-md-6">
									<input
										type="email"
										class="form-control"
										:class="{
											'is-invalid': invalids.email,
										}"
										name="email"
										placeholder="Please input email"
										v-model="form.email"
										required
									/>
									<span class="invalid-feedback" role="alert">
										<strong>{{ errors.email }}</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label
									for="password"
									class="col-md-4 col-form-label text-md-right"
								>
									Password
								</label>

								<div class="col-md-6">
									<input
										type="password"
										class="form-control"
										:class="{
											'is-invalid': invalids.password,
										}"
										name="password"
										placeholder="Please input password"
										v-model="form.password"
										required
									/>
									<span class="invalid-feedback" role="alert">
										<strong>{{ errors.password }}</strong>
									</span>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button
										@click="register"
										type="button"
										class="btn btn-primary"
									>
										Register
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			form: {
				name: '',
				username: '',
				email: '',
				password: '',
			},
			errors: {
				name: '',
				username: '',
				email: '',
				password: '',
			},
			invalids: {
				name: false,
				username: false,
				email: false,
				password: false,
			},
		};
	},
	methods: {
		clearWarn() {
			this.invalids.username = false;
			this.invalids.password = false;
			this.invalids.email = false;
			this.invalids.name = false;
		},
		register() {
			if (
				this.form.username.length &&
				this.form.email.length &&
				this.form.name.length &&
				this.form.password.length
			) {
				this.clearWarn();
				axios
					.post('/api/register', this.form)
					.then(res => {
						localStorage.setItem(
							'user',
							JSON.stringify(res.data.user),
						);

						localStorage.setItem(
							'access_token',
							res.data.access_token,
						);

						//Set axios request headers for api axios requests
						axios.defaults.headers.common['Authorization'] =
							`Bearer ` + res.data.access_token;

						this.$bus.$emit('login');
						this.$router.push('/blogs');
					})
					.catch(err => {
						if (err.response.data.errors.email) {
							this.errors.email =
								err.response.data.errors.email[0];
							this.invalids.email = true;
						}

						if (err.response.data.errors.name) {
							this.errors.name = err.response.data.errors.name[0];
							this.invalids.name = true;
						}

						if (err.response.data.errors.username) {
							this.errors.username =
								err.response.data.errors.username[0];
							this.invalids.username = true;
						}

						if (err.response.data.errors.password) {
							this.errors.password =
								err.response.data.errors.password[0];
							this.invalids.password = true;
						}
					});
			}
		},
	},
};
</script>
