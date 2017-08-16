<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Quiz;

class QuizController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function home($quiz_slug) {

    	$quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
    			->firstOrFail();
    	
    	return view('quiz.home' , compact('quiz'));
    }

    public function playQuiz($quiz_slug , Request $request) {

    	$quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
    			->firstOrFail();
    	
    	return view('quiz.playquiz' , compact('quiz'));
    }
}
