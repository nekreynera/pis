$(document).ready(function () {
	$('.search-menu a').on('click', function (event) {
		// event.preventDefault();
		var filter = $(this).attr('class');
		switch(filter){
			case 'lname':
				$('#queued-patient-input').attr({'type':'text','placeholder':'Search For Patient Last Name...','name':'lname'});
				break;
			case 'fname':
				$('#queued-patient-input').attr({'type':'text','placeholder':'Search For Patient First Name...','name':'fname'});
				break;
			case 'hospital_no':
				$('#queued-patient-input').attr({'type':'number','placeholder':'Search For Patient Hospital No...','name':'hospital_no'});
				break;
				
			case 'datereg':
				$('#queued-patient-input').attr({'type':'date','placeholder':'dd/mm/yyyy','name':'datereg'});
				break;
			default :
				$('#queued-patient-input').attr({'type':'text','placeholder':'Search Patient...','name':'patient'});

		}
		$('#searchInput').focus();
	});
});


$(document).on('keyup', 'input#queued-patient-input', function(){
	var input, filter, table, tr, td1, td2, i, txtValue, count = 0;
	input = this;
	filter = input.value.toUpperCase();
	table = document.getElementById("patient-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	   	td1 = tr[i].getElementsByTagName("td")[2];
	   	td2 = tr[i].getElementsByTagName("td")[3];
	   	if (td1 || td2) {
	     	txtValue1 = td1.textContent || td1.innerText;
	     	txtValue2 = td2.textContent || td2.innerText;
	     	if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
	       		tr[i].style.display = "";
	       		count++;
	     	} else {
	       		tr[i].style.display = "none";
	     	}
	   	}  
	}
	$('.box-footer b').text(count+' search result(s).');
});


$(document).on('submit', 'form.queued-patient-form', function(e){
	$('#main-page .box-body .loaderRefresh').fadeIn('fast');
});

/*===============PATIENT QUEUE SEARCHED===============*/

$(document).on('keyup', 'input#list-search-input', function(){
	var input, filter, table, tr, td, i, txtValue, count = 0;
	input = this;
	filter = input.value.toUpperCase();
	table = document.getElementById("ancillary-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	   	td = tr[i].getElementsByTagName("td")[1];
	   	if (td) {
	     	txtValue1 = td.textContent || td.innerText;
	     	if (txtValue1.toUpperCase().indexOf(filter) > -1) {
	       		tr[i].style.display = "";
	       		count++;
	     	} else {
	       		tr[i].style.display = "none";
	     	}
	   	}  
	}
	if (count <= 0) {
		$('#ancillary-table tfoot tr.deeper_tr').css('visibility', 'visible').children('td').text('HIT ENTER KEY TO SEARCH DEEPER');;
	}else{
		$('#ancillary-table tfoot tr.deeper_tr').css('visibility', 'hidden');
	}
	// $('.box-footer b').text(count+' search result(s).');
});

$(document).on('submit', 'form#list-search', function(e){
	e.preventDefault();
	var scope = $(this);
	$('.list-search-row .loaderRefresh').fadeIn('fast');
	var data = $(scope).serialize();
	request = $.ajax({
	    url: $(scope).attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: data,
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    updatepathologytable(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('.list-search-row .loaderRefresh').fadeOut('fast');
	});
});


$(document).on('keyup', '#sub-search-input', function(){
	var input, filter, ul, a, span, i;
	input = document.getElementById("sub-search-input");
	filter = input.value.toUpperCase();
	ul = document.getElementById("ancillary-sidebar-special");
	a = ul.getElementsByTagName("a");
	for (i = 0; i < a.length; i++) {
	  	span = a[i].getElementsByTagName("span");
	  if (span) {
	    if ($(span).text().toUpperCase().indexOf(filter) > -1) {
	      a[i].style.display = "";
	    } else {
	      a[i].style.display = "none";
	    }
	  }       
	}
});
