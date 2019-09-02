<template>
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					Login
				</div>

				<div class="card-body">
					<form @submit.prevent="login">
						<div class="form-group row">
							<label
								for="username"
								class="col-sm-4 col-form-label text-md-right"
							>
								Username
							</label>

							<div class="col-md-6">
								<input
									type="text"
									class="form-control"
									:class="{ 'is-invalid': invalids.username }"
									name="username"
									placeholder="Please input username or email"
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
								for="password"
								class="col-md-4 col-form-label text-md-right"
							>
								Password
							</label>

							<div class="col-md-6">
								<input
									type="password"
									class="form-control"
									:class="{ 'is-invalid': invalids.password }"
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

						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
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

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button @click="login" class="btn btn-primary">
									Login
								</button>
								<a class="btn btn-link" href="">
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
		login() {
			axios
				.post(baseUrl + '/login', this.form)
				.then(res => {
					localStorage.access_token = res.data.access_token;
					location.href = 'dashboard'; //this.$router.push('dashboard');
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
		},
	},
};
</script>
