<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$quizzes = Quiz::where('num_ques' , '>' , 0)
                    ->where('public' , '=' , 1)
                    ->paginate(20);

        return view('profile.home' , compact('quizzes'));
    }
}
