<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Quiz;

class ProfileController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function home(){
    	
    	return view('profile.home');
    }

    public function addQuiz(){
    	
    	$quiz = Quiz::where('user_unique' , '=' , Auth::user()->user_unique)
    			->select(['title' , 'description' , 'num_ques' , 'quiz_unique'])
    			->paginate(20);

    	return view('profile.addquiz' , compact('quiz'));
    }

    public function saveQuiz(Request $request){

    	$validation = array(
            'title' => 'required|min:3|max:40|unique:quizzes',
            'description' => 'required'
        );

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {
            $quiz = new Quiz;
            $quiz->quiz_unique = $quiz->getQuizUnique();
            $quiz->user_unique = $request->user_unique;
            $quiz->title = $request->title;
            $quiz->description = $request->description;
            $quiz->quiz_slug = str_replace(" ", "-", strtolower($request->title));
            $quiz->save();

            return back()->with('message', 'Quizzz added successfully..');
        }
    }

    public function editQuiz($quiz_unique){
        
        $quiz = Quiz::where('user_unique' , '=' , Auth::user()->user_unique)
                ->where('quiz_unique' , '=' , $quiz_unique)->firstOrFail();

        return view('profile.editquiz' , compact('quiz'));
    }

    public function updateQuiz(Request $request){

        $validation = array();
        if($request->title && strtolower($request->old_title) == strtolower($request->title)) {
            $validation = array(
                'title' => 'required|min:3|max:40',
                'description' => 'required'
            );
        } else {
            $validation = array(
                'title' => 'required|min:3|max:40|unique:quizzes',
                'description' => 'required'
            );
        }

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {
            
            $quiz_arr = array(
                'title' => $request->title,
                'description' => $request->description,
                'quiz_slug' => str_replace(" ", "-", strtolower($request->title))
            );

            Quiz::where('quiz_unique' , '=' , $request->quiz_unique)
                    ->update($quiz_arr);

            return back()->with('message', 'Quizzz updated successfully..');
        }
    }
}
