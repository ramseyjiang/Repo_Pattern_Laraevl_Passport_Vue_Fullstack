<?php

namespace Rspafs\Contracts\Repositories;

interface TaskRepositoryContract 
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
    public function restoreTask(int $taskId);

    /**
     * Show all users active tasks not include soft deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUsersActiveTasks();

    /**
     * Get a user active tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserActiveTasks(int $userId);
    
    /**
     * Show all users finished tasks.
     *
     * @return void
     */
    public function getUsersFinishedTasks();

    /**
     * Get a user finished tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserFinishedTasks(int $userId);

    /**
     * Show all users trashed tasks..
     *
     * @return void
     */
    public function getUsersTrashedTasks();

    /**
     * Get a user trashed tasks by userId
     *
     * @param integer $userId
     * @return void
     */
    public function getUserTrashedTasks(int $userId);
}