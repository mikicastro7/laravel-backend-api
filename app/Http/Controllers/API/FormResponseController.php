<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\todoResource;
use Illuminate\Support\Facades\Validator;
use Log;
use Auth;
use App\Models\Form_question;
use App\Models\Form_response;

class FormResponseController extends Controller
{
    public function saveFormResponse (Request $request) {
        $form = Form_question::where('id', '=', $request->id)->first();

        $formData = array(
            "title" => $request->title,
            "description" => $request->description,
            "form_elements" => $request->form_elements,
            "form_question_id" => $request->id,
            "user_id" => $form->user_id
        );

        $newResponse = Form_response::create($formData);

        $newResponse->save();

        return response(['message' => 'success'], 200);

    }

    public function getUnchecked () {
        $numUnchecked = Form_response::where([
            ['user_id', '=', Auth::user()->id],
            ['checked', '=', false]
        ])->count();

        return response(['unchecked' => $numUnchecked], 200);
    }

    public function getRespondedForms () {
        $respondedForms = Form_response::where('user_id', '=', Auth::user()->id)
            ->orderBy('checked', 'ASC')->get();

        return response(['forms' => $respondedForms], 200);

    }
    public function deleteForm(Request $request) {
        $form = Form_response::where('id', $request->id)->first();
        if(Auth::user()->id == $form->user_id){
            $form->delete();
            return response(['message' => 'Deleted']);
        }
        return response(['message' => "User doesn't match"]);
    }

    public function getForm(Request $request){
        $form = Form_response::where('id', $request->id)->first();

        if(Auth::user()->id == $form->user_id){
            return response(['form' => $form,'message' => 'Deleted']);
        }
        return response(['message' => "User doesn't match"]);

    }

    public function checkedForm(Request $request){
        $form = Form_response::where('id', $request->id)->first();

        if(Auth::user()->id == $form->user_id){
            $form->checked = true;
            $form->save();
        }
        return response(['message' => "User doesn't match"]);
    }

}
