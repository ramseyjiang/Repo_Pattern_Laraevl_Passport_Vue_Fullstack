import { mount, createLocalVue } from '@vue/test-utils';

import Component from '../../components/auth/Register.vue';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('Test Register.vue.', () => {
	const localVue = createLocalVue();
	let mock = new MockAdapter(axios);
	let wrapper;

	beforeEach(() => {
		wrapper = mount(Component, {
			localVue,
			methods: {
				register,
			},
		});
	});

	afterEach(() => {
		wrapper.destroy();
	});

	it('Has card-header and card-body', () => {
		expect(wrapper.contains('.card-header')).toBe(true);
		expect(wrapper.find('.card-header').text()).toMatch(/Register/);
		expect(wrapper.contains('.card-body')).toBe(true);
	});

	it('Has name field', () => {
		expect(wrapper.find('.card-body .form-group label').text()).toMatch(
			/Name/,
		);
		expect(wrapper.find('[name="name"]')).toEqual({});
		expect(wrapper.find('[placeholder="Please input name"]')).toEqual({});
	});

	it('Has username field', () => {
		expect(wrapper.find('[name="username"]')).toEqual({});
		expect(wrapper.find('[placeholder="Please input username"]')).toEqual(
			{},
		);
	});

	it('Has email field', () => {
		expect(wrapper.find('[name="email"]')).toEqual({});
		expect(wrapper.find('[placeholder="Please input email"]')).toEqual({});
	});

	it('Has password field', () => {
		expect(wrapper.find('[name="password"]')).toEqual({});
		expect(wrapper.find('[placeholder="Please input password"]')).toEqual(
			{},
		);
	});

	it('Has register button', () => {
		expect(wrapper.contains('button')).toBe(true);
		expect(wrapper.find('button').text()).toMatch(/Register/);
	});

	it('Has errors(mock request)', () => {
		wrapper.find('button').trigger('click');
		wrapper.setData({
			form: {
				name: '1',
				username: 'q',
				email: 'admin@qq.com',
				password: '1',
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
		});

		mock.onPost('/register', wrapper.vm.form).reply(422, {
			message: 'The given data was invalid.',
			errors: {
				name: ['The name must be at least 2 characters.'],
				username: ['The username must be at least 2 characters.'],
				email: ['The email has already been taken.'],
				password: ['The password must be at least 8 characters.'],
			},
		});
	});

	it('Register success (mock request)', () => {
		wrapper.find('button').trigger('click');
		wrapper.setData({
			form: {
				name: 'test',
				username: 'test',
				email: 'test@qq.com',
				password: 12345678,
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
		});

		mock.onPost('/api/register', wrapper.vm.form).reply(200, {
			status: 200,
		});
	});

	let register = function() {
		axios
			.post('/api/register', wrapper.vm.form)
			.then(res => {
				expect(res.status).toBe(200);
			})
			.catch(err => {
				if (err.response.data.errors.email) {
					this.errors.email = err.response.data.errors.email[0];
					this.invalids.email = true;
				}

				if (err.response.data.errors.name) {
					this.errors.name = err.response.data.errors.name[0];
					this.invalids.name = true;
				}

				if (err.response.data.errors.username) {
					this.errors.username = err.response.data.errors.username[0];
					this.invalids.username = true;
				}

				if (err.response.data.errors.password) {
					this.errors.password = err.response.data.errors.password[0];
					this.invalids.password = true;
				}
			});
	};
});
