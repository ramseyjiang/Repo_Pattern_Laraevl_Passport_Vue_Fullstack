<?php

namespace Rspafs\Repositories;

use Rspafs\Contracts\Repositories\TaskRepositoryContract;
use Rspafs\Models\Task;
use Carbon\Carbon;

class TaskRepository implements TaskRepositoryContract
{
    /**
     * Create a task
     *
     * @param array $data
     * @param object $user
     * @return void
     */
    public function createTask(array $data, object $user)
    {
        return Task::create([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);
    }

    /**
     * Update a task
     *
     * @param array $data
     * @param object $task
     * @return void
     */
    public function updateTask(array $data, object $task)
    {
        $task->name = $data['name'];
        $task->save();
    }

    /**
     * Mark a task done.
     *
     * @param object $task
     * @return void
     */
    public function markTaskDone(object $task)
    {
        $task->finished_at = Carbon::now();
        $task->save();
    }

    /**
     * Mark a task undone.
     *
     * @param object $task
     * @return void
     */
    public function markTaskUndone(object $task)
    {
        $task->finished_at = null;
        $task->save();
    }

    /**
     * Soft delete a task.
     *
     * @param object $task
     * @return void
     */
    public function deleteTask(object $task)
    {
        $task->delete();
    }

    /**
     * restore a soft deleted task.
     * 
     * The wrong example, using the following way it won't trigger observer restored or restoring method.
     * Task::onlyTrashed()
     * ->where('id', $taskId)
     * ->restore();
     *
     * @param object $task
     * @return void
     */
    public function restoreTask(int $taskId)
    {
        Task::onlyTrashed()
        ->find($taskId)
        ->restore();
    }

    /**
     * Show all users active tasks not include soft deleted tasks and finished tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUsersActiveTasks()
    {
        return Task::where('deleted_at', null)
        ->where('finished_at', null)
        ->get();
    }

    /**
     * Get a user active tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserActiveTasks(int $userId)
    {
        return Task::where('user_id', $userId)
        ->where('deleted_at', null)
        ->where('finished_at', null)
        ->get();
    }

    /**
     * Show all users finished taskss.
     *
     * @param object $user
     * @return void
     */
    public function getUsersFinishedTasks()
    {
        return Task::where('finished_at', '<>', null)->get();
    }

    /**
     * Get a user finished tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserFinishedTasks(int $userId)
    {
        return Task::where('user_id', $userId)
        ->where('finished_at', '<>', null)
        ->get();
    }

    /**
     * Show current user's all tasks include deleted tasks.
     *
     * @return void
     */
    public function getUsersTrashedTasks()
    {
        return Task::onlyTrashed()->get();
    }

    /**
     * Get a user trashed tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserTrashedTasks(int $userId)
    {
        return Task::where('user_id', $userId)
        ->onlyTrashed()
        ->get();
    }
}