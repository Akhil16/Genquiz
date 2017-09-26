$(document).ready(function() {

	var question_type = "";
	var answer = "";
	var answer_status = "negative";
	var answer_str = "";
	var append_string = "";
	var countDownDate;
	
	$('#start-quiz-btn').on('click' , function() {

		var formdata = {};
		$("#start-quiz-form").serializeArray().map(function(x){formdata[x.name] = x.value;});

		$.ajax({
		    type: "POST",
		    url: start_quiz_url,
		    data: formdata,
		    dataType:  "json",
		    success:function(data){
		        
	        	append_string = "";
	        	question_type = data.question.question_type;
	        	answer = data.question.answer;
	        	answer_status = "negative";

	        	append_string += "</div><div class='bg-theme03 padding_25 mt mb'><div class='row padding_25' id='" + data.question.question_unique + "'  style='display : none;'> <p id='countdown-timer' class='pull-right'></p> <h3><strong>Q " + data.question.question_number + ".</strong> " + data.question.question + "</h3>";
	        	if(question_type == 'text') {
	        		append_string += "<div class='form-group'><input class='form-control' type='text' id='text-answer'><input type='hidden' value='" + data.options[0].option_content + "' id='text-answer-content'></div>";
	        	} else {
	        		append_string += "<h5 style='color : #ff2807;'> " + question_type.toUpperCase() + " <hr></h5><ul  class='list-group'>";
	        			$.each(data.options , function(index , opt) {
	        				append_string += "<a href=''><li class='list-option list-group-item list-group-item' id='" + opt.option_unique + "'>" + opt.option_content + "</li></a><br>";
	        			});
	        		append_string += "</ul>";
	        	}
	        	
	        	append_string += "<button class='btn btn-danger btn-block' id='submit-quiz-btn'>Submit</button><br><div class='alert-message'></div><form method='post' id='quiz-submit-form'><input type='hidden' name='quiz_unique' value='" + data.quiz.quiz_unique + "'><input type='hidden' name='play_unique' value='" + data.play_unique + "'><input type='hidden' name='question_number' value='" + data.question.question_number + "'><input type='hidden' name='endtime' value='" + data.endtime + "'><input type='hidden' name='answer' value='false'></form></div>";

	        	$('#start-quiz-btn').remove();
	        	$('#countdown-timer').remove();
	        	$('#quiz-well').append(append_string);
	        	$('#' + data.question.question_unique).slideDown();

	        	countDownDate = new Date(data.endtime).getTime();
	        	var inc = 0;
	        	// Update the count down every 1 second
	        	var x = setInterval(function() {
	        	    // Get todays date and time
	        	    var now = new Date(data.present_time).getTime() + (inc++ * 1000);
	        	    
	        	    // Find the distance between now an the count down date
	        	    var distance = countDownDate - now;
	        	    
	        	    // Time calculations for days, hours, minutes and seconds
	        	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	        	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	        	    
	        	    // Output the result in an element with id="demo"
	        	    $("#countdown-timer").text(minutes + "m " + seconds + "s");
	        	    
	        	    // If the count down is over, submit the quiz
	        	    if (distance < 0) {
	        	        clearInterval(x);
	        	        $("#countdown-timer").text("0m 0s");
	        	        $("#submit-quiz-btn").click();
	        	    }
	        	}, 1000);
		    }
		});
	});

	$('#quiz-well').on('click' , 'a' , function(evt) {
		evt.preventDefault();
	});

	$('#quiz-well').on('submit' , '#quiz-submit-form' , function(evt) {
		evt.preventDefault();
	});

	$('#quiz-well').on('click' , '#submit-quiz-btn' , function() {

		answer_status = "negative";
		answer_str = "";

		if(question_type == "single choice") {
			if($('.list-option.selected').attr('id') == answer) {
				answer_status = "positive";
			}
		} else if(question_type == "multiple choice") {
			$('.list-option.selected').each(function() {
				answer_str += $(this).attr('id') + ",";
			});
			answer_str = answer_str.substr(0 ,answer_str.length - 1);
			if(answer_str == answer) {
				answer_status = "positive";
			}
		} else {
			if($('#text-answer').val().toLowerCase() == $('#text-answer-content').val().toLowerCase()) {
				answer_status = "positive";
			}
		}
		$('input[name=answer]').val(answer_status);

		if(answer_status == "positive") {
			$(this).parent().find('.alert-message').addClass("alert alert-success").text("Correct Answer");
			if(question_type == "text") {
				$('#text-answer').parent().addClass('has-success');
			}

			$(this).parent().find('.list-option.selected').removeClass('selected').addClass('list-group-item list-group-item-correct');

		} else {
			$(this).parent().find('.alert-message').addClass("alert alert-danger").text("Wrong Answer");
			if(question_type !== "text") {
				$(this).parent().find('.list-option.selected').addClass('list-group-item-danger');

				$(this).parent().find('.list-option').each(function(){
					if(answer.indexOf($(this).attr('id')) >= 0) {
						$(this).removeClass('list-group-item-danger').addClass('list-group-item-correct');
					}
				});
			} else {
				$('#text-answer').val($('#text-answer-content').val()).parent().addClass('has-error');
			}
		}

		$(this).removeClass('btn-danger').addClass('btn-primary').text('Submitted..!').removeAttr('id');

		$.ajax({
		    type: "POST",
		    url: start_quiz_url,
		    data: {"quiz_unique" : $('input[name=quiz_unique]').val() ,"play_unique" : $('input[name=play_unique]').val() ,"question_number" : $('input[name=question_number]').val() ,"endtime" : $('input[name=endtime]').val() ,"answer" : $('input[name=answer]').val()},
		    dataType:  "json",
		    success:function(data){
		        if(data.quiz_status == "completed") {

		        	setTimeout(function() {
		        		
		        		window.location.href = result_base_url + data.quiz_slug + "/play/" + data.play_unique;
		        	} , 500);

		        } else {
		        	append_string = "";
		        	question_type = data.question.question_type;
		        	answer = data.question.answer;
		        	answer_status = "negative";

		        	append_string += "</div><div class='bg-theme03 padding_25 mt mb'><div class='row padding_25' id='" + data.question.question_unique + "' style='display : none;'> <p id='countdown-timer' class='pull-right'></p> <h3><strong>Q " + data.question.question_number + ".</strong> " + data.question.question + "</h3>";
		        	if(question_type == 'text') {
		        		append_string += "<div class='form-group'><input class='form-control' type='text' id='text-answer'><input type='hidden' value='" + data.options[0].option_content + "' id='text-answer-content'></div>";
		        	} else {
		        		append_string += "<h5 style='color : #ff2807;'> " + question_type.toUpperCase() + " <hr></h5><ul  class='list-group'>";
		        			$.each(data.options , function(i , opt) {
		        				append_string += "<a href=''><li class='list-option list-group-item list-group-item' id='" + opt.option_unique + "'>" + opt.option_content + "</li></a><br>";
		        			});
		        		append_string += "</ul>";
		        	}
		        	
		        	append_string += "<button class='btn btn-danger btn-block' id='submit-quiz-btn'>Submit</button><br><div class='alert-message'></div><form method='post' id='quiz-submit-form'><input type='hidden' name='quiz_unique' value='" + data.quiz.quiz_unique + "'><input type='hidden' name='play_unique' value='" + data.play_unique + "'><input type='hidden' name='question_number' value='" + data.question.question_number + "'><input type='hidden' name='endtime' value='" + data.endtime + "'><input type='hidden' name='answer' value='false'></form></div>";

		        	$('#quiz-submit-form').remove();
		        	$('#countdown-timer').remove();
		        	$('#quiz-well').append(append_string);
		        	$('#' + data.question.question_unique).slideDown();

		        	countDownDate = new Date(data.endtime).getTime();
		        	
			    }
			}
		});
	});

	$('#quiz-well').on('click' , '.list-option' , function() {

		if(question_type == "single choice") {

			$('.list-option').removeClass('selected').addClass('list-group-item');

			$(this).removeClass('list-group-item').addClass('selected');

		} else if(question_type == "multiple choice") {
			if($(this).hasClass('selected')) {
				$(this).removeClass('selected').addClass('list-group-item');
			} else {
				$(this).removeClass('list-group-item').addClass('selected');
			}
		}
	});
});