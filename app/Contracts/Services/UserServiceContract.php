<?php

namespace Rspafs\Contracts\Services;

interface UserServiceContract 
{
    public function checkLogin(string $username, string $email);
}