<?php

namespace Rspafs\Contracts\Repositories;

interface BlogRepositoryContract 
{
    public function getAll();

    public function getOne(string $blogId);

    public function createBlog(array $data, object $user);

    public function updateBlog(array $data, object $blog);
}