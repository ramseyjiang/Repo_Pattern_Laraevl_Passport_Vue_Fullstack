<template>
	<div class="row justify-content-center">
		<div class="col-md-7">
			<div class="card">
				<div class="card-header">
					Login
				</div>

				<div class="card-body">
					<form @submit.prevent="login">
						<div class="form-group row justify-content-center">
							<div class="col-md-9">
								<label class="has-float-label">
									<input
										type="text"
										class="form-control"
										:class="{
											'is-invalid': invalids.username,
										}"
										name="username"
										placeholder="Please input username or email"
										v-model="form.username"
										required
									/>
									<span for="username">Username/Email</span>
									<div class="invalid-feedback" role="alert">
										<strong>{{ errors.username }}</strong>
									</div>
								</label>
							</div>
						</div>

						<div class="form-group row justify-content-center">
							<div class="col-md-9">
								<label class="has-float-label">
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
									<span for="password">Password</span>
									<div class="invalid-feedback" role="alert">
										<strong>{{ errors.password }}</strong>
									</div>
								</label>
							</div>
						</div>

						<div class="form-group row justify-content-center">
							<div class="col-md-8 offset-md-3">
								<div class="form-check">
									<input
										class="form-check-input"
										type="checkbox"
										name="remember"
										v-model="form.remember"
									/>
									<label
										class="form-check-label"
										for="remember"
									>
										Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row mb-0 justify-content-center">
							<div class="col-md-8 offset-md-3">
								<button
									@click="login"
									type="button"
									class="btn btn-primary"
								>
									Login
								</button>
								<a class="btn btn-link">
									Forgot Your Password?
								</a>
							</div>
						</div>
					</form>
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
				username: '',
				password: '',
				remember: '',
			},
			errors: {
				username: '',
				password: '',
			},
			invalids: {
				username: false,
				password: false,
			},
		};
	},
	methods: {
		clearWarn() {
			this.invalids.username = false;
			this.invalids.password = false;
		},
		login() {
			if (this.form.username.length && this.form.password.length) {
				this.clearWarn();
				axios
					.post(baseUrl + '/api/login', this.form)
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
