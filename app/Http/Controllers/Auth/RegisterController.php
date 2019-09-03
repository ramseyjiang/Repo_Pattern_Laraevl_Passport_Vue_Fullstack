<?php

namespace Rspafs\Http\Controllers\Auth;

use Rspafs\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Rspafs\Http\Requests\UserRegisterRequest;
use Rspafs\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryContract $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    public function register(UserRegisterRequest $request)
    {
        $user = $this->user->createUser($request->all());

        return response()->json([
            'access_token' => $user->createToken('Personal Access Token')->accessToken,
            'token_type' => 'bearer'
        ], Response::HTTP_CREATED);
    }
}
