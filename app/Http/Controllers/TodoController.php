<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTodoRequest;
use App\Http\Requests\PatchTodoRequest;
use App\Http\Requests\TodoIndexRequest;
use App\Http\Requests\TodoShowRequest;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TodoIndexRequest $request)
    {
        $user = User::where('api_token', $request->bearerToken())->first();
        $resp = new TodoCollection($user->todos);
        return response($resp, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TodoShowRequest $request, $id)
    {
        $todo = new TodoResource(Todo::find($id));
        return response($todo, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoStoreRequest $request)
    {

        $validated = $request->validated();

        $author = User::where('api_token', $request->bearerToken())->first()['id'];

        Todo::create([
            'user_id' => $author,
            'title'   => $validated['title']
        ]);

        return response([ 'message' => 'The todo was successful created' ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatchTodoRequest $request, $id)
    {
        $todo = Todo::find($id);
        $todo->fill($request->validated())->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTodoRequest $request, $id)
    {
        $deleted = Todo::destroy($id);
        return $deleted;
    }
}
