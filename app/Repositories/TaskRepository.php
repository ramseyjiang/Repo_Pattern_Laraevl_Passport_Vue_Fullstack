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
     * @param object $task
     * @return void
     */
    public function restoreTask(object $task)
    {
        $task->restore();
    }

    /**
     * It is used to show current user's all active tasks not include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserActiveTasks(object $user)
    {
        return $user->tasks;
    }

    /**
     * It is used to show current user's all tasks include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserAllTasks(object $user)
    {
        return $user->withTrashed();
    }

    /**
     * It is used to all user tasks, onlt the admin can invoke this method.
     *
     * @param object $user
     * @return void
     */
    public function getAllUserTasks()
    {
        return Task::withTrashed();
    }
}