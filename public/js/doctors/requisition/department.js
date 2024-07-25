var data_id_type = [];

$(document).on('click', '.departmentsContainer a', function(e){
	e.preventDefault();
	var scope = $(this);
	$('.loaderWrapper').fadeIn('fast');
	$('#itemsDeptTable').css({'opacity':'.3'});
	$(scope).addClass('selected').siblings('a').removeClass('selected');

	data_id_type = [];
	checkselecteditems();

	getdeparmentsitems($(scope).attr('clinic-code'), data_id_type);
	
});

function getdeparmentsitems(clinic, data_id_type){
	request = $.ajax({
	    url: baseUrl+'/requisitionServices/'+clinic,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    console.log(response);
	    appendtoitemstable(response.data, response.type, data_id_type);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
    	$('.loaderWrapper').fadeOut('fast');
        $('#itemsDeptTable').css({'opacity':'1'});
	    
	});
	
}

