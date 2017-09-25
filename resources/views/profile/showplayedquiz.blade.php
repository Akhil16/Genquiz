@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		@if(sizeof($playedquiz) > 0)
			<div class="well table-responsive">
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th class="col-md-1">#</th>
						    <th class="col-md-3">Title</th>
						    <th class="col-md-4">Image</th>
						    <th class="col-md-2">Max Score</th>
						    <th class="col-md-2">Play Again</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($playedquiz as $pq)
						    <tr>
						    	<td scope="row" class="col-md-1">{{ $count++ }}</td>
						    	<td class="col-md-3">{{ ucwords($pq->quiz->title) }}</td>
						      	<td class="col-md-4"><img class="img-thumbnail" src="{{ URL::asset('uploads/quizcover/' . $pq->quiz->quiz_cover) }}" alt="{{ ucwords($pq->quiz->title) . ',' . ucwords($pq->quiz->description) }}"  style="height: 180px; width: 120px;"></td>
						      	<td class="col-md-2">{{ $pq->score }}</td>
						      	<td class="col-md-2"><a class="btn btn-warning" href="{{ url('quiz/' . $pq->quiz->quiz_slug) }}">Play</a></td>
						    </tr>
						@endforeach
					</tbody>
				</table>

				<div class="text-center">{{ $playedquiz->links() }}</div>
			</div>
		@else
			<div class="alert alert-danger">No Quizzes Played Yet</div>
		@endif
	</div>
@endsection