@extends('layouts.app')

@section('style')
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<style type="text/css">
		body {
			font-family: 'Oswald', sans-serif;
			font-size: 18px;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="well">
			<div class="row">
				<div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-12">
					<img class="img-thumbnail" src="{{ URL::asset('uploads/quizcover/' . $quiz->quiz_cover) }}" alt="{{ ucwords($quiz->title) . ',' . ucwords($quiz->description) }}"  style="height: 180px; width: 120px;">
				</div>
				<div  class="col-md-9 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-12">
							<strong>Title</strong>
						</div>
						<div class="col-md-9 col-sm-12 col-xs-12">
							{{ ucwords($quiz->title) }}
						</div>
						<div class="col-xs-12">&nbsp;</div>
					</div>
					<div class="row">
						<div class="col-md-2 col-md-offset-1  col-sm-12 col-xs-12">
							<strong>Description</strong>
						</div>
						<div class="col-md-9  col-sm-12 col-xs-12">
							{{ $quiz->description }}
						</div>
						<div class="col-xs-12">&nbsp;</div>
					</div>
					<div class="row">
						@if(sizeof($result) > 0)
							<button class="btn btn-danger col-md-10 col-md-offset-1 col-sm-12 col-xs-12" onclick="document.getElementById('start-quiz-form').submit();">Continue Quiz</button>
						@else
							<button class="btn btn-primary col-md-10 col-md-offset-1 col-sm-12 col-xs-12" onclick="document.getElementById('start-quiz-form').submit();">Start Quiz</button>
						@endif
						<div class="col-md-1"></div>
						<form id="start-quiz-form" action="{{ url('quiz/play' , [ $quiz->quiz_slug ]) }}" method="post">
							<input type="hidden" name="player_user_unique" value="{{ Auth::user()->user_unique }}">
							<input type="hidden" name="created_user_unique" value="{{ $quiz->user_unique }}">
							<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
							@if(sizeof($result) > 0)
								<input type="hidden" name="endtime" value="{{ strtotime($result->created_at) + 3600 }}">
								<input type="hidden" name="question_number" value="{{ $result->completed_question }}">
								<input type="hidden" name="play_unique" value="{{ $result->play_unique }}">
								<input type="hidden" name="continue_quiz" value="true">
							@endif
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
@endsection