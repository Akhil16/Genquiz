@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		
			<h1 class="text-center">
				Quiz Title : {{ $quiz->title }}
			</h1>
			<div class="row">
				<div class="col-md-8"><h2 class="text-center" style="color: #f06868;">@if(isset($search)) Search Results : {{ $search }} @endif</h2></div>
				<div class="col-md-4 brick">
					<form action="{{ url('profile/result/quiz/' . $quiz->quiz_slug) }}" method="get">
						<div class="input-group">
							<input type="text" class="form-control" name="search" placeholder="Search">
							<span class="input-group-addon"  style="background : white !important;">
								<button type="submit"  style="border : 0; background : transparent;">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		@if(sizeof($results) > 0)
			<div class="brick table-responsive">
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th class="col-md-1">#</th>
						    <th class="col-md-2">Player Name</th>
						    <th class="col-md-2">UserName</th>
						    <th class="col-md-4">Email</th>
						    <th class="col-md-1">Score</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($results as $r)
						    <tr>
						    	<td scope="row" class="col-md-1">{{ $count++ }}</td>
						    	<td class="col-md-2">{{ ucwords($r->name) }}</td>
						    	<td class="col-md-2">{{ $r->username }}</td>
						      	<td class="col-md-4">{{ $r->email }}</td>
						      	<td class="col-md-1">{{ $r->score }}%</td>
						    </tr>
						@endforeach
					</tbody>
				</table>

				<div class="text-center">{{ $results->links() }}</div>
			</div>
		@else
			<div class="alert alert-danger">No Results to Show</div>
		@endif
	</div>
@endsection