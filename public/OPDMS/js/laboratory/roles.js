$(document).on('click', '#service-information', function(){
	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Serviced First');
	}else{
		infolist(id);
	}
});	