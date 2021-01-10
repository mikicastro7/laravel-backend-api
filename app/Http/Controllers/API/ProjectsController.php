<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\todoResource;
use Illuminate\Support\Facades\Validator;
use Log;
use Auth;
class ProjectsController extends Controller
{
    
    public function getProjects(){
        $projects = Project::all();
        return response([ 'projects' => todoResource::collection($projects), 'message' => 'Retrieved successfully'], 200);
    }

}
