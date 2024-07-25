
$(document).on("change",".start_month",function(){
	var from = $(this).val();
	$('.end_month option').each(function(){
		var to = $(this).val();
		if (Number(from) > Number(to)) {
			 $(this).attr('disabled', true).attr('style', 'cursor:not-allowed!important;background-color:#ccc;');
		}else{
			$(this).attr('disabled', false).attr('style', 'cursor:not-allowed!important;background-color:#ffffff;');
		}
	})
})
$(document).on("change", ".type",function(){
	if ($(this).val() == "DISPENSED") {
		$(".dual_month").attr('hidden', true);
		$(".single_month").attr('hidden', false);
	}
	else{
		$(".dual_month").attr('hidden', false);
		$(".single_month").attr('hidden', true);
		$('.month').val("");
	}
})
$(document).on('submit', '.census-form', function(){
	$('.loaderWrapper').css('display', 'block');
})