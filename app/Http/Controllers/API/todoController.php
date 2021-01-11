<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\todo;
use Illuminate\Http\Request;
use App\Http\Resources\todoResource;
use Illuminate\Support\Facades\Validator;
use Log;
use Auth;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = todo::all();
        return response([ 'todos' => todoResource::collection($todos), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['completed'] = $data['completed'] === 'true'? true: false;

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => '',
            'priority' => 'required|max:255',
            'completed' => 'required',
            'user_id' => 'required'
        ]);
        
    
        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $todo = todo::create($data);

        return response([ 'todo' => new todoResource($todo), 'message' => 'Created successfully'], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo $todo)
    {
        if(Auth::user()->id == $todo->user_id){
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->completed = $request->completed;
            $todo->priority = $request->priority;
            
            $todo->save();
            return response([ 'comments' => new todoResource($comment), 'message' => 'Retrieved successfully'], 200);
        }
        return response(['message' => "User doesn't match"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo $todo)
    {
        if(Auth::user()->id == $todo->user_id){
            $todo->delete();
            return response(['message' => 'Deleted']);
        }
        return response(['message' => "User doesn't match"]);
    }
    public function getTodosUser(Request $request){
        
        $todos = todo::where('user_id', Auth::user()->id)->get();
        
        return response([ 'todo' => $todos, 'message' => 'Retrieved successfully'], 200);
    }

}
