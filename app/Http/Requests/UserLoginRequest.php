<?php

namespace Rspafs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'min:2', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ];
    }

    /**
     * Customize message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username or email is required',
            'password.required' => 'Password is required',
        ];
    }
}
