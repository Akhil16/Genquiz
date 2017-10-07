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
    private $quiz_time = 5*60;

    public function home($quiz_slug) {

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->where('num_ques' , '>' , 0)
                ->firstOrFail();

        $this->quiz_time = $quiz->quiz_time * 60;

        if(Auth::check()) {
            $result = QuizResult::where('quiz_unique' , '=' , $quiz->quiz_unique)
                    ->where('player_user_unique' , '=' , Auth::user()->user_unique)
                    ->where('status' , '=' , 0)
                    ->where('created_at' , '>' , date("Y-m-d H:i:s", time() - $this->quiz_time))
                    ->orderBy('id' , 'desc')
                    ->first();
        } else {
            $result = null;
        }
        $quiztime = $this->quiz_time;
        return view('quiz.home' , compact('quiz' , 'result' , 'quiztime'));
    }

    public function playQuiz($quiz_slug , Request $request) {
        
        $quiz_unique = $request->quiz_unique;
        $endtime = $request->endtime;
        $play_unique = $request->play_unique;

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->firstOrFail();

        $this->quiz_time = $quiz->quiz_time * 60;

        if($quiz_unique == null) {

            return redirect('quiz/' . $quiz_slug);
        }
        $answer_arr = array();

        if(Auth::check()) {
            $resultset = QuizResult::where('quiz_unique' , '=' , $quiz_unique)
                    ->where('player_user_unique' , '=' , Auth::user()->user_unique)
                    ->where(function($query) use ($play_unique){
                            $query->where('play_unique' , '=' , $play_unique)
                                ->orWhere('created_at' , '>' , date("Y-m-d H:i:s", time() - $this->quiz_time));
                    })
                    ->where('status' , '=' , 0)
                    ->get(['status' , 'play_unique' , 'score' , 'created_at']);
        } else {

            $resultset = QuizResult::where('quiz_unique' , '=' , $quiz_unique)
                    ->where('play_unique' , '=' , $play_unique)
                    ->where('status' , '=' , 0)
                    ->get(['status' , 'play_unique' , 'score' , 'created_at']);
        }
                
        $result = $resultset->where('play_unique' , '=' , $play_unique)->first();

        if($play_unique !== null && (($request->question_number == $quiz->num_ques || 
            $result->where('created_at' , '>' , date("Y-m-d H:i:s", time() - $this->quiz_time))->count() == 0))) {
            
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
            
            return response()->json(['quiz_slug' => $quiz_slug , 'play_unique' => $play_unique , 'quiz_status' => 'completed']);
        }

        if($play_unique == null) {

            if($resultset !== null && Auth::check() && $resultset->where('created_at' , '>' , date("Y-m-d H:i:s", time() - $this->quiz_time))->count() > 0) {
                $quizresult = $resultset->where('created_at' , '>' , date("Y-m-d H:i:s", time() -           $this->quiz_time))
                                ->sortByDesc('created_at')
                                ->first();
                $endtime = date("Y-m-d H:i:s" , (strtotime($quizresult->created_at) + $this->quiz_time));

            } else {
                $quizresult = new QuizResult;
                $quizresult->play_unique = $quizresult->getResultUnique();
                $quizresult->quiz_unique = $quiz->quiz_unique;
                $quizresult->player_user_unique = $request->player_user_unique;
                $quizresult->completed_question = 0;
                $quizresult->save();

                $endtime = date("Y-m-d H:i:s" , (time() + $this->quiz_time));
            }

            $play_unique = $quizresult->play_unique;

            $question = Question::where('quiz_unique' , '=' , $quiz_unique)
                        ->where('question_number' , '=' , 1)
                        ->first();

            $options = Option::where('question_unique' , '=' , $question->question_unique)
                        ->orderBy('id' , 'asc')
                        ->get();

        } else if(sizeof($result) > 0) {
            
            if($request->continue_quiz !== true) {
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
        
        $data = array('quiz' => $quiz,
            'question' => $question,
            'options' => $options,
            'endtime' => $endtime,
            'play_unique' => $play_unique,
            'present_time' => date("Y-m-d H:i:s")
        );
        return response()->json($data);
    }

    public function showResult($quiz_slug , $play_unique) {

        $quiz = Quiz::where('quiz_slug' , '=' , $quiz_slug)
                ->firstOrFail();

        $result = QuizResult::where('quiz_unique' , '=' , $quiz->quiz_unique)
                    ->where('play_unique' , '=' , $play_unique)
                    ->where('status' , '=' , 1)
                    ->firstOrFail();

        return view('quiz.result' , compact('quiz' , 'result'));
    }
}
