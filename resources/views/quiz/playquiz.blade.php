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
		<div class="well">
			<h3><strong>Q {{ $question->question_number }}.</strong> {{ $question->question }}</h3>
			@if($question->question_type == "text")
				<div class="form-group">
					<input class="form-control" type="text" id="text-answer">
					<input type="hidden" value="{{ $options[0]->option_content }}" id="text-answer-content">
				</div>
			@else
				<ul  class="list-group">
					@foreach($options as $opt)
						<a href="" onclick="event.preventDefault();"><li class="list-option list-group-item list-group-item-info" id="{{ $opt->option_unique }}">{{ $opt->option_content }}</li></a>
						<br>
					@endforeach
				</ul>
			@endif
			<button class="btn btn-danger" id="submit-quiz-btn">Submit</button>

			<form method="post" id="quiz-submit-form">
				<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
				<input type="hidden" name="play_unique" value="{{ $play_unique }}">
				<input type="hidden" name="question_number" value="{{ $question->question_number }}">
				<input type="hidden" name="endtime" value="{{ $endtime }}">
				<input type="hidden" name="answer" value="true">
			</form>
		</div>
		<p id="countdown-timer"></p>
	</div>
@endsection

@section('scripts')
	
	<script>
	// Set the date we're counting down to
	var countDownDate = new Date({{ $endtime }} * 1000).getTime();
	var i = 0;
	// Update the count down every 1 second
	var x = setInterval(function() {

	    // Get todays date and time
	    var now = new Date({{ time() }} * 1000).getTime() + (i++ * 1000);
	    
	    // Find the distance between now an the count down date
	    var distance = countDownDate - now;
	    // Time calculations for days, hours, minutes and seconds
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    
	    // Output the result in an element with id="demo"
	    $("#countdown-timer").text(minutes + "m " + seconds + "s");
	    
	    // If the count down is over, write some text 
	    if (distance < 0) {
	        clearInterval(x);
	        $("#submit-quiz-btn").click();
	    }
	}, 1000);

	$(document).ready(function() {

		var question_type = "{{ $question->question_type }}";
		var answer = "{{ $question->answer }}";
		var answer_status = "negative";
		var answer_str = "";

		$('#quiz-submit-form').on('submit' , function(evt) {
			evt.preventDefault();
		});

		$('#submit-quiz-btn').on('click' , function() {

			answer_status = "negative";
			answer_str = "";

			if(question_type == "single choice") {
				if($('.list-option.selected').attr('id') == answer) {
					answer_status = "positive";
				}
			} else if(question_type == "multiple choice") {
				$('.list-option.selected').each(function() {
					answer_str += $(this).attr('id') + ",";
				});
				answer_str = answer_str.substr(0 ,answer_str.length - 1);
				if(answer_str == answer) {
					answer_status = "positive";
				}
			} else {
				if($('#text-answer').val().toLowerCase() == $('#text-answer-content').val().toLowerCase()) {
					answer_status = "positive";
				}
			}
			$('input[name=answer]').val(answer_status);
			$('#quiz-submit-form').unbind('submit').submit();
		});

		$('.list-option').on('click' , function() {

			if(question_type == "single choice") {

				$('.list-option').removeClass('list-group-item-success selected').addClass('list-group-item-info');

				$(this).removeClass('list-group-item-info').addClass('list-group-item-success selected');

			} else if(question_type == "multiple choice") {
				if($(this).hasClass('selected')) {
					$(this).removeClass('list-group-item-success selected').addClass('list-group-item-info');
				} else {
					$(this).removeClass('list-group-item-info').addClass('list-group-item-success selected');
				}
			}
		});
	});
	</script>
@endsection