$(document).on('keyup', '#list-search-input', function(){
	var input, filter, table, tr, td, i, count = 0;
	input = document.getElementById("list-search-input");
	filter = input.value.toUpperCase();
	table = document.getElementById("ancillary-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	  td2 = tr[i].getElementsByTagName("td")[2];
	  td3 = tr[i].getElementsByTagName("td")[3];
	  td4 = tr[i].getElementsByTagName("td")[4];
	  td5 = tr[i].getElementsByTagName("td")[5];
	  if (td2, td3, td4, td5) {
	    if (td2.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td3.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td4.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td5.innerHTML.toUpperCase().indexOf(filter) > -1) {
	    	count++;
	      tr[i].style.display = "";
	    } else {
	      tr[i].style.display = "none";
	    }
	  }       
	}
	$('.box-footer b').text(count);
});

$(document).on('submit', '#list-search', function(e){
	e.preventDefault();
	var scope = $(this);
	$('.content-container .loaderRefresh').fadeIn('fast');
	$('#service-information').attr('data-id', '#').closest('li').addClass('disabled');

	request = $.ajax({
	    url: $(scope).attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: $(this).serialize(),
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    ancillarytbody(response);
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

/*====END OF LABORATORY LIST SEARCH====*/


