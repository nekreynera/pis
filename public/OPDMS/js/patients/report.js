$(document).on('change', '.generate-by', function(){
	var value = $(this).val();
	if (value == 'MONTH') {
		$('.div-from-month, .div-to-month').show();
		$('.div-from-day, .div-to-day').hide();
	}else{
		$('.div-from-month, .div-to-month').hide();
		$('.div-from-day, .div-to-day').show();
	}	
})