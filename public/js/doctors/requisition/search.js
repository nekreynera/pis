$(document).on('keyup', 'input#requisition-departmanet', function(){
	// alert($(this).val());
	var input, filter, div, a, span, i;
	input = this;
	filter = input.value.toUpperCase();
	div = document.getElementById("departmentsContainer");
	a = div.getElementsByTagName("a");
	for (i = 0; i < a.length; i++) {
		if (a) {
			txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
		      a[i].style.display = "";
		    } else {
		      a[i].style.display = "none";
		    }
		}
	}
});

$(document).on('keyup', 'input#requesition-item-input', function(){
	var input, filter, table, tr, td, i, txtValue;
	input = this;
	filter = input.value.toUpperCase();
	table = document.getElementById("requesition-item-table");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
	   	td = tr[i].getElementsByTagName("td")[1];
	   	if (td) {
	     	txtValue = td.textContent || td.innerText;
	     	if (txtValue.toUpperCase().indexOf(filter) > -1) {
	       		tr[i].style.display = "";
	     	} else {
	       		tr[i].style.display = "none";
	     	}
	   	}  
	}
});


     
