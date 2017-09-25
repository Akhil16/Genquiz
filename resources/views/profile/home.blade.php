@extends('layouts.app')

@section('content')
	<div class="container-fluid">                      
      <div class="row mt">
      <!-- SERVER STATUS PANELS -->
      	
      	<div class="col-md-12 col-sm-12 mb">
      		<div class="darkblue-panel pn donut-chart">
      			<div class="darkblue-header">
		  			<h5>SERVER LOAD</h5>
      			</div>
				<div class="row">
					<div class="col-sm-6 col-xs-6 goleft">
						<p><i class="fa fa-database"></i> 70%</p>
					</div>
          		</div>
				
          	</div><! --/grey-panel -->
      	</div><!-- /col-md-12-->
        @if(sizeof($quizzes) > 0)
	        @foreach($quizzes as $quiz)              	              	
				<div class="col-md-12 mb">
					<div id="quiz-well">
						<div class="well">
							<div class="row">
								<div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-12">
									<img class="img-thumbnail" src="{{ URL::asset('uploads/quizcover/' . $quiz->quiz_cover) }}" alt="{{ ucwords($quiz->title) . ',' . ucwords($quiz->description) }}"  style="height: 180px; width: 120px;">
								</div>
								<div  class="col-md-9 col-sm-12 col-xs-12">
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
							              <a href="{{ url('quiz/' . $quiz->quiz_slug) }}">
							              		<button class="btn btn-primary col-md-10 col-md-offset-1 col-sm-12 col-xs-12"  id="start-quiz-btn">Play Quiz</button>
							              </a>
									</div>
								</div>
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
		<div class="col-md-12 col-sm-12 mb">
      		<div class="darkblue-panel pn donut-chart">
      			<div class="darkblue-header">
		  			<h5>SERVER LOAD</h5>
      			</div>
				<div class="row">
					<div class="col-sm-6 col-xs-6 goleft">
						<p><i class="fa fa-database"></i> 70%</p>
					</div>
          		</div>
				
          	</div><! --/grey-panel -->
      	</div><!-- /col-md-12-->
                      	              	
		<div class="col-md-12 mb">
			<!-- WHITE PANEL - TOP USER -->
			<div class="white-panel pn">
				<div class="white-header">
					<h5>TOP USER</h5>
				</div>
				<p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
				<p><b>Zac Snider</b></p>
				<div class="row">
					<div class="col-md-6">
						<p class="small mt">MEMBER SINCE</p>
						<p>2012</p>
					</div>
					<div class="col-md-6">
						<p class="small mt">TOTAL SPEND</p>
						<p>$ 47,60</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection