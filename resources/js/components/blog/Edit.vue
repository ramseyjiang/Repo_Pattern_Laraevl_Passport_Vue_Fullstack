<template>
	<div>
		<b-col sm="12">
			<label>Blog name</label>
		</b-col>
		<b-col sm="12">
			<b-form-input
				v-model="form.name"
				type="text"
				placeholder="Please input your blog name"
				:disabled="!edit"
			>
				{{ form.name }}
			</b-form-input>
		</b-col>
		<b-form-row>
			<b-col sm="2" v-show="blogId !== undefined"> &nbsp; &nbsp; Creater: {{ blogs.createrName }} </b-col>
			<b-col sm="3" v-show="blogId !== undefined"> Create time: {{ blogs.created_at }} </b-col>
			<b-col sm="3" v-show="blogId !== undefined"> Update time: {{ blogs.updated_at }} </b-col>
		</b-form-row>
		<b-col sm="12">
			<label>Blog content</label>
		</b-col>
		<b-col sm="12">
			<b-form-textarea
				v-model="form.desc"
				placeholder="Please input your blog content"
				rows="8"
				:disabled="!edit"
			>
				{{ form.desc }}
			</b-form-textarea>
		</b-col>
		<b-col lg="12" class="my-1">
			<b-button
				v-if="blogId === undefined"
				@click="storeBlog()"
				variant="primary"
				plain
			>
				Submit
			</b-button>

			<b-button @click="blogList()" variant="success" plain>
				Go back
			</b-button>

			<b-button
				v-if="blogId !== undefined && edit == true"
				@click="updateBlog()"
				variant="primary"
				plain
			>
				Update
			</b-button>
		</b-col>
	</div>
</template>
<script>
export default {
	data() {
		return {
			blogId: 0,
			form: {
				name: '',
				desc: '',
			},
			blogs: {},
			edit: false,
		};
	},
	mounted() {
		this.blogId = this.$route.query.blogId;
		this.edit =
			this.$route.path == '/editBlog' ||
			this.$route.path == '/createBlog';
		if (this.blogId !== undefined) {
			this.getBlog();
		}
	},
	methods: {
		getBlog() {
			axios
				.get(baseUrl + '/blogs/show/' + this.blogId)
				.then(response => {
					this.blogs = response.data;
					this.form.name = this.blogs.name;
					this.form.desc = this.blogs.desc;
				})
				.catch(error => {
					console.log(error);
				});
		},
		storeBlog() {
			let data = {
				name: this.form.name,
				desc: this.form.desc,
			};

			axios
				.post(baseUrl + '/blogs/store', data)
				.then(response => {
					this.blogs = response.data;
					this.$router.push('blogs');
				})
				.catch(error => {
					console.log(error);
				});
		},
		blogList() {
			this.$router.push('blogs');
		},
		updateBlog() {
			let data = {
				name: this.form.name,
				desc: this.form.desc,
			};

			axios
				.put(baseUrl + '/blogs/update/' + this.blogId, data)
				.then(response => {
					this.blogs = response.data;
					this.$router.push('blogs');
				})
				.catch(error => {
					console.log(error);
				});
		},
	},
};
</script>
