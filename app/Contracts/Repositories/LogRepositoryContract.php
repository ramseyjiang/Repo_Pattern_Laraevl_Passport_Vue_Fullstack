<?php

namespace Rspafs\Contracts\Repositories;

interface LogRepositoryContract 
{
    public function createBlogOperateLog(object $user, string $desc);
}