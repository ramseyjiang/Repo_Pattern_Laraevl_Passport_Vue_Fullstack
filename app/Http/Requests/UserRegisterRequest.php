<?php

namespace Rspafs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'username' => ['required', 'string', 'min:2', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
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
            'name.required' => 'Name is required',
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
