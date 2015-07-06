/**
 * Javascript to manipulate the edit_form elements
 *
 * @copyright 2015 Thomas Threadgold, LearningWorks Ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$('#id_config_courses_shown').on('change', function(){
	if(parseInt($(this).val(), 10) < 4) {
		$('#fitem_id_config_manual_course_4').hide();
	} else {
		$('#fitem_id_config_manual_course_4').show();
	}

	if(parseInt($(this).val(), 10) < 3) {
		$('#fitem_id_config_manual_course_3').hide();
	} else {
		$('#fitem_id_config_manual_course_3').show();
	}

	if(parseInt($(this).val(), 10) < 2) {
		$('#fitem_id_config_manual_course_2').hide();
	} else {
		$('#fitem_id_config_manual_course_2').show();
	}
});

$('#id_config_course_selection').on('change', function(){
	if(parseInt($(this).val(), 10) === 2) {
		if(parseInt($('#id_config_courses_shown').val(), 10) < 4) {
			$('#fitem_id_config_manual_course_4').hide();
		} else {
			$('#fitem_id_config_manual_course_4').show();
		}

		if(parseInt($('#id_config_courses_shown').val(), 10) < 3) {
			$('#fitem_id_config_manual_course_3').hide();
		} else {
			$('#fitem_id_config_manual_course_3').show();
		}

		if(parseInt($('#id_config_courses_shown').val(), 10) < 2) {
			$('#fitem_id_config_manual_course_2').hide();
		} else {
			$('#fitem_id_config_manual_course_2').show();
		}
			
		$('#fitem_id_config_manual_course_1').show();
	} else {
		$('#fitem_id_config_manual_course_4').hide();
		$('#fitem_id_config_manual_course_3').hide();
		$('#fitem_id_config_manual_course_2').hide();
		$('#fitem_id_config_manual_course_1').hide();
	}
});

var initSettings = function() {
	if(parseInt($('#id_config_course_selection').val(), 10) !== 2) {
		$('#fitem_id_config_manual_course_4').hide();
		$('#fitem_id_config_manual_course_3').hide();
		$('#fitem_id_config_manual_course_2').hide();
		$('#fitem_id_config_manual_course_1').hide();
	} else {
		if(parseInt($('#id_config_courses_shown').val(), 10) < 4) {
			$('#fitem_id_config_manual_course_4').hide();
		}

		if(parseInt($('#id_config_courses_shown').val(), 10) < 3) {
			$('#fitem_id_config_manual_course_3').hide();
		}

		if(parseInt($('#id_config_courses_shown').val(), 10) < 2) {
			$('#fitem_id_config_manual_course_2').hide();
		}
	}


};

$(document).ready(function(){ initSettings(); });