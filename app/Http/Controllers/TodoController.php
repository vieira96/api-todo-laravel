<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = TodoResource::collection($this->user->todos);
        return $this->responseSuccess($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $data = $request->validated();
        $todo = new TodoResource($this->user->todos()->create($data));
        return $todo;
    }

    /**
     * Display the specified resource.
     *
     * @param  Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);
        return $this->responseSuccess(new TodoResource($todo));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $this->authorize('update', $todo);
        $data = $request->validated();
        $todo->fill($data);
        $todo->save();
        return $this->responseSuccess(new TodoResource($todo));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
        $todo->delete();
        return $this->responseSuccess();
    }
}
