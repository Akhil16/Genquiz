@extends('profile')

@section('content')
	<div class="container">
		@if(isset($quiz))
			<div class="well">
				<table class="table table-striped table-inverse">
					<thead>
					    <tr>
						    <th>#</th>
						    <th>Title</th>
						    <th>Description</th>
						    <th>No. of Questions</th>
						    <th>Add Questions</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($quiz as $q)
						    <tr>
						    	<th scope="row" class="col-md-1">{{ $count++ }}</th>
						    	<td class="col-md-2">{{ ucwords($q->title) }}</td>
						      	<td class="col-md-5">{{ $q->description }}</td>
						      	<td class="col-md-2">{{ $q->num_ques }}</td>
						      	<td class="col-md-2"><a class="btn btn-info">Add Question</a></td>
						    </tr>
						@endforeach
					</tbody>
				</table>

				<div class="text-center">{{ $quiz->links() }}</div>
			</div>
		@endif
		<div class="well">
			@if(session()->has('message'))
				<div class="alert alert-success">
				    <strong>{{ session()->get('message') }}</strong>
				</div>
			@endif
			<h1>Add New Quiz</h1>
			<form action="{{ url('profile/save-quiz') }}" method="post">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
				    <label>Quiz Title</label>
				    <input type="text" class="form-control" name="title" maxlength="40">
				</div>

				@if ($errors->has('title'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('title') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
				    <label>Quiz Title</label>
				    <textarea class="form-control" name="description">
				    </textarea>
				</div>

				@if ($errors->has('description'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('description') }}</strong>
				    </div>
				@endif

				<input type="hidden" name="user_unique" value="{{ Auth::user()->user_unique }}">
				{{ csrf_field() }}
				<input type="submit" class="btn btn-danger" value="Add Quiz">
			</form>
		</div>
	</div>
@endsection