<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Quiz;
use App\Question;
use App\Option;

class QuestionController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function addQuestion($quiz_unique){
    	
    	$quiz = Quiz::where('user_unique' , '=' , Auth::user()->user_unique)
    			->where('quiz_unique' , '=' , $quiz_unique)
    			->first();

    	$questions = Question::where('quiz_unique' , '=' , $quiz_unique)
    			->orderBy('question_number' , 'asc')
    			->get(['question' , 'answer' , 'question_type']);

    	return view('profile.addquestion' , compact('quiz' , 'questions'));
    }

    public function saveQuestion(Request $request){

    	$validation = array();
    	if($request->question_type !== "text")
	    	$validation = array(
	            'question' => 'required',
	            'option.*' => 'required',
	            'answer' => 'required'
	        );
		else
			$validation = array(
	            'question' => 'required',
	            'answer' => 'required'
	        );

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {
        	
        	$answer_str = "";

        	$question = new Question;
        	$question->question_unique = $question->getQuestionUnique();
        	$question->quiz_unique = $request->quiz_unique;
        	$question->question_type = $request->question_type;
        	$question->question = $request->question;
        	
        	if($request->question_type !== "text"){

        		$option_arr = $request->option;
        		$answer_arr = explode(',' , $request->answer);
	        	foreach($option_arr as $key=>$value){
	        		$option = new Option;
	        		$option->option_unique = $option->getOptionUnique();
	        		$option->question_unique = $question->question_unique;
	        		$option->option_content = $value;
	        		if(in_array(chr($option_val++), $answer_arr)){
	        			$answer_str .= $option->option_unique . ",";
	        		}
	        		$option->save();
	        	}
	        	$answer_str = rtrim($answer_str , ",");
	        } else {
	        	$option = new Option;
        		$option->option_unique = $option->getOptionUnique();
        		$option->question_unique = $question->question_unique;
        		$option->option_content = $request->answer;
        		$option->save();

        		$answer_str = $option->option_unique;
	        }
            $question->question_number = $request->num_ques;
        	$question->answer = $answer_str;
        	$question->save();

        	Quiz::where('quiz_unique' , '=' , $request->quiz_unique)
        			->update(['num_ques' => $request->num_ques]);

            return back()->with('message', 'Question added successfully..');
        }
    }
}
