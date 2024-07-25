function getpatienttransaction(id){


	$('#modal-patient-transaction .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/getpatienttransaction/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {

	    // console.log(response);
	    transactiontabletbody(response.paid);
	    printedtabletbody(response.printed);
	    // tra

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		$('#modal-patient-transaction').modal('toggle');
	    $('#modal-patient-transaction .loaderRefresh').fadeOut('fast');
	    console.log("To God Be The Glory...");
	});


}
		