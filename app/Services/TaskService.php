<?php

namespace Rspafs\Services;

use Rspafs\Contracts\Services\TaskServiceContract;
use Rspafs\Contracts\Repositories\TaskRepositoryContract;
use Carbon\Carbon;

class TaskService implements TaskServiceContract
{
    /**
     * @var TaskRepositoryContract
     */
    protected $taskRepo;

    /**
     * BuilderController constructor.
     */
    public function __construct(TaskRepositoryContract $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    /**
     * Create a task
     *
     * @param array $data
     * @param object $user
     * @return void
     */
    public function createTask(array $data, object $user)
    {
        $this->taskRepo->createTask($data, $user);
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
        $this->taskRepo->updateTask($data, $task);
    }

    /**
     * Mark a task done.
     *
     * @param object $task
     * @return void
     */
    public function markTaskDone(object $task)
    {
        $this->taskRepo->markTaskDone($task);
    }

    /**
     * Mark a task undone.
     *
     * @param object $task
     * @return void
     */
    public function markTaskUndone(object $task)
    {
        $this->taskRepo->markTaskUndone($task);
    }

    /**
     * Soft delete a task.
     *
     * @param object $task
     * @return void
     */
    public function deleteTask(object $task)
    {
        $this->taskRepo->deleteTask($task);
    }

    /**
     * restore a soft deleted task.
     *
     * @param object $task
     * @return void
     */
    public function restoreTask(object $task)
    {
        $this->taskRepo->restoreTask($task);
    }

    /**
     * It is used to show current user's all active tasks not include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserActiveTasks(object $user)
    {
        return $this->taskRepo->getUserActiveTasks($user);
    }

    /**
     * It is used to show current user's all tasks include deleted tasks.
     *
     * @param object $user
     * @return void
     */
    public function getUserAllTasks(object $user)
    {
        return $this->taskRepo->getUserAllTasks($user);
    }

    /**
     * It is used to all user tasks, onlt the admin can invoke this method.
     *
     * @param object $user
     * @return void
     */
    public function getAllUserTasks()
    {
        return $this->taskRepo->getAllUserTasks();
    }
}