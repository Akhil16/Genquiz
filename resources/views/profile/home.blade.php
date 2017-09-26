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
	<div class="container-fluid"> 
		<h1>Quizzes : <hr></h1>                     
      <div class="row">
      <!-- SERVER STATUS PANELS -->
        @if(sizeof($quizzes) > 0)
	        @foreach($quizzes as $quiz)              	              	
				<div class="col-md-4 mb">
					<div class="row bg-theme padding_25">
						<div class="col-md-6 col-xs-6">
							<img class="img-thumbnail img-responsive" src="{{ URL::asset('uploads/quizcover/' . $quiz->quiz_cover) }}" alt="{{ ucwords($quiz->title) . ',' . ucwords($quiz->description) }}"  style="height: 180px; width: 120px;
							border: 5px solid #666; box-shadow: 0 0 15px #666;">
						</div>
						<div  class="col-md-6 col-xs-6 ">
							<div class="row">
								<div class="col-xs-12">
									<strong>Title :</strong>
								</div>
								<div class="col-xs-12">
									{{ ucwords($quiz->title) }}
								</div>
								<div class="col-xs-12">&nbsp;</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<strong>Description:</strong>
								</div>
								<div class="col-xs-12" style="text-overflow:ellipsis;overflow:hidden;height: 70px;">
									{{ $quiz->description }}
								</div>
								<div class="col-xs-12">&nbsp;</div>
							</div>
						</div>
						<div class="row" >
				            <div class="col-md-12 ml mr ">
				            	<a href="{{ url('quiz/' . $quiz->quiz_slug) }}">
				            			<button class="btn btn-primary btn-block"  id="start-quiz-btn">Play Quiz</button>
				            	</a>
				            </div>
						</div>
					</div>
				</div>
			@endforeach
			<div class="text-center">
				{{ $quizzes->links() }}
			</div>
		@else
			<div>No Quizzes</div>
		@endif
		
	</div>
@endsection