@extends('layouts.app')

@section('style')
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<style type="text/css">
		body {
			font-family: 'Oswald', sans-serif;
			font-size: 18px;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="well">
			<div class="row">
				<div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-12">
					<strong>Title</strong>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12">
					{{ ucwords($quiz->title) }}
				</div>
				<div class="col-xs-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1  col-sm-12 col-xs-12">
					<strong>Description</strong>
				</div>
				<div class="col-md-9  col-sm-12 col-xs-12">
					{{ $quiz->description }}
				</div>
				<div class="col-xs-12">&nbsp;</div>
			</div>
			<div class="row">
				<button class="btn btn-primary col-md-10 col-md-offset-1  col-sm-12 col-xs-12">Start Quiz</button>
				<div class="col-md-1"></div>
			</div>
		</div>
	</div>
@endsection