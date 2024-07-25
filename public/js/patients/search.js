$(document).on('click', '#search-button', function(){
	var last_name = $('#last_name').val();
	var first_name = $('#first_name').val();
	var middle_name = $('#middle_name').val();
	var userid = $('#search-table').attr('user-id');
	if (last_name == "") {
		$('#last_name').css("border", "1px solid red");
		$('.error_msg').attr('hidden', false);
		setTimeout(function(){
	        $('#last_name').css("border", "1px solid rgb(153, 153, 153)");
			$('.error_msg').attr('hidden', true);
	    },3000);

	}
	else if (first_name == "") {
		$('#first_name').css("border", "1px solid red");
		$('.error_msg').attr('hidden', false);
		setTimeout(function(){
	        $('#first_name').css("border", "1px solid rgb(153, 153, 153)");
			$('.error_msg').attr('hidden', true);
	    },3000);
		

	}else if (last_name != "" && first_name != "") {
		$.post(baseUrl+"/searchpatientmodal", {
			last_name: last_name,
			first_name: first_name,
			},
				 function (data, status){
				 	$('.search-table-body').empty();
		     		var request = JSON.parse(data);
		     		console.log(request);
		     		$('.patient_count').text(request.length);
		     		
		     		for (var i = 0; i < request.length; i++) {
		     			var tr = $('<tr>');
		     			var td1 = $('<td class="info">').text(request[i].hospital_no);
		     			var td2 = $('<td>').text(request[i].last_name);
		     			var td3 = $('<td>').text(request[i].first_name);
		     			var td4 = $('<td>').text(request[i].middle_name);
		     			var td5 = $('<td>').text(request[i].sex);
		     			var td6 = $('<td>').text(request[i].birthday);
		     			var td7 = $('<td>').text(request[i].place);
		     			if (request[i].info == "reg") {
			     			var td8 = '<td align="center">\
						                  <button type="button" class="btn btn-success btn-sm" onclick="medicalRecords('+request[i].id+')">Record <span class="fa fa-file-o"></span></button>\
						                  <a href="patients/'+request[i].id+'/edit" id="selectPatient" class="btn btn-success btn-sm">Select <span class="fa fa-check"></span>\
						                  </a>\
						                </td>';
		     			}
		     			else{
		     				var td8 = '<td align="center">\
		     				              <button type="button" class="btn btn-success btn-sm" onclick="medicalRecords('+request[i].id+')">Record <span class="fa fa-file-o"></span></button>\
		     				              <a href="#" class="btn btn-success btn-sm" id="selectPatient" disabled>Select <span class="fa fa-check"></span>\
		     				              </a>\
		     				            </td>';
		     			}
		     			
					   
					    if (request[i].info == "reg") {
					    var td9 =  '<td align="center"><a href="#" class="btn btn-danger btn-sm" id="markfordelete" data-id="'+request[i].id+'">Delete <span class="fa fa-remove"></span>\</td>'      
					    }else{
					    var td9 =  '<td align="center"><a href="#" class="btn btn-warning btn-sm" id="restorepatient" data-id="'+request[i].id+'">Restore <span class="fa fa-recycle"></span>\</td>'      
					    }            
		     			var tr2 = $('</tr>');
		     			if (userid == "135") {
		     			$(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, td9, tr2);
		     			}else{
		     			$(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, tr2);
		     			}
		     			$('.search-table-body').append(tr);
		     		}
		     		if (request.length <= 0) {
		     			var tr = $('<tr>');
		     			var td1 = $('<td class="info text-center" colspan="9">').text("EMPTY RESULT");
		     			$(tr).append(td1);
		     			$('.search-table-body').append(tr);

		     		}
		     		
				 }
		);
		$('.searchloader').css('display', 'block');
		
		$('#search-modal').modal('toggle');
		 setTimeout( function () { 
		    $('.searchloader').css('display', 'none');
		 }, 2000);
		
	}
		
	
	
	 
	
});
$(document).on('click','#markfordelete',function(){
	var conf = confirm("delete this patient?")
	if (conf) {
	$.get(baseUrl+"/markfordelete/"+$(this).attr('data-id'), {
		},
			function (data, status){
					 	
			     		var request = JSON.parse(data);
			     		console.log(request);
			     	}
		)
	$(this).text("Restore");
	$(this).attr("class", "btn btn-warning btn-sm");
	$(this).attr("id", 'restorepatient');
	$(this).closest('tr').find('td #selectPatient').attr("disabled", true).attr('href', '#');
	// $(this+' span').attr('class', 'fa fa-recycle');
	} 
})
$(document).on('click','#restorepatient',function(){
	var conf = confirm("restore this patient?")
	if (conf) {
	$.get(baseUrl+"/restorepatient/"+$(this).attr('data-id'), {
		},
			function (data, status){
					 	
			     		var request = JSON.parse(data);
			     		console.log(request);
			     	}
		)
	$(this).text("Delete");
	$(this).attr("class", "btn btn-danger btn-sm");
	$(this).attr("id", 'markfordelete');
	$(this).closest('tr').find('td #selectPatient').attr("disabled", false).attr('href', 'patients/'+$(this).attr('data-id')+'/edit');
	} 
})
// $(document).on('click', '#patient-record',function(){
// 	alert($(this).attr('data-id'));
// })
$(document).on('keyup', '#searchpatient', function(){


  // Declare variables
  // alert(1);
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchpatient");
  filter = input.value.toUpperCase();
  table = document.getElementById("search-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[1];
    td2 = tr[i].getElementsByTagName("td")[2];
    td3 = tr[i].getElementsByTagName("td")[3];
    if (td1, td2, td3) {
      if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 ||
      		td2.innerHTML.toUpperCase().indexOf(filter) > -1 ||
      		td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
})


