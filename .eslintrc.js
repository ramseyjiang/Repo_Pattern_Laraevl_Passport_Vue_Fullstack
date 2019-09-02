module.exports = {
	env: {
		browser: true,
		es6: true,
		node: true,
		jquery: true,
	},
	extends: [
		'eslint:recommended',
		'plugin:vue/strongly-recommended',
		'plugin:prettier/recommended',
	],
	globals: {
		Atomics: 'readonly',
		SharedArrayBuffer: 'readonly',
		test_param: true,
	},
	parserOptions: {
		ecmaVersion: 2018,
		sourceType: 'module',
	},
	plugins: ['vue'],
	rules: {
		'no-console': 'off',
		'no-undef': 'off',
		'no-unused-vars': 'off',
		'prettier/prettier': 'error',
		'no-mixed-spaces-and-tabs': ['error', 'smart-tabs'],
		'vue/html-indent': [
			'error',
			'tab',
			{
				attribute: 1,
				baseIndent: 1,
				closeBracket: 0,
				alignAttributesVertically: true,
				ignores: [],
			},
		],
		'vue/max-attributes-per-line': [
			'error',
			{
				singleline: 4,
				multiline: {
					max: 4,
					allowFirstLine: true,
				},
			},
		],
		'vue/html-self-closing': [
			'error',
			{
				html: {
					void: 'always',
					normal: 'never',
					component: 'never',
				},
				svg: 'always',
				math: 'always',
			},
		],
		'vue/html-closing-bracket-newline': [
			'error',
			{
				singleline: 'never',
				multiline: 'always',
			},
		],
	},
};
