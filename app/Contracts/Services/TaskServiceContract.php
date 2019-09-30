<?php

namespace Rspafs\Contracts\Services;

interface TaskServiceContract 
{
    /**
     * Create a task
     *
     * @param array $data
     * @param object $user
     * @return void
     */
    public function createTask(array $data, object $user);

    /**
     * Update a task
     *
     * @param array $data
     * @param object $task
     * @return void
     */
    public function updateTask(array $data, object $task);

    /**
     * Mark a task done.
     *
     * @param object $task
     * @return void
     */
    public function markTaskDone(object $task);

    /**
     * Mark a task undone.
     *
     * @param object $task
     * @return void
     */
    public function markTaskUndone(object $task);

    /**
     * Soft delete a task.
     *
     * @param object $task
     * @return void
     */
    public function deleteTask(object $task);

    /**
     * Restore a soft deleted task.
     *
     * @param object $task
     * @return void
     */
    public function restoreTask(object $task);

    /**
     * It is used to show current user's all active tasks not include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserActiveTasks(object $user);

    /**
     * It is used to show current user's all tasks include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserAllTasks(object $user);

    /**
     * It is used to all user tasks, onlt the admin can invoke this method.
     * @return void
     */
    public function getAllUserTasks();
}