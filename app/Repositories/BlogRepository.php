<?php

namespace Rspafs\Repositories;

use Rspafs\Contracts\Repositories\BlogRepositoryContract;
use Rspafs\Models\Blog;

class BlogRepository implements BlogRepositoryContract
{
    public static $isReleased = 1;

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return Blog::where('is_released', self::$isReleased)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @inheritDoc
     */
    public function getOne(string $blogId)
    {
        return Blog::findOrFail($blogId);
    }

    /**
     * @inheritDoc
     */
    public function createBlog(array $data, object $user)
    {
        return Blog::create([
            'name' => $data['name'],
            'desc' => $data['desc'],
            'user_id' => $user->id,
            'is_released' => self::$isReleased
        ]);
    }

    /**
     * @inheritDoc
     */
    public function updateBlog(array $data, object $blog)
    {
        $blog->name = $data['name'];
        $blog->desc = $data['desc'];
        $blog->save();
    }
}