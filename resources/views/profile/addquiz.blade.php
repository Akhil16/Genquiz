@extends('profile')

@section('content')
	<div class="container">
		@if(isset($quiz))
			<div class="well table-responsive">
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th class="col-md-1">#</th>
						    <th class="col-md-2">Title</th>
						    <th class="col-md-4">Description</th>
						    <th class="col-md-1">No. of Questions</th>
						    <th class="col-md-2">Edit Quiz</th>
						    <th class="col-md-2">Add Questions</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($quiz as $q)
						    <tr>
						    	<td scope="row" class="col-md-1">{{ $count++ }}</td>
						    	<td class="col-md-2">{{ ucwords($q->title) }}</td>
						      	<td class="col-md-4">{{ $q->description }}</td>
						      	<td class="col-md-1">{{ $q->num_ques }}</td>
						      	<td class="col-md-2"><a class="btn btn-warning" href="{{ url('profile/edit-quiz/' . $q->quiz_unique) }}">Edit</a></td>
						      	<td class="col-md-2"><a class="btn btn-primary" href="{{ url('profile/add-question/' . $q->quiz_unique) }}">Add</a></td>
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
			<form action="{{ url('profile/save-quiz') }}" method="post" enctype="multipart/form-data">
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
				    <label>Quiz Description</label>
				    <textarea class="form-control" name="description">
				    </textarea>
				</div>

				@if ($errors->has('description'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('description') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('quiz_cover') ? 'has-error' : '' }}">
				    <label>Quiz Cover (optional)</label>
				    <input type="file" name="quiz_cover" class="form-control">
				</div>

				@if ($errors->has('quiz_cover'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('quiz_cover') }}</strong>
				    </div>
				@endif

				<input type="hidden" name="user_unique" value="{{ Auth::user()->user_unique }}">
				{{ csrf_field() }}
				<input type="submit" class="btn btn-danger" value="Add Quiz">
			</form>
		</div>
	</div>
@endsection