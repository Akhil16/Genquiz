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
		@else
			<div class="alert alert-danger">No Quizzes Yet</div>
		@endif
	</div>
@endsection