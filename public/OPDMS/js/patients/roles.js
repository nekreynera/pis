
$(document).on('click', '#history-record', function(){
	var id = $(this).attr('data-id');
		toastr.info('Under Maintainance');

	// if (id == '#') {
	// 	toastr.error('Kindly Select Patient Record First');
	// }else{
	// 	// medicalRecords(id)
		
	// }
});

$(document).on('click', '#patient-transaction', function(){
	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		getpatienttransaction(id);
	}
})