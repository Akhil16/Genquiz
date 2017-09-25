@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<h1 style="text-align: center;color: rgba(242, 58, 58, 0.84);
		"> Step: 1</h1>
		<hr>
		
		<div class="brick col-md-12">
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