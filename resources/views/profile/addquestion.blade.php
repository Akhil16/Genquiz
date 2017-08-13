@extends('profile')

@section('style')

	<style type="text/css">
		
	</style>
@endsection

@section('content')

	<div class="container">
		<h1 class="text-center">Quiz Title : {{ $quiz->title }}</h1>
		<div class="well">
			@if(isset($questions) && sizeof($questions) > 0)
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th>#</th>
						    <th>Question</th>
						    <th>Question Type</th>
						    <th>Edit Question</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($questions as $q)
						    <tr>
						    	<th scope="row" class="col-md-1">{{ $count++ }}</th>
						    	<td class="col-md-7">{{ ucwords($q->question) }}</td>
						      	<td class="col-md-2">{{ ucwords($q->question_type) }}</td>
						      	<td class="col-md-2"><a class="btn btn-info">Edit</a></td>
						    </tr>
						@endforeach
					</tbody>
				</table>
			@else
				<h1 class="text-center">No Questions Yet</h1>
			@endif
		</div>
	
		<div class="well">
			@if(session()->has('message'))
				<div class="alert alert-success">
				    <strong>{{ session()->get('message') }}</strong>
				</div>
			@endif
			<h1>Add New Question</h1>
			<form action="{{ url('profile/save-question') }}" method="post" id="add-question-form">
				<div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}" id="question_div">
				    <label>Question {{ $quiz->num_ques + 1 }}</label>
				    <input type="text" class="form-control" name="question">
				</div>

				<div id="question_feedback" style="display: none;">
				</div>

				@if ($errors->has('question'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('question') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('question_type') ? 'has-error' : '' }}">
				    <label>Question Type</label>
				    <select class="form-control" name="question_type" id="question_type">
				    	<option value="single choice" selected>Single Choice</option>
				    	<option value="multiple choice">Multiple Choice</option>
				    	<option value="text">Text</option>
				    </select>
				</div>

				<div class="form-group"  id="options-list-div">
					<label>Options :</label>
					<table class="table">
						<thead>
							<tr>
								<th>Content</th>
								<th>Answer</th>
								<th>Delete Option</th>
							</tr>
						</thead>
						<tbody id="options-list">
							<tr id="row_option_a" class="options-list-row">
								<td><input class="form-control option-input" type="text" name="option[]" placeholder="Please Enter Something" maxlength="80" value=""></td>
								<td><input class="form-check-input answer-radio" type="radio" name="radio" value="a" checked><input class="form-check-input answer-checkbox" type="checkbox" value="a" style="display: none;" disabled="disabled" checked></td>
								<td><button class="btn btn-warning delete-option-btn" value="a">Delete</button></td>
							</tr>
							<tr id="add-option-row">
								<td><button class="btn btn-primary" id="add-option-btn">Add Option</button></td>
							</tr>
						</tbody>
					</table>
					<div id="option_feedback"></div>
				</div>

				<div class="form-group" id="text-answer-div"  style="display: none;">
					<label>Answer</label>
					<input type="text" class="form-control" id="text-answer" value="">
				</div>

				<div id="answer_feedback"></div>

				<input type="hidden" name="answer" value="">
				<input type="hidden" name="num_ques" value="{{ $quiz->num_ques }}">
				<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
				{{ csrf_field() }}
				<input type="submit" id="add-question-form-btn" class="btn btn-danger" value="Add Question">
			</form>
		</div>
	</div>
@endsection

@section('scripts')

<script type="text/javascript">

	var question_valid = false;
	var option_valid = false;
	var answer_valid = false;
	var bg_green = '#DCEDC8';
    var bd_green = '#81C784';
    var bg_red = '#ffcdd2';
    var bd_red = '#a94442';

	$(document).ready(function(){
		
		var answer = "";
		var option_count = 1;
		var char_val = 98;
		var i;
		
		$('#add-option-btn').on('click' , function() {
			
			option_count++;

			$("<tr id='row_option_" + String.fromCharCode(char_val) + "' class='options-list-row'><td><input class='form-control option-input' type='text' name='option[]' placeholder='Please Enter Something'></td><td><input class='form-check-input answer-radio' type='radio' name='radio' value='" + String.fromCharCode(char_val) + "'><input class='form-check-input answer-checkbox' type='checkbox' style='display: none;' disabled='disabled' value='" + String.fromCharCode(char_val) + "'></td><td><button class='btn btn-warning delete-option-btn' value='" + String.fromCharCode(char_val) + "'>Delete</button></td></tr>").insertBefore($('#add-option-row'));

			if(option_count >= 4) {
				$(this).css('display' , 'none');
			}

			i = 97;
			$('.options-list-row').each(function() {
				$(this).children().eq(1).children().val(String.fromCharCode(i));
				$(this).children().eq(i - 97).attr('id' , 'row_option_' + String.fromCharCode(i));
				i++;
			});

			char_val++;

			if($('#question_type').val() == "single choice"){
				$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
				$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
			} else {
				$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
				$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
			}	
						
		});

		$('#options-list').on('click' , '.delete-option-btn' , function(){

			if(option_count > 1) {
				$('#row_option_' + $(this).val()).remove();
				option_count--;
			}

			if(option_count <= 4) {
				$('#add-option-btn').css('display' , 'block');
			}

			i = 97;
			$('.options-list-row').each(function() {
				$(this).children().eq(1).children().val(String.fromCharCode(i));
				$(this).children().eq(i - 97).attr('id' , 'row_option_' + String.fromCharCode(i));
				i++;
			});
		});

		$('#question_type').on('change' , function() {
			
			if($(this).val() == "text"){
				$('#options-list-div').slideUp();
				$('#text-answer-div').slideDown();
				$('.option-input').attr('disabled' , 'true');
			} else {
				$('#options-list-div').slideDown();
				if($(this).val() == "single choice"){
					$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
					$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
				} else {
					$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
					$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
				}
				$('#text-answer-div').slideUp();
				$('.option-input').removeAttr('disabled');
			}
						
		});

		$('#add-question-form').on('submit' , function(event) {

		    event.preventDefault();
		});


		$('#add-question-form-btn').on('click' , function(){
			
			validateQuestion();
			validateOptions();
			validateAnswer();

			if(question_valid && option_valid && answer_valid)
				$('#add-question-form').unbind('submit').submit();
		});

		$('input[name=question]').on('blur' , function(){
			validateQuestion();
		});

		$('#options-list').on('blur' , '.option-input' , function(){
			validateOptions();
		});

	});

	function validateQuestion() {

		var question = $('input[name=question]').val();
		if(question.length == 0) {
		    question_valid = false;
		    implement_error('question_div','question_feedback',$('input[name=question]'),'Required');
		} else {
		    question_valid = true;
		    implement_success('question_div','question_feedback',$('input[name=question]'));
		}
	}

	function validateOptions() {

		option_valid = true;
		if($('#question_type').val() !== "text") {
			$('.option-input').each(function(){
				if($(this).val().length == 0) {
				    option_valid = false;
				    $(this).css("border-color",bd_red);
				    $(this).css("background",bg_red);
				} else {
					$(this).css("border-color",bd_green);
		    		$(this).css("background",bg_green);
				}
			});

			if(option_valid == false) {
			    $("#option_feedback").text("All Fields Required").removeClass().addClass('alert alert-danger').show();
			} else {
				$("#option_feedback").text("").removeClass().hide();
			}
		}
	}

	function validateAnswer() {

		answer_valid = true;
		answer = "";
		if($('#question_type').val() == "single choice"){
			answer = $('.answer-radio:checked').val();
		} else if($('#question_type').val() == "multiple choice"){
			$(".answer-checkbox:checked").each(function(){
				answer += $(this).val() + ",";
			});
			answer = answer.substr(0 , answer.length - 1);
		} else {
			answer = $('#text-answer').val();
		}

		if(answer == null || answer == "") {

			answer_valid = false;
			$("#answer_feedback").text("Answer Required").removeClass().addClass('alert alert-danger').show();
			if($('#question_type').val() == "text") {
				$('#text-answer-div').removeClass().addClass('form-group has-error');
				$('#text-answer').css("border-color",bd_red);
				$('#text-answer').css("background",bg_red);
			}
		} else {
			answer_valid = true;
			$("#answer_feedback").text("").removeClass().hide();
			if($('#question_type').val() == "text") {
				$('#text-answer-div').removeClass().addClass('form-group');
				$('#text-answer').css("border-color",bd_green);
	    		$('#text-answer').css("background",bg_green);
			}
		}

		if(answer_valid == true) {
			$('input[name=answer]').val(answer);
		}
	}

	function implement_error(element_div,element_feedback,element,error_message,cls) {
	    cls = cls ? cls : "";
	    $('#' + element_div).removeClass().addClass('form-group has-error ' + cls);
	    $(element).css("border-color",bd_red);
	    $(element).css("background",bg_red);
	    $("#" + element_feedback).text(error_message).removeClass().addClass('alert alert-danger').show();
	}

	function implement_success(element_div,element_feedback,element,cls) {
	    cls = cls ? cls : "";
	    $('#' + element_div).removeClass().addClass('form-group ' + cls);
	    $(element).css("border-color",bd_green);
	    $(element).css("background",bg_green);
	    $("#" + element_feedback).text("").removeClass().hide();
	}

</script>
@endsection