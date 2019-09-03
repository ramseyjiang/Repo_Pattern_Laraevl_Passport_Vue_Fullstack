import { mount, createLocalVue } from '@vue/test-utils';
import Component from '../../components/blog/List'; // name of your Vue component
import BootstrapVue from 'bootstrap-vue';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('BlogList vue test.', () => {
	let mock = new MockAdapter(axios);
	window.user = { id: 0 }; //define a global user variable

	const localVue = createLocalVue();
	localVue.use(BootstrapVue);

	let wrapper;
	const createBlog = jest.fn();
	const editBlog = jest.fn();
	const viewBlog = jest.fn();
	const deleteBlog = jest.fn();

	beforeEach(() => {
		wrapper = mount(Component, {
			localVue,
			methods: {
				getBlogs,
				createBlog,
				editBlog,
				viewBlog,
				deleteBlog,
			},
		});

		mock.onGet('/blogs/index').reply(200, {
			response: [
				{
					_id: '5d5f7075c28a4cdd250e74d4',
					name: 'admin create a blog',
					desc: 'admin create a blog',
					user_id: 1,
					is_released: 1,
					updated_at: '2019-08-23 16:49:57',
					created_at: '2019-08-23 16:49:57',
					createrName: 'Admin',
				},
				{
					_id: '5d5f6ab0c28a4cdd250e74d3',
					name: 'test create a blog',
					desc: 'test create a blog',
					user_id: 11,
					is_released: 1,
					updated_at: '2019-08-23 16:25:20',
					created_at: '2019-08-23 16:25:20',
					createrName: 'Test',
				},
				{
					_id: '5d5b2290c28a4cff6e7a4df5',
					name: '66666',
					desc: '66666',
					user_id: 1,
					is_released: 1,
					updated_at: '2019-08-20 10:28:32',
					created_at: '2019-08-20 10:28:32',
					createrName: 'Admin',
				},
			],
		});
	});

	afterEach(() => {
		wrapper.destroy();
	});

	it('Access bloglist page it will at least see the following text', () => {
		expect(wrapper.text()).toMatch(/Clear/);
		expect(wrapper.text()).toMatch(/Filter/);
	});

	it('After a admin user login, it will see all buttons', () => {
		wrapper.setData({
			userId: 1,
		});
		expect(wrapper.find('.btn-primary').text()).toBe('Create a blog');
		expect(wrapper.text()).toMatch(/Create a blog/);
		expect(wrapper.find('.btn-success').text()).toBe('View');
		expect(wrapper.find('.btn-warning').text()).toBe('Edit');
		expect(wrapper.find('.btn-danger').text()).toBe('Delete');
	});

	it('If a user login, it will not see "create a blog" button', () => {
		wrapper.setData({
			userId: 11,
		});
		expect(wrapper.find('.btn-success').text()).toBe('View');
		expect(wrapper.text()).toMatch(/Create a blog/);
		expect(wrapper.text()).toMatch(/Edit/);
		expect(wrapper.text()).toMatch(/Delete/);
	});

	it('If a user not login, it will not see "create a blog" button', () => {
		wrapper.setData({
			userId: 0,
		});
		expect(wrapper.find('.btn-success').text()).toBe('View');
		expect(wrapper.text()).not.toMatch(/Create a blog/);
		expect(wrapper.text()).not.toMatch(/Edit/);
		expect(wrapper.text()).not.toMatch(/Delete/);
	});

	it('Click create a blog button', () => {
		wrapper.setData({
			userId: 1,
		});

		wrapper
			.find('.btn-primary')
			.find('button')
			.trigger('click');

		expect(createBlog).toHaveBeenCalled();
		expect(createBlog).toHaveBeenCalledTimes(1);
	});

	it('Click view button', () => {
		wrapper.setData({
			userId: 1,
		});

		wrapper
			.find('.btn-success')
			.find('button')
			.trigger('click');

		expect(viewBlog).toHaveBeenCalled();
		expect(viewBlog).toHaveBeenCalledTimes(1);
	});

	it('Click edit button', () => {
		wrapper.setData({
			userId: 1,
		});

		wrapper
			.find('.btn-warning')
			.find('button')
			.trigger('click');

		expect(editBlog).toHaveBeenCalled();
		expect(editBlog).toHaveBeenCalledTimes(1);
	});

	it('Click delete button', () => {
		wrapper.setData({
			userId: 1,
		});

		wrapper
			.find('.btn-danger')
			.find('button')
			.trigger('click');

		expect(deleteBlog).toHaveBeenCalled();
		expect(deleteBlog).toHaveBeenCalledTimes(1);
	});

	let getBlogs = () => {
		axios
			.get('/blogs/index')
			.then(res => {
				expect(res.status).toBe(200);
				wrapper.vm.blogs = res.data.response;
				wrapper.vm.totalRows = wrapper.vm.blogs.length; // Set the initial number of blogs
			})
			.catch(error => {
				console.log(error);
			});
	};
});
