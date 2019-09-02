<?php

namespace Rspafs\Http\Controllers\Auth;

use Rspafs\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Rspafs\Http\Requests\UserLoginRequest;
use Rspafs\Contracts\Services\UserServiceContract;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Rewrite login function in AuthenticatesUsers class for username or password login.
     *
     * @param UserLoginRequest $request
     * @param UserServiceContract $userService
     * @return void
     */
    public function login(UserLoginRequest $request, UserServiceContract $userService)
    {
        $userService->checkLogin($request->username, $request->password);
        
        if ($request->user()) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
