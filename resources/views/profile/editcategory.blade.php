@extends('layouts.app')

@section('style')
	<style type="text/css">
		body {
			color: #000;
		}
	</style>
@endsection

@section('content')
	<div class="container-fluid">		
		<div class="bg-theme padding_25 mb">
			@if(session()->has('message'))
				<div class="alert alert-success">
				    <strong>{{ session()->get('message') }}</strong>
				</div>
			@endif
			<h1>Edit Category</h1>
			<form action="{{ url('profile/update-category') }}" method="post">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
				    <label>Category Name</label>
				    <input type="text" class="form-control" name="name" maxlength="120" value="{{ ucwords($category->name) }}">
				</div>

				@if ($errors->has('name'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('name') }}</strong>
				    </div>
				@endif

				{{ csrf_field() }}
				<input type="submit" class="btn btn-danger" value="Update Category">
			</form>
		</div>
	</div>
@endsection