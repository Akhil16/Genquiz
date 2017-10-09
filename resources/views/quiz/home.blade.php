<?php
    $title = $quiz->title;
    $description = $quiz->description;
    $keywords = "quiz, " . $title . " " . $description;
    $author = "Genquiz";
    $url = "http://genquiz.tk";
    $site_name = "genquiz.tk";
    if($quiz->quiz_cover !== "quiz-default-cover.png") {
    	$image_url = url('/images/' . $quiz->quiz_cover);
    }
?>
@extends('layouts.app')

@section('style')
	<style type="text/css">
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
		.selected{
			color: #666;
			position: relative;
		    display: block;
		    padding: 10px 15px;
		    background-color: #fff;
	        border: 1px solid #f1a909;
	        box-shadow: 0 0 20px 2px #f1a909;
		}

		.list-group-item-correct{
			background-color: #47f449;
			border: 2px solid steelblue;
			box-shadow: 0 0 20px 2px #428bca;			
		}
	</style>
@endsection

@section('content')
	<div class="container-fluid mt">
		<div id="quiz-well">
			<div class="bg-theme padding_25">
				<div class="row">
					<div class="col-md-2 col-md-offset-1 col-sm-6 col-xs-6 mb">
								<img class="img-thumbnail" src="{{ URL::asset('uploads/quizcover/' . $quiz->quiz_cover) }}" alt="{{ ucwords($quiz->title) . ',' . ucwords($quiz->description) }}"  style="height: 180px; width: 120px;
								border: 5px solid #666; box-shadow: 0 0 15px #666;">
							</div>
							<div  class="col-md-9 col-sm-6 col-xs-6">
								<div class="row">
									<div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-12">
										<strong>Title:</strong>
									</div>
									<div class="col-md-9 col-sm-12 col-xs-12">
										{{ ucwords($quiz->title) }}
									</div>
									<div class="col-xs-12">&nbsp;</div>
								</div>
								<div class="row">
									<div class="col-md-2 col-md-offset-1  col-sm-12 col-xs-12">
										<strong>Description:</strong>
									</div>
									<div class="col-md-9  col-sm-12 col-xs-12" style="text-overflow:ellipsis;overflow:hidden;height: 70px;">
										{{ $quiz->description }}
									</div>
							<div class="col-xs-12">&nbsp;</div>
						</div>
					</div>
					<div class="row mt">
						<div class="col-md-10 col-md-offset-1 col-xs-12">
							@if(sizeof($result) > 0) 
				              <button class="btn btn-danger btn-block"  id="start-quiz-btn">Continue Quiz</button> 
				            @else 
				              <button class="btn btn-primary btn-block"  id="start-quiz-btn">Start Quiz</button> 
				            @endif 
						</div>
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

	@if($quiz->public == 0 && !Auth::check())
		<div id="privatemodal" class="modal fade" role="dialog">
		  <div class="modal-dialog" style="padding-top: 100px;">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header bg-theme04">
		        <h4 class="modal-title text-center">Warning! Private Quiz</h4>
		      </div>
		      <div class="modal-body">
		        <p>This is a private quiz. Please <a href="{{ route('login') }}" id="login-btn">Login</a> to continue.</p>
		        
		      </div>
		    </div>

		  </div>
		</div>
	@endif
@endsection

@section('scripts')
	
	<script>
		var start_quiz_url = "{{ url('quiz/play/' . $quiz->quiz_slug) }}";
		var result_base_url = "{{ url('result/quiz') }}" + "/"; 
	</script>
	<script type="text/javascript" src="{{ URL::asset('js/playquiz.min.js') }}"></script>
	@if($quiz->public == 0 && !Auth::check())
		<script type="text/javascript">
			$(window).on('load',function(){
		        $('#privatemodal').modal('show');
		    });

		    $(document).ready(function(){
		    	$('#privatemodal').modal({
		          backdrop: 'static',
		          keyboard: false
		        });

		        $('#login-btn').on('click' , function() {
		        	$(this).unbind('click').click();
		        });

		        $('#start-quiz-form').remove();
		    });
		</script>
	@endif
@endsection