<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $names = User::orderBy('id', 'desc')->get();
        return UserResource::collection($names);
    }

    public function store(Request $request){
        $names = User::create([
            'name' => $request->name
        ]);

        return new UserResource($names);
    }

    public function edit ($id) {
        $name = User::findOrFail($id);

        return new UserResource($name);
    }

    public function update($id, Request $request){
        $name = User::find($id);
        $name->name = request('name');
        $name->update();

        return new UserResource($name);
    }

    public function delete($id){
        User::destroy($id);
        return response()->json([
           'response_code' => '00',
           'response_message' => 'Berhasil!'
        ]);
    }
}
