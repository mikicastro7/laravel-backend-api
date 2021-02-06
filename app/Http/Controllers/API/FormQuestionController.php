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


class FormQuestionController extends Controller
{
    public function store(Request $request){

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['form_key'] = rand(1000000, 9999999) . Auth::user()->id;

        $form_question = Form_question::create($data);


        return response([ 'form_question' => new todoResource($form_question), 'message' => 'Created successfully'], 200);
    }

    public function index(){
        $forms = Form_question::where('user_id', Auth::user()->id)->get();

        return response([ 'forms' => $forms, 'message' => 'Retrieved successfully'], 200);
    }

    public function destroy(Form_question $Form_question) {
        if(Auth::user()->id == $Form_question->user_id){
            $Form_question->delete();
            return response(['message' => 'Deleted']);
        }
        return response(['message' => "User doesn't match"]);
    }

    public function copi(Request $request){

        $originalForm = Form_question::where('id', $request->id)->first();


        $newData = array(
            "title" => "Copi " . $originalForm->title ,
            "description" => $originalForm->description,
            "form_elements" => $originalForm->form_elements,
            "user_id" => Auth::user()->id,
            "form_key" => rand(1000000, 9999999) . Auth::user()->id,
        );

        $newForm = Form_question::create($newData);

        $newForm->save();

        return response([ 'form_question' => $newForm, 'message' => 'copied'], 200);
    }

    public function getForm(Request $request){
        $form = Form_question::where('id', $request->id)->first();

        if ($form == null){
            return response(['message' => "this form don't exist"]);
        }

        if($form->user_id === Auth::user()->id){
            return response([ 'form' => $form, 'message' => 'form retrived'], 200);
        }

        return response(['message' => "user not allawed"]);
    }

    public function getFormByKey(Request $request){

        $form = Form_question::where('form_key', $request->form_key)->first();

        return response([ 'form' => $form, 'message' => 'retrived succesfully'], 200);
    }

    public function saveForm(Request $request){

        $form = Form_question::where('id', $request->id)->first();

        if(Auth::user()->id === $form->user_id){
            $form->title = $request->title;
            $form->description = $request->description;
            $form->form_elements = $request->form_elements;

            $form->save();
            return response([ 'form_question' => $form, 'message' => 'Saved'], 200);
        }
        return response([ 'form_question' => $form, 'message' => 'user not allowed'], 200);
    }
}
