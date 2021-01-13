<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\todoResource;
use Illuminate\Support\Facades\Validator;
use Log;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request){

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $comment = Comment::create($data);
        return response([ 'comments' => new todoResource($comment), 'message' => 'Created successfully'], 200);
    }

    public function update(Request $request, Comment $comment)
    {
        if(Auth::user()->id == $comment->user_id){
            $comment->comment_text = $request->comment_text;
            $comment->rating = $request->rating;
            
            $comment->save();
            return response([ 'comments' => new todoResource($comment), 'message' => 'Retrieved successfully'], 200);
        }

        return response(['message' => "User doesn't match"]);
    }
    public function destroy(comment $comment)
    {
        if(Auth::user()->id == $comment->user_id){
            $comment->delete();
            return response(['message' => 'Deleted']);
        }
        return response(['message' => "User doesn't match"]);
    }
    public function getCommentsProject(Request $request){
        $comments = Comment::where('project_id', $request->id)
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('users.name', 'comments.*')        
            ->orderByRaw('FIELD(users.id, ?) DESC, comments.created_at DESC', [Auth::user()->id])
            ->get();
        
        return response([ 'comments' => $comments, 'message' => 'Retrieved successfully'], 200);
    }
}
