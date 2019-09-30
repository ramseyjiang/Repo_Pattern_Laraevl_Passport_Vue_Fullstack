<?php

namespace Rspafs\Http\Controllers\Api;

use Rspafs\Http\Controllers\Controller;
use Rspafs\Http\Requests\TaskRequest;
use Rspafs\Contracts\Services\TaskServiceContract;
use Auth;

class TaskController extends Controller
{
    /**
     * @var TaskServiceContract
     */
    protected $taskService;

    /**
     * BuilderController constructor.
     */
    public function __construct(TaskServiceContract $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of current user tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Auth::user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $user = Auth::user();
        $this->taskService->createTask($request->all(), $user);
        
        return response()->json($user->tasks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TaskRequest  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);

        $this->authorize('match', $task);   // check if the authenticated user can match the task. The second param must be an object.
        $this->taskService->updateTask($request->all(), $task);

        return response()->json($user->tasks()->find($taskId));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);

        $this->authorize('match', $task);  // check if the authenticated user can match the task. The second param must be an object.
        $task->delete();

        return response()->json($user->tasks);
    }

    /**
     * Mark a task has been done.
     *
     * @param integer $taskId
     * @return void
     */
    public function markTaskDone(int $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);
        $this->taskService->markTaskDone($task);

        return response()->json($user->tasks);
    }
    /**
     * Reset a done task to undone.
     *
     * @param integer $taskId
     * @return void
     */
    public function markTaskUndone(int $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);
        $this->taskService->markTaskUndone($task);
        
        return response()->json($user->tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
