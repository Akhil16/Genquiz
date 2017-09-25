<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Quiz;
use App\QuizResult;

class ProfileController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function home(){
    	
    	$quizzes = Quiz::where('num_ques' , '>' , 0)
                    ->paginate(20);

        return view('profile.home' , compact('quizzes'));
    }

    public function addQuiz(){

    	return view('profile.addquiz' , compact('quiz'));
    }

    public function saveQuiz(Request $request){

    	$validation = array(
            'title' => 'required|min:3|max:40|unique:quizzes',
            'description' => 'required',
            'quiz_cover' => 'mimes:jpeg,bmp,png,jpg'
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
            if($request->quiz_cover) {
                $file = request()->file("quiz_cover");
                $ext = $file->getClientOriginalExtension();
                $filename_cover = $quiz->quiz_slug . "." . $ext;
                $file->move(public_path("uploads/quizcover") , $filename_cover);

                $quiz->quiz_cover = $filename_cover;
            } else {
                $quiz->quiz_cover = "quiz-default-cover.png";
            }
            $quiz->save();

            return redirect('profile/add-question/' . $quiz->quiz_unique);
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
                'description' => 'required',
                'quiz_cover' => 'mimes:jpeg,png,jpg,bmp'
            );
        } else {
            $validation = array(
                'title' => 'required|min:3|max:40|unique:quizzes',
                'description' => 'required',
                'quiz_cover' => 'mimes:jpeg,png,jpg,bmp'
            );
        }

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {

            $quiz_arr = array();

            if($request->quiz_cover) {

                $file = request()->file("quiz_cover");
                $ext = $file->getClientOriginalExtension();
                $filename_cover = str_replace(" ", "-", strtolower($request->title)) . "." . $ext;
                $file->move(public_path("uploads/quizcover") , $filename_cover);

                $quiz_arr = array(
                    'title' => $request->title,
                    'description' => $request->description,
                    'quiz_slug' => str_replace(" ", "-", strtolower($request->title)),
                    'quiz_cover' => $filename_cover
                );
            } else {
                $quiz_arr = array(
                    'title' => $request->title,
                    'description' => $request->description,
                    'quiz_slug' => str_replace(" ", "-", strtolower($request->title))
                );
            }

            Quiz::where('quiz_unique' , '=' , $request->quiz_unique)
                    ->update($quiz_arr);

            return back()->with('message', 'Quizzz updated successfully..');
        }
    }

    public function showCreatedQuiz(){

        $quiz = Quiz::where('user_unique' , '=' , Auth::user()->user_unique)
                ->select(['title' , 'description' , 'num_ques' , 'quiz_unique'])
                ->paginate(20);

        return view('profile.showcreatedquiz' , compact('quiz'));
    }

    public function showPlayedQuiz(){

        $playedquiz = QuizResult::where('player_user_unique' , '=' , Auth::user()->user_unique)
                        ->where('status' , '=' , 1)
                        ->selectRaw('quiz_unique , max(score) as score')
                        ->groupBy('quiz_unique')
                        ->paginate(40);
        
        return view('profile.showplayedquiz' , compact('playedquiz'));
    }
}
