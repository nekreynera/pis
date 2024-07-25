$(document).ready(function() {
    $('#watchertable').DataTable();
});

$(document).ready(function() {
    $('#patienttable').DataTable();
});

$(document).on('click', '#viewwatcher', function(){
	var ptid = $(this).attr('data-id');
	var d = new Date();
	
	var month = d.getMonth();
	var day = d.getDate();
	var year = d.getFullYear();
	var date = year+'-'+month+'-'+day;
	$.get(baseUrl+"/getpatientwatcher/"+ptid, {},
		function (data, status){
			var request = JSON.parse(data);
			console.log(request);
			$('.watchertbody').empty();
			// alert(request.length);
			for (var i = 0; i < request.length; i++) {
				var tr = $('<tr>');
				var td1 = $('<td>').text(request[i].last_name+', '+request[i].first_name+' '+request[i].middle_name);

				var today = new Date();
				var birthDate = new Date(request[i].birthday);
				var age = today.getFullYear() - birthDate.getFullYear();
				var m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				  age--;
				}
				if (request[i].birthday) {
				var td3 = $('<td align="center">').text(age);
				}else{
				var td3 = $('<td align="center">').text('N/A');
				}
				if (request[i].sex) {
					var td4 = $('<td align="center">').text(request[i].sex);
				}else{
					var td4 = $('<td align="center">').text('N/A');
				}
				var td7 = $('<td align="center">').html($.date(request[i].created_at)+'<br>'+$.time(request[i].created_at));
				var td5 = '<td align="center"><a href="hospitalcard/'+request[i].id+'" data-toggle="tooltip" title="Print Watcher ID CARD" target="_blank" data-id="'+request[i].id+'" class="btn btn-primary btn-circle"><i class="fa fa-print"></i></a></td>';
				var td6 = '<td align="center"><a href="patients/'+request[i].id+'/edit" data-toggle="tooltip" title="Edit Watcher Information" class="btn btn-info btn-circle edit"> <i class="fa fa-pencil"></i></a></td>';
				var td8 = '<td align="center"><a href="#" data-toggle="tooltip" title="Delete this Watcher" class="btn btn-danger btn-circle delete" id="deletewatcher" watcher-id="'+request[i].id+'" patient-id="'+request[i].patient_id+'"> <i class="fa fa-remove"></i></a></td>';

				$(tr).append(td1,td3,td4,td7,td5,td6,td8);
				if (request[i].last_name) {
					$('.watchertbody').append(tr);
				}
			}
		}

	)
	$('#addwatcher').attr('data-id', ptid);
	$('#watchermodal').modal('toggle');
})
$(document).on('click', '#addinpatient', function(){
	$('#addpatientmodal').modal('toggle');
	$('#addpatientmodal form').attr('action', baseUrl+"/checkpatients");
})
$(document).on('click', '#addwatcher', function(){
	var id = $(this).attr('data-id');
	$('#addpatientmodal').modal('toggle');
	$('#addpatientmodal form').attr('action', baseUrl+"/checkwatcher?ptid="+id);
})
$('#addpatientmodal').on('shown.bs.modal', function(){
    $('#addpatientmodal .last_name').val('').focus();
})

$(document).on('click', '#deletewatcher', function(){
	var conf = confirm("delete this watcher?");
	if (conf) {
	var scope = $(this);
	var ptid = $(this).attr('patient-id');
	var wtid = $(this).attr('watcher-id');
		$.get(baseUrl+"/deletewatcher/"+ptid+"/"+wtid, {},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
			}
	)
	$(scope).closest('tr').remove();
		toastr.warning('Watcher deleted');
	}

})




$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    var monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
      "July", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];   
    var date =  monthNames[month] + " " + day + ", " + year;

    return date;
};
$.time = function(dateObject) {
    var d = new Date(dateObject);
   	var hour = d.getHours();
	var min = d.getMinutes();
	var a = '';
    if (hour > 12) {a = 'PM';}else{a = 'AM';}
    var time =  hour + ": " + min +' '+a;

    return time;
};
