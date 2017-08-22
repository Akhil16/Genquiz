@extends('layouts.app')

@section('style')
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<style type="text/css">
		body {
			font-family: 'Oswald', sans-serif;
			font-size: 18px;
		}
		ul > a {
			text-decoration: none;
		}
		ul > a:link {
		    text-decoration: none;
		}

		ul > a:visited {
		    text-decoration: none;
		}

		ul > a:hover {
		    text-decoration: none;
		}

		ul > a:active {
		    text-decoration: none;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div id="quiz-well">
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
				              <button class="btn btn-danger col-md-10 col-md-offset-1 col-sm-12 col-xs-12"  id="start-quiz-btn">Continue Quiz</button> 
				            @else 
				              <button class="btn btn-primary col-md-10 col-md-offset-1 col-sm-12 col-xs-12"  id="start-quiz-btn">Start Quiz</button> 
				            @endif 
							<form id="start-quiz-form" method="post">
							@if(Auth::check())
								<input type="hidden" name="player_user_unique" value="{{ Auth::user()->user_unique }}">
								@if(sizeof($result) > 0) 
					               <input type="hidden" name="endtime" value="{{ date('Y-m-d H:i:s' , (strtotime($result->created_at) + $quiztime)) }}"> 
					               <input type="hidden" name="question_number" value="{{ $result->completed_question }}"> 
					               <input type="hidden" name="play_unique" value="{{ $result->play_unique }}"> 
					               <input type="hidden" name="continue_quiz" value="true"> 
					             @endif 
							@endif
								<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	
	<script>
		var start_quiz_url = "{{ url('quiz/play/' . $quiz->quiz_slug) }}";
		var result_base_url = "{{ url('result/quiz') }}" + "/"; 
	</script>
	<script type="text/javascript" src="{{ URL::asset('js/playquiz.min.js') }}"></script>
@endsection