jQuery(document).ready(function($) {
	$("input:checkbox").on('click', function() {
		var $box = $(this);
		if ($box.is(":checked")) {
			var group = "input:checkbox[name='" + $box.attr("name") + "']";
			$(group).prop("checked", false);
			$box.prop("checked", true);
		} else {
			$box.prop("checked", false);
		}
	});
	$('.image_icon').change(function() {
		if (this.checked) $('.circle-not-available').fadeOut('slow');
		$('div.icon-section > tr:eq(3)').css("display", "none");
	});
	$('.color_radio').click(function() {
		if (this.checked) {
			$('.color-picker-section').fadeOut();
		}
	});
	$('.image_icon').click(function() {
		if (this.checked) {
			$("#choose_location option[value='topright']").prop('disabled', true);
			$("#choose_location option[value='topmiddle']").prop('disabled', true);
			$("#choose_location option[value='topleft']").prop('disabled', true);
			$("#choose_location option[value='bottommiddle']").prop('disabled', true);
			$("#choose_location option[value='bottomleft']").prop('selected', true);
			$(".color-selector").prop('checked', false);
			$('.color-picker-section').fadeOut();
			$("#color-container .blue").prop('checked', true);
			$('.icon-section tr:eq(2), .icon-section tr:eq(3)').fadeOut();
		}
	});
	if ($(".image_icon").is(':checked')) {
		$("#choose_location option[value='topright']").prop('disabled', true);
		$("#choose_location option[value='topmiddle']").prop('disabled', true);
		$("#choose_location option[value='topleft']").prop('disabled', true);
		$("#choose_location option[value='bottommiddle']").prop('disabled', true);
		$('.circle-not-available').hide();
		$('.icon-section tr:eq(2), .icon-section tr:eq(3)').hide();
	}
	$('.text_icon').click(function() {
		if (this.checked) {
			$("#choose_location option[value='topright']").prop('disabled', false);
			$("#choose_location option[value='topmiddle']").prop('disabled', false);
			$("#choose_location option[value='topleft']").prop('disabled', false);
			$("#choose_location option[value='bottommiddle']").prop('disabled', false);
			$('.icon-section tr:eq(2), .icon-section tr:eq(3)').fadeIn();
		}
	});
	if ($(".text_icon").is(':checked')) {
		$("#choose_location option[value='topright']").prop('disabled', false);
		$("#choose_location option[value='topmiddle']").prop('disabled', false);
		$("#choose_location option[value='topleft']").prop('disabled', false);
		$("#choose_location option[value='bottommiddle']").prop('disabled', false);
	}
	$('.show-more-colors').click(function() {
		if (this.checked) {
			$('.color-picker-section').fadeIn();
		}
	});
	if ($(".show-more-colors").is(':checked')) {
		$(".color-picker-section").show();
	}
	$(function() {
		$('.color-picker').wpColorPicker();
	});
	$('.text_icon').change(function() {
		if (this.checked) $('.circle-not-available').fadeIn('slow');
	});
});