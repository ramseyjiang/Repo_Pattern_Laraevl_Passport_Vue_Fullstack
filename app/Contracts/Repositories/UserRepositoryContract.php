<?php

namespace Rspafs\Contracts\Repositories;

interface UserRepositoryContract 
{
    public function findOne(int $userId);

    public function createUser(array $data);

    public function deleteUserByEmail(string $email);
}