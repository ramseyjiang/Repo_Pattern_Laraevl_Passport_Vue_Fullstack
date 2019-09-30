<?php

namespace Rspafs\Observers;

use Rspafs\Models\Task;
use Illuminate\Support\Facades\Auth;
use Rspafs\Contracts\Repositories\LogRepositoryContract;

class TaskObserver
{
    protected $logRepo;

    public function __construct(LogRepositoryContract $logRepo) 
    {
        $this->user = Auth::user();
        $this->logRepo = $logRepo;
    }

    /**
     * Handle the task "created" event.
     *
     * @param  \Rspafs\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $this->user = empty($this->user) ? ($task->user) : $this->user;
        $desc = 'task ' . $task->id . ' is created by user '. $this->user->id;
        $this->logRepo->taskOperateLog($this->user, $desc);
    }
    /**
     * Handle the task "updated" event.
     * The updated events include updated tasks, done tasks, undone tasks.
     *
     * @param  \Rspafs\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        if ($task->isDirty('finished_at')) {
            $desc = $task->finished_at 
            ? ('task ' . $task->id . ' is done by user '. $this->user->id)
            : ('task ' . $task->id . ' is undone by user '. $this->user->id);
        } else {
            $desc = 'task ' . $task->id . ' is updated by user '. $this->user->id;
        }
        $this->logRepo->taskOperateLog($this->user, $desc);
    }
    /**
     * Handle the task "deleted" event.
     *
     * @param  \Rspafs\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $desc = 'task ' . $task->id . ' is soft deleted by user '. $this->user->id;
        $this->logRepo->taskOperateLog($this->user, $desc);
    }
    /**
     * Handle the task "restored" event.
     *
     * @param  \Rspafs\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }
    /**
     * Handle the task "force deleted" event.
     *
     * @param  \Rspafs\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
