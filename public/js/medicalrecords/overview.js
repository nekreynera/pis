$(document).on('click', 'td.pt-info', function(){
	var id = $(this).attr('data-id');
		$.get(baseUrl+"/getpatientinfoandmssbyid/"+id, {},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
				$('.hosp_no').empty().text(request.hospital_no);
				$('.barcode').empty().text(request.barcode);
				$('.ptname').empty().text(request.last_name+', '+request.first_name+' '+request.middle_name);
				 var birthday = getDateString(request.birthday);
				$('.ptbday').empty().text(birthday);
				$('.ptaddress').empty().text(request.address);
				$('.ptsex').empty().text(request.sex);
				$('.ptcvstatus').empty().text(request.civil_status);
				$('.ptmss').empty().text(request.label+'-'+request.description);
				 var created = getDateString(request.created);
				$('.ptcreated').empty().text(created);
			}
		)
	$('#patientinfo-modal').modal('toggle');
})
$(document).on('click', '#view-consultation', function(){
	var id = $(this).attr('data-id');
	$.get(baseUrl+"/getpatientconsultationbyid/"+id, {},

		function (data, status){
			var request = JSON.parse(data);
			console.log(request);
			$('.consultations-tbody').empty();
				for (var i = 0; i < request.length; i++) {
					var tr = $('<tr>');
					var td1 = $('<td>').text(request[i].last_name+', '+request[i].first_name+' '+request[i].middle_name);
					var td2 = $('<td>').text(request[i].name);
					var td3 = $('<td>').text(request[i].users);
					var td4 = $('<td>').text(request[i].created);
					var td5 = '<td><a href="printNurseNotes/'+request[i].id+'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> view</a></td>';
					$(tr).append(td1, td2, td3, td4, td5);
					$('.consultations-tbody').append(tr);
				}
			}
		)
	$('#records-modal').modal('toggle');
})




/*SELECT a.consultation,
		b.last_name,b.first_name,b.middle_name,
		d.name,
        CONCAT(c.last_name,', ',c.first_name,' ',LEFT(c.middle_name, 1),'.') as users,
        a.created_at
FROM consultations a
LEFT JOIN patients b ON a.patients_id = b.id
LEFT JOIN users c ON a.users_id = c.id
LEFT JOIN clinics d ON c.clinic = d.id
WHERE a.patients_id = 45069*/










function getCustomDate(rawDate) {
    var d = new Date(rawDate);
    var days = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var hour = d.getHours();
    var min = d.getMinutes();
    var today = month + ' ' + day + ', ' + year + ' ' + hour + ':' + min;
    return today;
}

function getDateString(rawDate) {
    var d = new Date(rawDate);
    var days = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = month + ' ' + day + ', ' + year;
    return today;
}