$(document).on('change', '.referral-ward', function(){
	var ini = $(this).val();
	if (ini == "in") {
		$('.in-patient').attr('hidden', false);
		$('.out-patient').attr('hidden', true);
	}else{
		$('.in-patient').attr('hidden', true);
		$('.out-patient').attr('hidden', false);
	}
})
$(document).on('focus','.input-diagnosis',function(){
	$('.diagnosis').slideDown('slow');
})
$(document).on('click', '.btn-close', function(){
	$('.diagnosis').hide();
})
$(document).on('change','.select-id',function(){
	var diagnosis = $(this).closest('tr').find('td.select-diagnosis').text();
	if (this.checked) {
		$('.input-diagnosis').val($('.input-diagnosis').val()+"=> "+diagnosis+"\n");
	}else{
		var diag = "=> "+diagnosis+"\n";
		var ini = $('.input-diagnosis').val();
		var news =  ini.replace(diag, "");
		$('.input-diagnosis').val(news);
	}
})


$(document).on('focus','.input-admitting-diagnosis',function(){
	$('.admitting').slideDown('slow');
})
$(document).on('click', '.btn-admitting-close', function(){
	$('.admitting').hide();
})

$(document).on('change','.select-admitting-id',function(){
	// alert(1);
	var diagnosis = $(this).closest('tr').find('td.select-admitting').text();
	// alert(diagnosis);
	if (this.checked) {
		$('.input-admitting-diagnosis').val($('.input-admitting-diagnosis').val()+"=> "+diagnosis+"\n");
	}else{
		var diag = "=> "+diagnosis+"\n";
		var ini = $('.input-admitting-diagnosis').val();
		var news =  ini.replace(diag, "");
		$('.input-admitting-diagnosis').val(news);
	}
})
$(document).on('change', '#referral', function(){
	if ($(this).val() == "yes") {
		 $('#referralModal').modal('toggle');
	}
})