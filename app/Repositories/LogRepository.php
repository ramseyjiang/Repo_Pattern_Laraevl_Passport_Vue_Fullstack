<?php

namespace Rspafs\Repositories;

use Rspafs\Contracts\Repositories\LogRepositoryContract;
use Rspafs\Models\Log;

class LogRepository implements LogRepositoryContract
{
    /**
     * create one record in the log table for blogs.
     * This table is better than default Log record, if you generate a chart to review blogs efficiency.
     *
     * @param object $user
     * @param string $desc
     * @return void
     */
    public function createBlogOperateLog(object $user, string $desc)
    {
        return Log::firstOrCreate([
            'desc' => $desc,
            'user_id' => $user->id
        ]);
    }
}