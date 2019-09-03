import { mount, createLocalVue } from '@vue/test-utils';
import Component from '../../components/blog/Edit'; // name of your Vue component
import BootstrapVue from 'bootstrap-vue';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('BlogEdit vue test.', () => {
	let mock = new MockAdapter(axios);
	let wrapper;

	const localVue = createLocalVue();
	localVue.use(BootstrapVue);

	const storeBlog = jest.fn();
	const blogList = jest.fn();
	const updateBlog = jest.fn();
	let blogId = '5d5f7075c28a4cdd250e74d4';

	const $route = {
		query: {
			blogId: blogId,
		},
	};

	beforeEach(() => {
		wrapper = mount(Component, {
			localVue,
			methods: {
				getBlog,
				storeBlog,
				blogList,
				updateBlog,
			},
			mocks: {
				$route,
			},
		});

		mock.onGet('/blog/show/' + blogId).reply(200, {
			response: [
				{
					_id: blogId,
					name: 'admin create a blog',
					desc: 'admin create a blog',
					user_id: 1,
					is_released: 1,
					updated_at: '2019-08-23 16:49:57',
					created_at: '2019-08-23 16:49:57',
					createrName: 'Admin',
				},
			],
		});
	});

	afterEach(() => {
		wrapper.destroy();
	});

	it('Access blog page it will at least see the following text', () => {
		wrapper.setData({
			blogId: blogId,
		});

		expect(wrapper.text()).not.toMatch(/Submit/);
		expect(wrapper.text()).toMatch(/Go back/);
		expect(wrapper.text()).toMatch(/Blog name/);
		expect(wrapper.text()).toMatch(/Blog content/);
	});

	it('Click Submit button', () => {
		wrapper.setData({
			blogId: undefined,
		});

		wrapper
			.find('.btn-primary')
			.find('button')
			.trigger('click');

		expect(wrapper.text()).toMatch(/Submit/);
		expect(storeBlog).toHaveBeenCalled();
		expect(storeBlog).toHaveBeenCalledTimes(1);
	});

	it('Click Update button', () => {
		wrapper.setData({
			blogId: blogId,
			edit: true,
		});

		wrapper
			.find('.btn-primary')
			.find('button')
			.trigger('click');

		expect(wrapper.text()).toMatch(/Update/);
		expect(updateBlog).toHaveBeenCalled();
		expect(updateBlog).toHaveBeenCalledTimes(1);
	});

	it('Click GoBack button', () => {
		wrapper
			.find('.btn-success')
			.find('button')
			.trigger('click');

		expect(blogList).toHaveBeenCalled();
		expect(blogList).toHaveBeenCalledTimes(1);
	});

	let getBlog = () => {
		axios
			.get('/blog/show/' + blogId)
			.then(res => {
				wrapper.vm.blogs = res.data.response;
				wrapper.vm.form.name = wrapper.vm.blogs.name;
				wrapper.vm.form.desc = wrapper.vm.blogs.desc;
			})
			.catch(error => {
				console.log(error);
			});
	};
});
