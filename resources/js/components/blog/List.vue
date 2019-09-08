<template>
	<b-container fluid>
		<!-- User Interface controls -->
		<b-row>
			<b-col lg="12" class="my-1">
				<b-button
					v-if="isLoggedIn"
					@click="createBlog()"
					variant="primary"
					plain
				>
					Create a blog
				</b-button>
			</b-col>

			<b-col lg="6" class="my-1">
				<b-form-group
					label="Filter"
					label-cols-sm="3"
					label-align-sm="right"
					label-size="sm"
					label-for="sortBySelect"
					class="mb-0"
				>
					<b-input-group size="sm">
						<b-form-input
							v-model="filter"
							placeholder="Type to Search"
						></b-form-input>
						<b-input-group-append>
							<b-button
								:disabled="!filter"
								@click="filter = ''"
								variant="dark"
							>
								Clear
							</b-button>
						</b-input-group-append>
					</b-input-group>
				</b-form-group>
			</b-col>

			<b-col lg="6" class="my-1">
				<b-form-group
					label="Sort"
					label-cols-sm="3"
					label-align-sm="right"
					label-size="sm"
					label-for="sortBySelect"
					class="mb-0"
				>
					<b-input-group size="sm">
						<b-form-select
							v-model="sortBy"
							id="sortBySelect"
							:options="sortOptions"
							class="w-75"
						>
							<option slot="first" value="">
								-- none --
							</option>
						</b-form-select>
						<b-form-select
							v-model="sortDesc"
							size="sm"
							:disabled="!sortBy"
							class="w-25"
						>
							<option :value="false">
								Asc
							</option>
							<option :value="true">
								Desc
							</option>
						</b-form-select>
					</b-input-group>
				</b-form-group>
			</b-col>

			<b-col sm="5" md="6" class="my-1">
				<b-form-group
					label="Per page"
					label-cols-sm="6"
					label-cols-md="4"
					label-cols-lg="3"
					label-align-sm="right"
					label-size="sm"
					label-for="perPageSelect"
					class="mb-0"
				>
					<b-form-select
						v-model="perPage"
						id="perPageSelect"
						size="sm"
						:options="pageOptions"
					></b-form-select>
				</b-form-group>
			</b-col>

			<b-col sm="7" md="6" class="my-1">
				<b-pagination
					v-model="currentPage"
					:total-rows="totalRows"
					:per-page="perPage"
					align="fill"
					size="sm"
					class="my-0"
				></b-pagination>
			</b-col>
		</b-row>

		<!-- Main table element -->
		<b-table
			responsive="sm"
			:items="blogs"
			:fields="fields"
			:current-page="currentPage"
			:per-page="perPage"
			:filter="filter"
			:sort-by.sync="sortBy"
			:sort-desc.sync="sortDesc"
			:sort-direction="sortDirection"
			@filtered="onFiltered"
		>
			<template slot="operations" slot-scope="row">
				<b-button
					size="sm"
					@click="viewBlog(row.item._id)"
					class="mr-1"
					variant="success"
				>
					View
				</b-button>

				<b-button
					size="sm"
					@click="editBlog(row.item._id)"
					class="mr-1"
					variant="warning"
					v-if="isLoggedIn == 1 || isLoggedIn == row.item.user_id"
				>
					Edit
				</b-button>

				<b-button
					size="sm"
					@click="deleteBlog(row.item._id)"
					class="mr-1"
					variant="danger"
					v-if="isLoggedIn == 1 || isLoggedIn == row.item.user_id"
				>
					Delete
				</b-button>
			</template>
		</b-table>
	</b-container>
</template>

<script>
export default {
	data() {
		return {
			isTest: false,
			userId: 0,
			blogs: [],
			fields: [
				{
					key: 'name',
					label: 'Blog Name',
					sortable: true,
					sortDirection: 'desc',
					class: 'text-center',
				},
				{
					key: 'created_at',
					label: 'Created time',
					sortable: true,
					class: 'text-center',
				},
				{
					key: 'updated_at',
					label: 'Updated time',
					sortable: true,
					class: 'text-center',
				},
				{ key: 'operations', label: 'Operations' },
			],
			totalRows: 1,
			currentPage: 1,
			perPage: 5,
			pageOptions: [5, 10, 15],
			sortBy: null,
			sortDesc: false,
			sortDirection: 'asc',
			filter: null,
		};
	},
	mounted() {
		this.getBlogs();

		this.$bus.$on('login', () => {
			console.log(132);
			this.checkUserId();
		});
	},
	computed: {
		sortOptions() {
			// Create an options list from our fields
			return this.fields
				.filter(f => f.sortable)
				.map(f => {
					return { text: f.label, value: f.key };
				});
		},
		isLoggedIn() {
			this.checkUserId();
			return this.userId;
		},
	},
	methods: {
		checkUserId() {
			let user = JSON.parse(localStorage.getItem('user'));
			this.userId = this.isTest
				? this.userId
				: (user !== null ? user.id : 0);
		},
		getBlogs() {
			axios
				.get(baseUrl + '/api/blogs/index')
				.then(response => {
					this.blogs = response.data;
					this.totalRows = this.blogs.length; // Set the initial number of blogs
				})
				.catch(error => {
					console.log(error);
				});
		},
		deleteBlog(id) {
			axios
				.delete(baseUrl + '/api/blogs/delete/' + id)
				.then(response => {
					this.blogs = response.data;
					this.totalRows = this.blogs.length;
				})
				.catch(error => {
					console.log(error);
				});
		},
		onFiltered(filteredItems) {
			// Trigger pagination to update the number of buttons/pages due to filtering
			this.totalRows = filteredItems.length;
			this.currentPage = 1;
		},
		createBlog() {
			this.$router.push('addBlog');
		},
		editBlog(blogId) {
			this.$router.push({ path: '/editBlog', query: { blogId: blogId } });
		},
		viewBlog(blogId) {
			this.$router.push({ path: '/viewBlog', query: { blogId: blogId } });
		},
	},
};
</script>
