<?php
namespace Rspafs\Services;

use Rspafs\Contracts\Services\UserServiceContract;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceContract
{
    /**
     * It is used to check email or username login.
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function checkLogin(string $username, string $password)
    {
        (filter_var($username, FILTER_VALIDATE_EMAIL))
            ? Auth::attempt(['email' => $username, 'password' => $password])
            : Auth::attempt(['username' => $username, 'password' => $password]);
    }
}