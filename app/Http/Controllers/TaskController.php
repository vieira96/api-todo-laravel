<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Todo;
use App\Models\TodoTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Todo $todo)
    {
        $tasks = TaskResource::collection($todo->tasks);
        return $this->responseSuccess($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Todo $todo, TaskRequest $request)
    {
        $data = $request->validated();
        $task = $todo->tasks()->create($data);
        return $this->responseSuccess(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Todo $todo, TodoTask $task)
    {
        $this->authorize('update', $task);
        $data = $request->only([
            'label',
            'is_complete',
        ]);
        $task->fill($data);
        $task->save();
        return $this->responseSuccess(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo, TodoTask $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return $this->responseSuccess();
    }
}
