import { mount, createLocalVue } from '@vue/test-utils';

import Component from '../../components/auth/Login.vue';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('Test Login.vue.', () => {
	const localVue = createLocalVue();
	let mock = new MockAdapter(axios);
	let wrapper;

	beforeEach(() => {
		wrapper = mount(Component, {
			localVue,
			methods: {
				login,
			},
		});
	});

	afterEach(() => {
		wrapper.destroy();
	});

	it('Has card-header and card-body', () => {
		expect(wrapper.contains('.card-header')).toBe(true);
		expect(wrapper.find('.card-header').text()).toMatch(/Login/);
		expect(wrapper.contains('.card-body')).toBe(true);
	});

	it('Has username field', () => {
		expect(wrapper.find('.card-body .form-group label').text()).toMatch(
			/Username/,
		);
		expect(wrapper.find('[name="username"]')).toEqual({});
		expect(
			wrapper.find('[placeholder="Please input username or email"]'),
		).toEqual({});
	});

	it('Has password field', () => {
		expect(wrapper.find('[name="password"]')).toEqual({});
		expect(wrapper.find('[placeholder="Please input password"]')).toEqual(
			{},
		);
	});

	it('Has login button', () => {
		expect(wrapper.contains('button')).toBe(true);
		expect(wrapper.find('button').text()).toMatch(/Login/);
	});

	it('Has errors(mock request)', () => {
		wrapper.find('button').trigger('click');
		wrapper.setData({
			form: {
				username: 'a',
				password: 1,
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
		});

		mock.onPost('/login', wrapper.vm.form).reply(422, {
			message: 'The given data was invalid.',
			errors: {
				username: ['The username must be at least 2 characters.'],
				password: ['The password must be at least 8 characters.'],
			},
		});
	});

	it('Login success (mock request)', () => {
		wrapper.find('button').trigger('click');
		wrapper.setData({
			form: {
				username: 'admin',
				password: 12345678,
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
		});

		mock.onPost('/api/login', wrapper.vm.form).reply(200, {
			status: 200,
		});
	});

	let login = function() {
		// console.log(wrapper.vm.form.username, wrapper.vm.form.password);
		axios
			.post('/api/login', wrapper.vm.form)
			.then(res => {
				expect(res.status).toBe(200);
			})
			.catch(err => {
				// console.log(err.response);
				expect(err.response.status).toBe(422);
				expect(err.response.data.message).toMatch(
					/The given data was invalid./,
				);

				expect(err.response.data.errors.username[0]).toMatch(
					/The username must be at least 2 characters./,
				);
				expect(err.response.data.errors.password[0]).toMatch(
					/The password must be at least 8 characters./,
				);

				if (err.response.data.errors.username[0]) {
					wrapper.vm.errors.username =
						err.response.data.errors.username[0];
					wrapper.vm.invalids.username = true;
				}

				if (err.response.data.errors.password[0]) {
					wrapper.vm.errors.password =
						err.response.data.errors.password[0];
					wrapper.vm.invalids.password = true;
				}
			});
	};
});
