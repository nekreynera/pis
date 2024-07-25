$(document).on('click', '#add-request', function(){

	var req = 	'<div class="form-group">' +
                   '<div class="col-md-12">' +
                      	'<div class="input-group">' +
	                        '<select class="form-control" name="ptrequest[]" style="font-size: 12px;">' +
		                        '<option value="" hidden>Select</option>' +
		                        '<option value="187">Medico Legal Report</option>' +
		                        '<option value="188">Medical Certificate</option>' +
	                        '</select>' +
                        '<span class="input-group-addon fa fa-remove" id="remove-request" style="cursor: pointer;"></span>' +
                      '</div>' +
                   '</div>' +
                '</div>';
	$('.request-section').append(req);
})
$(document).on('click', '#remove-request', function(){
	var i = 0;
	$('.input-group-addon').each(function(){
		i++;
	});
	if (i < 2) {
		alert('Cannot remove last row')
	}else{
		var conf = confirm('remove this request?');
		if (conf) {
			$(this).closest('.form-group').remove();
			toastr.warning('request removed');
		}
	}
})