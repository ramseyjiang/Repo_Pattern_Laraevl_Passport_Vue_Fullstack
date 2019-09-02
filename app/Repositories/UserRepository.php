<?php

namespace Rspafs\Repositories;

use Rspafs\Contracts\Repositories\UserRepositoryContract;
use Rspafs\Models\User;

class UserRepository implements UserRepositoryContract
{
    /**
     * Find a user info
     *
     * @param integer $userId
     * @return void
     */
    public function findOne(int $userId)
    {
        return User::find($userId);
    }
    /**
     * Create a user.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function deleteUserByEmail(string $email)
    {
        return User::where('email',$email)->delete();
    }
}