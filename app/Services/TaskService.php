<?php

namespace Rspafs\Services;

use Rspafs\Contracts\Services\TaskServiceContract;
use Rspafs\Contracts\Repositories\TaskRepositoryContract;

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
     * @param integer $taskId
     * @return void
     */
    public function restoreTask(int $taskId)
    {
        $this->taskRepo->restoreTask($taskId);
    }

    /**
     * It is used to show current user's all active tasks not include deleted tasks and finished tasks.
     * If a user is an admin, it will return all users active tasks.
     * If not, it should return current user active tasks.
     *
     * @param object $user
     * @return void
     */
    public function getActiveTasks(object $user)
    {
        if($user->id == 1) {
            return $this->taskRepo->getUsersActiveTasks();
        } else {
            return $this->taskRepo->getUserActiveTasks($user->id);
        }
    }

    public function getFinishedTasks(object $user)
    {
        if($user->id == 1) {
            return $this->taskRepo->getUsersFinishedTasks();
        } else {
            return $this->taskRepo->getUserFinishedTasks($user->id);
        }
    }

    /**
     * It is used to get trashed tasks.
     * If a user is an admin, it will return all users trashed tasks.
     * If not, it should return current user trashed tasks.
     * 
     * @param object $user
     * @return void
     */
    public function getTrashedTasks(object $user)
    {
        if($user->id == 1) {
            return $this->taskRepo->getUsersTrashedTasks();
        } else {
            return $this->taskRepo->getUserTrashedTasks($user->id);
        }
    }
}