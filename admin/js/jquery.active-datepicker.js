$(document).ready(function() {
	$( "input.datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1930:2012" 
	});
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	$.datepicker.formatDate('dd-mm-yy');
});