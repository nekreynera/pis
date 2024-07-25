function viewpatienttransaction(id) {
	$("#modal-new-transaction .modal-loader .loaderRefresh").fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/laboratorypatients/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		appendpatientinfototransaction(response.info);
		updatepathologynavigation(response);
		updatepathologytable(response.list);
		appendreuqesttotable(response, status = 'All');
		$('#modal-new-transaction').modal({backdrop: 'static', keyboard: false});   
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
		$("#modal-new-transaction .modal-loader .loaderRefresh").fadeOut('fast');
	});
	// body...
}