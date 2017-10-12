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
		<h1 style="text-align: center;color: rgba(242, 58, 58, 0.84);
		"> Step: 1</h1>
		<hr>
		
		<div class="bg-theme padding_25 mb">
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
				    <textarea class="form-control" name="description"></textarea>
				</div>

				@if ($errors->has('description'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('description') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
				    <label>Category</label>
				    <select name="category" class="form-control">
				    		<option  value="" selected>Select Category</option>
				    	@foreach($categories as $c)
				        	<option value="{{ $c->id }}">{{ ucwords($c->name) }}</option>
				        @endforeach
				    </select>
				</div>

				@if ($errors->has('category'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('category') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('quiz_time') ? 'has-error' : '' }}">
				    <label>Quiz Time  (in Minutes)</label>
				    <input type="number" name="quiz_time" class="form-control" value="5" min="1" max="180">
				</div>

				@if ($errors->has('quiz_time'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('quiz_time') }}</strong>
				    </div>
				@endif

				<div class="form-group {{ $errors->has('public') ? 'has-error' : '' }}">
				    <label>Visibility</label>
				    <select name="public" class="form-control">
				        <option value="1" selected>Public</option>
				        <option value="0">Private</option>
				    </select>
				</div>

				@if ($errors->has('public'))
				    <div class="alert alert-danger">
				        <strong>{{ $errors->first('public') }}</strong>
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

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('form').on('submit' , function(e){
				e.preventDefault();
				if($('input[name=quiz_time]').val() == "") {
					$('input[name=quiz_time]').val(5);
				}
				$(this).unbind('submit').submit();
			});
		});
	</script>
@endsection