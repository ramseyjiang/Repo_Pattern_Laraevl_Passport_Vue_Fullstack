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
     * @param integer $taskId
     * @return void
     */
    public function restoreTask(int $taskId);

    /**
     * It is used to show all active tasks not include soft deleted tasks and finished tasks.
     *
     * @param object $user
     * @return void
     */
    public function getActiveTasks(object $user);

    /**
     * It is used to show all finished tasks.
     *
     * @param object $user
     * @return void
     */
    public function getFinishedTasks(object $user);

    /**
     * It is used to show all trashed tasks(It means all soft delete tasks.)
     *
     * @param object $user
     * @return void
     */
    public function getTrashedTasks(object $user);
}