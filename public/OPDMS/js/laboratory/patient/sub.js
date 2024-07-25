function updatepathologynavigation(response){
	$('.ancillary-sidebar-special').empty();
	for (var i = 0; i < response.laboratory.length; i++) {
		var li_header = $('<li>').addClass('header text-uppercase').attr('data-id', response.laboratory[i].id).text(response.laboratory[i].name);
		$('.ancillary-sidebar-special').append(li_header);
		for (var s = 0; s < response.sub.length; s++) {
			if (response.laboratory[i].id == response.sub[s].laboratory_id) {
				var li_tag = $('<li>').addClass('libody text-capitalize').attr('data-id', response.sub[s].id).html('<a href="#"><span>'+response.sub[s].name+'</span></a>');
				$('.ancillary-sidebar-special').append(li_tag);
			}
		}
	}
}

/*===============END OF NAVIGATION==============*/

$(document).on('click', '#modal-new-transaction .ancillary-sidebar-special li.libody', function(){
	var id = $(this).attr('data-id');
	$('.content-container .loaderRefresh').fadeIn('fast');
	$(this).addClass('active').siblings().removeClass('active');
	request = $.ajax({
	    url: baseUrl+'/laboratorylist/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		updatepathologytable(response);
		    
		// $('.box-footer em.text-muted').html('Showing <b> '+response.length+' </b> result(s).')
		// ancillarytbody(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('.content-container .loaderRefresh').fadeOut('fast');
	});
});

/*===============END OF CLICK NAV FUNCTION======*/
