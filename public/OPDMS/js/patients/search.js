$(document).ready(function () {
	$('.search-menu a').on('click', function (event) {
		// event.preventDefault();
		var filter = $(this).attr('class');
		switch(filter){
			case 'lname':
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient Last Name...','name':'lname'});
				$('small.search-guide').text('Search For Patient Last Name');
				break;
			case 'fname':
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient First Name...','name':'fname'});
				$('small.search-guide').text('Search For Patient First Name');
				break;
			case 'completename':
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient Name...','name':'completename'});
				$('small.search-guide').text('Search For Patient Last Name & First Name');
				break;
			case 'hospital_no':
				$('#searchInput').attr({'type':'number','placeholder':'Search For Patient Hospital No...','name':'hospital_no'});
				$('small.search-guide').text('Search For Patient Patient Hospital No');
				break;
				
			case 'datereg':
				$('#searchInput').attr({'type':'date','placeholder':'dd/mm/yyyy','name':'datereg'});
				$('small.search-guide').text('Search By Date Registered');
				break;
			default :
				$('#searchInput').attr({'type':'text','placeholder':'Search Patient...','name':'patient'});

		}
		$('#searchInput').focus();
	});
});

$(document).on('keyup', '#searchInput', function(){
	var input, filter, table, tr, td, i, count = 0;
	input = document.getElementById("searchInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("patient-table");
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


$(document).on('keyup', '#search-patient-input', function(){
	var input, filter, table, tr, td, i, count = 0;
	input = document.getElementById("search-patient-input");
	filter = input.value.toUpperCase();
	table = document.getElementById("result-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	  td1 = tr[i].getElementsByTagName("td")[1];
	  td2 = tr[i].getElementsByTagName("td")[2];
	  td3 = tr[i].getElementsByTagName("td")[3];
	  td4 = tr[i].getElementsByTagName("td")[4];
	  if (td1, td2, td3, td4) {
	    if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td2.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td3.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td4.innerHTML.toUpperCase().indexOf(filter) > -1) {
	    	count++;
	      tr[i].style.display = "";
	    } else {
	      tr[i].style.display = "none";
	    }
	  }       
	}
	$('span.result-count').text(count);
});


$(document).on('keyup', '#search-print-patient', function(){
	var input, filter, table, tr, td, i, count = 0;
	input = document.getElementById("search-print-patient");
	filter = input.value.toUpperCase();
	table = document.getElementById("print-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	  td1 = tr[i].getElementsByTagName("td")[1];
	  td2 = tr[i].getElementsByTagName("td")[2];
	  td3 = tr[i].getElementsByTagName("td")[3];
	  td4 = tr[i].getElementsByTagName("td")[4];
	  if (td1, td2, td3, td4) {
	    if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td2.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td3.innerHTML.toUpperCase().indexOf(filter) > -1 ||
	    	td4.innerHTML.toUpperCase().indexOf(filter) > -1) {
	    	count++;
	      tr[i].style.display = "";
	    } else {
	      tr[i].style.display = "none";
	    }
	  }       
	}
	$('#modal-print-patient .print-count').val(count);
});


$(document).on('keydown', '#search-print-patient', function(){
	if(event.key === 'Enter') {
		var input = $(this).val();
		$('#modal-print-patient .loaderRefresh').fadeIn('fast');
		request = $.ajax({
		    url: baseUrl+'/searchprintMultiple',
		    type: "post",
		    data: {'patient': input},
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			$('#modal-print-patient .search-count').text(response.length).css({'font-weight': 'bold'});
			$('#modal-print-patient .search-print').css({'display': 'block'});
			$('#modal-print-patient .print-count').val('');
		    updateprinttbodycontent(response);
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		    $('#modal-print-patient .loaderRefresh').fadeOut('fast');
		});
	}
});
