@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		@if(sizeof($categories) > 0)
			<div class="brick table-responsive">
				<table class="table table-striped">
					<thead>
					    <tr>
						    <th class="col-md-1">#</th>
						    <th class="col-md-9">Name</th>
						    <th class="col-md-2">Edit Category</th>
					    </tr>
					</thead>
				  	<tbody>
				  		<?php $count = 1; ?>
				  		@foreach($categories as $c)
						    <tr>
						    	<td scope="row"  class="col-md-1">{{ $count++ }}</td>
						    	<td class="col-md-9">{{ ucwords($c->name) }}</td>
						      	<td class="col-md-2"><a class="btn btn-warning" href="{{ url('profile/edit-category/' . $c->id) }}">Edit</a></td>
						    </tr>
						@endforeach
					</tbody>
				</table>

				<div class="text-center">{{ $categories->links() }}</div>
			</div>
		@else
			<div class="alert alert-danger">No Categories Yet</div>
		@endif
	</div>
@endsection