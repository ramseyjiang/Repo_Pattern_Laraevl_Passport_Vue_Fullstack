<?php

namespace Rspafs\Observers;

use Rspafs\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Rspafs\Contracts\Repositories\LogRepositoryContract;

class BlogObserver
{
    protected $logRepo;

    public function __construct(LogRepositoryContract $logRepo) 
    {
        $this->user = Auth::user();
        $this->logRepo = $logRepo;
    }

    /**
     * Handle the blog "created" event.
     *
     * @param  \Rspafs\Models\Blog  $blog
     * @return void
     */
    public function created(Blog $blog)
    {
        $this->user = empty($this->user) ? ($blog->user) : $this->user;
        $desc = 'blog ' . $blog->id . ' is created by user '. $this->user->id;
        $this->logRepo->createBlogOperateLog($this->user, $desc);
    }

    /**
     * Handle the blog "updated" event.
     * The updated events include updated blogs.
     *
     * @param  \Rspafs\Models\Blog  $blog
     * @return void
     */
    public function updated(Blog $blog)
    {
        $this->user = empty($this->user) ? ($blog->user) : $this->user;
        $desc = 'blog ' . $blog->id . ' is updated by user '. $this->user->id;
        $this->logRepo->createBlogOperateLog($this->user, $desc);
    }

    /**
     * Handle the blog "deleted" event.
     *
     * @param  \Rspafs\Models\Blog  $blog
     * @return void
     */
    public function deleted(Blog $blog)
    {
        $desc = 'blog ' . $blog->id . ' is deleted by user '. $this->user->id;
        $this->logRepo->createBlogOperateLog($this->user, $desc);
    }

    /**
     * Handle the blog "restored" event.
     *
     * @param  \Rspafs\Models\Blog  $blog
     * @return void
     */
    public function restored(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "force deleted" event.
     *
     * @param  \Rspafs\Models\Blog  $blog
     * @return void
     */
    public function forceDeleted(Blog $blog)
    {
        //
    }
}