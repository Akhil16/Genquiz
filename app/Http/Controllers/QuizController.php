<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Quiz;
use App\Question;
use App\Option;
use App\QuizResult;

class QuizController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

    public function home($quiz_slug) {

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->firstOrFail();

        $result = QuizResult::where('quiz_unique' , '=' , $quiz->quiz_unique)
                    ->where('player_user_unique' , '=' , Auth::user()->user_unique)
                    ->where('status' , '=' , 0)
                    ->where('created_at' , '>' , date("Y-m-d H:i:s", time() - (60 * 60)))
                    ->orderBy('id' , 'desc')
                    ->first();

        return view('quiz.home' , compact('quiz' , 'result'));
    }

    public function getPlayQuiz($quiz_slug) {

        if(Quiz::where('quiz_slug' , '=' , $quiz_slug)->count() > 0) {
            return redirect('quiz/' . $quiz_slug);
        } else {
            abort(404);
        }
    }

    public function postPlayQuiz($quiz_slug , Request $request) {

        // dd($request->all());
        $quiz_unique = $request->quiz_unique;
        $endtime = $request->endtime;
        $play_unique = $request->play_unique;

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->firstOrFail();

        if($quiz_unique == null) {

            return redirect('quiz/' . $quiz_slug);
        }
        $answer_arr = array();

        $resultset = QuizResult::where('quiz_unique' , '=' , $quiz_unique)
                    ->where('player_user_unique' , '=' , Auth::user()->user_unique)
                    ->where(function($query) use ($play_unique){
                            $query->where('play_unique' , '=' , $play_unique)
                                ->orWhere('created_at' , '>' , date("Y-m-d H:i:s", time() - (60 * 60)));
                    })
                    ->where('status' , '=' , 0)
                    ->get(['status' , 'play_unique' , 'score' , 'created_at']);
        
        $result = $resultset->where('play_unique' , '=' , $play_unique)->first();

        if($play_unique !== null && (($request->question_number == $quiz->num_ques || 
            $result->where('created_at' , '>' , date("Y-m-d H:i:s", time() - (60 * 60)))->count() == 0))) {
            
            if($request->answer == "positive") {
                $answer_arr = array(
                    'completed_question' => $request->question_number,
                    'status' => 1,
                    'score' => ($result->score + 100) / $quiz->num_ques
                );
                
            } else {
                $answer_arr = array(
                    'completed_question' => $request->question_number,
                    'status' => 1,
                    'score' => $result->score / $quiz->num_ques
                );
            }

            QuizResult::where('play_unique' , '=' , $play_unique)
                        ->update($answer_arr);
            
            return redirect('result/quiz/' . $quiz_slug . '/player/' . $play_unique);
        }

        if($play_unique == null) {

            if($resultset->where('status' , '=' , 0)->where('created_at' , '>' , date("Y-m-d H:i:s", time() - (60 * 60)))->count() > 0) {
                $quizresult = $resultset->where('created_at' , '>' , date("Y-m-d H:i:s", time() -           (60 * 60)))
                                ->sortByDesc('created_at')
                                ->first();
                $endtime = strtotime($quizresult->created_at) + (60 * 60);

            } else {
                $quizresult = new QuizResult;
                $quizresult->play_unique = $quizresult->getResultUnique();
                $quizresult->quiz_unique = $quiz->quiz_unique;
                $quizresult->player_user_unique = $request->player_user_unique;
                $quizresult->created_user_unique = $request->created_user_unique;
                $quizresult->completed_question = 0;
                $quizresult->save();

                $endtime = time() + (60 * 60);
            }

            $play_unique = $quizresult->play_unique;

            $question = Question::where('quiz_unique' , '=' , $quiz_unique)
                        ->where('question_number' , '=' , 1)
                        ->first();

            $options = Option::where('question_unique' , '=' , $question->question_unique)
                        ->orderBy('id' , 'asc')
                        ->get();

        } else if(sizeof($result) > 0) {
            
            if($request->continue_question !== true) {
                if($request->answer == "positive") {
                    $answer_arr = array(
                        'completed_question' => $request->question_number,
                        'score' => $result->score + 100
                    );
                    
                } else {
                    $answer_arr = array(
                        'completed_question' => $request->question_number
                    );
                }

                QuizResult::where('play_unique' , '=' , $play_unique)
                            ->update($answer_arr);
            }
            $question = Question::where('quiz_unique' , '=' , $quiz_unique)
                        ->where('question_number' , '=' , $request->question_number + 1)
                        ->first();

            $options = Option::where('question_unique' , '=' , $question->question_unique)
                        ->orderBy('id' , 'asc')
                        ->get();
        } else {
            return redirect('/');
        }
        
        return view('quiz.playquiz' , compact('quiz' , 'question' , 'options' , 'endtime' , 'play_unique'));
    }

    public function showResult($quiz_slug , $play_unique) {

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->firstOrFail();

        $result = QuizResult::where('quiz_unique' , '=' , $quiz->quiz_unique)
                    ->where('player_user_unique' , '=' , Auth::user()->user_unique)
                    ->where('play_unique' , '=' , $play_unique)
                    ->where('status' , '=' , 1)
                    ->firstOrFail();

        return view('quiz.result' , compact('quiz' , 'result'));
    }
}
