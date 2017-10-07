@extends('layouts.app')

@section('style')
	<style type="text/css">
		.share-text {
			display: none;
		}
	</style>
@endsection

@section('content')
	<div class="container-fluid">
		@if(sizeof($quiz) > 0)
			<div class="well table-responsive">
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th class="col-md-1">#</th>
						    <th class="col-md-2">Title</th>
						    <th class="col-md-4">Description</th>
						    <th class="col-md-1">No. of Questions</th>
						    <th class="col-md-1">Edit Quiz</th>
						    <th class="col-md-1">Add Questions</th>
						    <th class="col-md-1">Quiz Results</th>
						    <th class="col-md-1">Share Link</th>
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
						      	<td class="col-md-1"><a class="btn btn-warning" href="{{ url('profile/edit-quiz/' . $q->quiz_unique) }}">Edit</a></td>
						      	<td class="col-md-1"><a class="btn btn-primary" href="{{ url('profile/add-question/' . $q->quiz_unique) }}">Add</a></td>
						      	<td class="col-md-1"><a class="btn btn-danger" href="{{ url('profile/result/quiz/' . $q->quiz_slug) }}">View</a></td>
						      	<td class="col-md-1"><span class="share-text">{{ url('/quiz/' . $q->quiz_slug) }}</span><button class="btn btn-primary pull-right share-btn">Copy</button></td>
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

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {

			$('.share-btn').on('click' , function(){

				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val($(this).parent().find('.share-text').text()).select();
				document.execCommand("copy");
				$temp.remove();
				$(this).removeClass('btn-primary').addClass('btn-danger').text('Copied..!');
			});
		});
	</script>
@endsection