<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();

        //menggunakan collection karena get() me-return collection
        return TodoResource::collection($todos);
    }

    public function store(Request $request)
    {
        $todo = Todo::create([
            'text' => $request->text,
            'done' => 0
        ]);

        //menggunakan new karena bukan collection, melainkan object saja
        return new TodoResource($todo);
    }

    public function delete($id)
    {
        Todo::destroy($id);
        return 'success';
    }

    public function updateDone($id)
    {
        $todo = Todo::find($id);
        if($todo->done == 1){
            $update = 0;
        } else {
            $update = 1;
        }

        $todo->update([
            'done' => $update
        ]);

        return new TodoResource($todo);
    }
}
