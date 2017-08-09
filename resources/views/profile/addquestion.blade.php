@extends('profile')

@section('style')

	<style type="text/css">
		
	</style>
@endsection

@section('content')
<?php 
	$question_count = $quiz->num_ques + 1; 
?>
	<div class="container">
		<h1 class="text-center">Quiz Title : {{ $quiz->title }}</h1>
		<div class="well">
			@if(isset($questions) && sizeof($questions) > 0)
				<table class="table table-striped table-inverse">
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
						      	<td class="col-md-2"><a class="btn btn-info">Edit Question</a></td>
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
				<div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
				    <label>Question {{ $question_count }}</label>
				    <input type="text" class="form-control" name="question" required>
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

				<div class="form-group" id="no_of_options_div">
				    <label>Number of Options</label>
				    <select class="form-control" id="no_of_options">
				    	<option value="1" selected>1</option>
				    	<option value="2">2</option>
				    	<option value="3">3</option>
				    	<option value="4">4</option>
				    </select>
				</div>

				<div class="form-group"  id="options-list-div">
					<label>Options :</label>
					<table class="table">
						<thead>
							<tr>
								<th>Option</th>
								<th>Content</th>
								<th>Answer</th>
							</tr>
						</thead>
						<tbody id="options_list">
							<tr>
								<td class="option-char">a</td>
								<td><input class="form-control option-input" type="text" name="option[]" placeholder="Please Enter Something" required></td>
								<td><input class="form-check-input answer-radio" type="radio" name="radio" value="a" checked><input class="form-check-input answer-checkbox" type="checkbox" value="a" style="display: none;" disabled="disabled" checked></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="form-group" id="text-answer-div"  style="display: none;">
					<label>Answer</label>
					<input type="text" class="form-control" id="text-answer" value="">
				</div>

				<input type="hidden" name="answer" value="">
				<input type="hidden" name="question_number" value="{{ $question_count }}">
				<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
				{{ csrf_field() }}
				<input type="submit" class="btn btn-danger" value="Add Question">
			</form>
		</div>
	</div>
@endsection

@section('scripts')

<script type="text/javascript">

	$(document).ready(function(){
		
		var answer = "";
		var option_count = 97;
		$('#no_of_options').on('change' , function() {
			
			$('#options_list').empty();
			
			option_count = 97;
			var checkcond = "";			

			for(var i = 1; i <= $(this).val(); i++){

				if(i == 1)
					checkcond = "checked";
				else
					checkcond = "";

				$('#options_list').append("<tr><td class='option-content'>" + String.fromCharCode(option_count) + "</td><td><input class='form-control option-input' type='text' name='option[]' placeholder='Please Enter Something' required></td><td><input class='form-check-input answer-radio' type='radio' name='radio' value='" + String.fromCharCode(option_count) + "'" + checkcond + "><input class='form-check-input answer-checkbox' type='checkbox' style='display: none;' disabled='disabled' value='" + String.fromCharCode(option_count++) + "'" + checkcond + "></td></tr>");
			}

			if($('#question_type').val() == "single choice"){
				$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
				$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
			} else {
				$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
				$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
			}	
						
		});

		$('#question_type').on('change' , function() {
			
			if($(this).val() == "text"){
				$('#no_of_options_div').slideUp();
				$('#options-list-div').slideUp();
				$('#text-answer-div').slideDown();
				$('.option-input').removeAttr('required');
			} else {
				$('#no_of_options_div').slideDown();
				$('#options-list-div').slideDown();
				if($(this).val() == "single choice"){
					$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
					$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
				} else {
					$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
					$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
				}
				$('#text-answer-div').slideUp();
				$('.option-input').attr('required' , 'required');
			}
						
		});

		$('#add-question-form').on('submit' , function(evt){

			evt.preventDefault();
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
			$('input[name=answer]').val(answer);
			$(this).unbind('submit').submit();
		});
	});
</script>
@endsection