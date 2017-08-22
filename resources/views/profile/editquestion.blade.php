@extends('profile')

@section('style')

	<style type="text/css">
		
	</style>
@endsection

@section('content')

	<div class="container">
		<h1 class="text-center">Quiz Title : {{ $quiz->title }}</h1>
			
		<div class="well">
			@if(session()->has('message'))
				<div class="alert alert-success">
				    <strong>{{ session()->get('message') }}</strong>
				</div>
			@endif
			<h1>Edit Question</h1>
			<form action="{{ url('profile/update-question') }}" method="post" id="add-question-form">
				<div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}" id="question_div">
				    <label>Question {{ $question->question_number }}</label>
				    <input type="text" class="form-control" name="question" value="{{ $question->question }}">
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
				    	<option value="single choice" @if($question->question_type == "single choice") selected @endif>Single Choice</option>
				    	<option value="multiple choice" @if($question->question_type == "multiple choice") selected @endif>Multiple Choice</option>
				    	<option value="text" @if($question->question_type == "text") selected @endif>Text</option>
				    </select>
				</div>

				<div class="form-group"  id="options-list-div" @if($question->question_type == "text") style="display : none;" @endif>
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
							<?php  $char_val = 97; ?> 
							@if($question->question_type !== "text")
								@foreach($options as $opt)
									<tr id="row_option_{{ chr($char_val) }}" class="options-list-row">
										<td><input class="form-control option-input" type="text" name="option[]" placeholder="Please Enter Something" maxlength="80" value="{{ $opt->option_content }}"></td>
										<td><input class="form-check-input answer-radio" type="radio" name="radio" value="{{ chr($char_val) }}" @if($question->question_type !== "single choice") style="display : none;" disabled="disabled" @endif @if(strpos($question->answer , $opt->option_unique) !== false) checked @endif><input class="form-check-input answer-checkbox" type="checkbox" value="{{ chr($char_val) }}" @if($question->question_type !== "multiple choice") style="display : none;" disabled="disabled" @endif 
										@if(strpos($question->answer , $opt->option_unique) !== false) checked @endif></td>
										<td><button class="btn btn-warning delete-option-btn" value="{{ chr($char_val) }}">Delete</button></td>
									</tr>
									<?php
										$char_val++; 
									?> 
								@endforeach
							@else
								<tr id="row_option_a" class="options-list-row">
									<td><input class="form-control option-input" type="text" name="option[]" placeholder="Please Enter Something" maxlength="80" value=""></td>
									<td><input class="form-check-input answer-radio" type="radio" name="radio" value="a" checked><input class="form-check-input answer-checkbox" type="checkbox" value="a" style="display: none;" disabled="disabled" checked></td>
									<td><button class="btn btn-warning delete-option-btn" value="a">Delete</button></td>
								</tr>
								<?php  
									$char_val++; 
								?>
							@endif
							<tr id="add-option-row">
								<td><button class="btn btn-primary" id="add-option-btn" @if(($char_val - 97) == 4) style="display: none;" @endif>Add Option</button></td>
							</tr>
						</tbody>
					</table>
					<div id="option_feedback"></div>
				</div>

				<div class="form-group" id="text-answer-div"  @if($question->question_type !== "text") style="display : none;" @endif>
					<label>Answer</label>
					<input type="text" class="form-control" id="text-answer" 
					value="<?php if($question->question_type == 'text')  echo $options[0]->option_content; ?>">
				</div>

				<div id="answer_feedback"></div>

				<input type="hidden" name="answer" value="">
				<input type="hidden" name="quiz_unique" value="{{ $quiz->quiz_unique }}">
				<input type="hidden" name="question_unique" value="{{ $question->question_unique }}">
				{{ csrf_field() }}
				<input type="submit" id="add-question-form-btn" class="btn btn-danger" value="Update Question">
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/addquestion.min.js') }}"></script>
@endsection