$(document).ready(function() {
    // $('#classifiedTable').DataTable();
});
// $(document).ready(function() {
// 	$(window).on('load',function(){
//         $('#choosedatemodal').modal('show');
//     });
// })
$(document).ready(function(){
    $('.calendar').click(function(){
        $('#choosedatemodal').modal('toggle');
    })

});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
$(window).load(function(){
	// $('#classifiedTable_filter').hide();
})

$(document).ready(function () {
	$('.search-menu a').on('click', function (event) {
		// event.preventDefault();
		var filter = $(this).attr('class');
		switch(filter){
			case 'lname':
				$('input#patient').attr({'type':'text','placeholder':'Search For Patient Last Name...','name':'lname'}).focus();
				$('small.search-guide').text('Search For Patient Last Name');
				break;
			case 'fname':
				$('input#patient').attr({'type':'text','placeholder':'Search For Patient First Name...','name':'fname'}).focus();
				$('small.search-guide').text('Search For Patient First Name');
				break;
			case 'hospital_no':
				$('input#patient').attr({'type':'number','placeholder':'Search For Patient Hospital No...','name':'hospital_no'}).focus();
				$('small.search-guide').text('Search For Patient Patient Hospital No');
				break;
				
			case 'datereg':
				$('input#patient').attr({'type':'date','placeholder':'dd/mm/yyyy','name':'datereg'}).focus();
				$('small.search-guide').text('Search By Date Classified');
				break;
			default :
				$('input#patient').attr({'type':'text','placeholder':'Search Patient...','name':'patient'}).focus();

		}
		$('#searchInput').focus();
	});
});

function searchclassifiedpatient(scope) {
	var filter, table, tr, td1, td2, td3, i, txtValue1,txtValue2,txtValue3;
	  	filter = $(scope).val().toUpperCase();
	  	console.log(filter);
	  	table = document.getElementById("classifiedTable");
	  	tr = table.getElementsByTagName("tr");
	  	for (i = 0; i < tr.length; i++) {
	    	td1 = tr[i].getElementsByTagName("td")[1];
	    	td2 = tr[i].getElementsByTagName("td")[3];
	    	td3 = tr[i].getElementsByTagName("td")[12];
	    	if (td1 || td2 || td3) {
	      		txtValue1 = td1.textContent || td1.innerText;
	      		txtValue2 = td2.textContent || td2.innerText;
	      		txtValue3 = td3.textContent || td3.innerText;
	      		if (txtValue1.toUpperCase().indexOf(filter) > -1 ||
	      			txtValue2.toUpperCase().indexOf(filter) > -1 ||
	      			txtValue3.toUpperCase().indexOf(filter) > -1) {
	        		tr[i].style.display = "";
	      		} else {
	        		tr[i].style.display = "none";
	      		}
	   		}       
		}
}