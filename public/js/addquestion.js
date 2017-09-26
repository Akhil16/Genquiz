var question_valid = false;
var option_valid = false;
var answer_valid = false;
var bg_green = '#DCEDC8';
var bd_green = '#81C784';
var bg_red = '#ffcdd2';
var bd_red = '#a94442';

$(document).ready(function(){
	
	var answer = "";
	var option_count = $('.options-list-row').length;
	var char_val = option_count + 97;
	var i;
	
	$('#add-option-btn').on('click' , function() {
		
		option_count++;

		$("<tr id='row_option_" + String.fromCharCode(char_val) + "' class='options-list-row'><td><input class='form-control option-input' type='text' name='option[]' placeholder='Please Enter Something'></td><td><input class='form-check-input answer-radio' type='radio' name='radio' value='" + String.fromCharCode(char_val) + "'><input class='form-check-input answer-checkbox' type='checkbox' style='display: none;' disabled='disabled' value='" + String.fromCharCode(char_val) + "'></td><td><button class='btn btn-warning delete-option-btn' value='" + String.fromCharCode(char_val) + "'>Delete</button></td></tr>").insertBefore($('#add-option-row'));

		if(option_count >= 4) {
			$(this).css('display' , 'none');
		}

		i = 97;
		$('.options-list-row').each(function() {
			$(this).children().eq(1).children().val(String.fromCharCode(i));
			$(this).children().eq(i - 97).attr('id' , 'row_option_' + String.fromCharCode(i));
			i++;
		});

		char_val++;

		if($('#question_type').val() == "single choice"){
			$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
			$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
		} else {
			$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
			$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
		}	
					
	});

	$('#options-list').on('click' , '.delete-option-btn' , function(){

		if(option_count > 1) {
			$('#row_option_' + $(this).val()).remove();
			option_count--;
		}

		if(option_count <= 4) {
			$('#add-option-btn').css('display' , 'block');
		}

		i = 97;
		$('.options-list-row').each(function() {
			$(this).children().eq(1).children().val(String.fromCharCode(i));
			$(this).children().eq(i - 97).attr('id' , 'row_option_' + String.fromCharCode(i));
			i++;
		});
	});

	$('#question_type').on('change' , function() {
		
		if($(this).val() == "text"){
			$('#options-list-div').slideUp();
			$('#text-answer-div').slideDown();
			$('.option-input').attr('disabled' , 'true');
		} else {
			$('#options-list-div').slideDown();
			if($(this).val() == "single choice"){
				$('input[type=radio]').css('display' , 'block').removeAttr('disabled');
				$('input[type=checkbox]').css('display' , 'none').attr('disabled' , 'true');
			} else {
				$('input[type=radio]').css('display' , 'none').attr('disabled' , 'true');
				$('input[type=checkbox]').css('display' , 'block').removeAttr('disabled');
			}
			$('#text-answer-div').slideUp();
			$('.option-input').removeAttr('disabled');
		}
					
	});

	$('#add-question-form').on('submit' , function(event) {

	    event.preventDefault();
	});


	$('#add-question-form-btn').on('click' , function(){
		
		validateQuestion();
		validateOptions();
		validateAnswer();

		if(question_valid && option_valid && answer_valid)
			$('#add-question-form').unbind('submit').submit();
	});

	$('input[name=question]').on('blur' , function(){
		validateQuestion();
	});

	$('#options-list').on('blur' , '.option-input' , function(){

		validateOptions();

	}).on('keyup' , '.options-list-row' , function(e){

		if(e.keyCode == 13){
			$('#add-option-btn').click();
		}
	});

});

function validateQuestion() {

	var question = $('input[name=question]').val();
	if(question.length == 0) {
	    question_valid = false;
	    implement_error('question_div','question_feedback',$('input[name=question]'),'Required');
	} else {
	    question_valid = true;
	    implement_success('question_div','question_feedback',$('input[name=question]'));
	}
}

function validateOptions() {

	option_valid = true;
	if($('#question_type').val() !== "text") {
		$('.option-input').each(function(){
			if($(this).val().length == 0) {
			    option_valid = false;
			    $(this).css("border-color",bd_red);
			    $(this).css("background",bg_red);
			} else {
				$(this).css("border-color",bd_green);
	    		$(this).css("background",bg_green);
			}
		});

		if(option_valid == false) {
		    $("#option_feedback").text("All Fields Required").removeClass().addClass('alert alert-danger').show();
		} else {
			$("#option_feedback").text("").removeClass().hide();
		}
	}
}

function validateAnswer() {

	answer_valid = true;
	answer = "";
	if($('#question_type').val() == "single choice"){
		answer = $('.answer-radio:checked').val();
	} else if($('#question_type').val() == "multiple choice"){
		$(".answer-checkbox:checked").each(function(){
			answer += $(this).val() + ",";
		});
		answer = answer.substr(0 , answer.length - 1);
	} else {
		answer = $('#text-answer').val();
	}

	if(answer == null || answer == "") {

		answer_valid = false;
		$("#answer_feedback").text("Answer Required").removeClass().addClass('alert alert-danger').show();
		if($('#question_type').val() == "text") {
			$('#text-answer-div').removeClass().addClass('form-group has-error');
			$('#text-answer').css("border-color",bd_red);
			$('#text-answer').css("background",bg_red);
		}
	} else {
		answer_valid = true;
		$("#answer_feedback").text("").removeClass().hide();
		if($('#question_type').val() == "text") {
			$('#text-answer-div').removeClass().addClass('form-group');
			$('#text-answer').css("border-color",bd_green);
    		$('#text-answer').css("background",bg_green);
		}
	}

	if(answer_valid == true) {
		$('input[name=answer]').val(answer);
	}
}

function implement_error(element_div,element_feedback,element,error_message,cls) {
    cls = cls ? cls : "";
    $('#' + element_div).removeClass().addClass('form-group has-error ' + cls);
    $(element).css("border-color",bd_red);
    $(element).css("background",bg_red);
    $("#" + element_feedback).text(error_message).removeClass().addClass('alert alert-danger').show();
}

function implement_success(element_div,element_feedback,element,cls) {
    cls = cls ? cls : "";
    $('#' + element_div).removeClass().addClass('form-group ' + cls);
    $(element).css("border-color",bd_green);
    $(element).css("background",bg_green);
    $("#" + element_feedback).text("").removeClass().hide();
}