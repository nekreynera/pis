$(document).on('click', 'tbody.queued-patient-tbody tr', function(){
	var tr = $(this);
	var id = $(tr).attr('data-id');
	$(tr).addClass("selected").siblings().removeClass("selected");
	passidtoactionandlabel(id);
});

function appendqueuedpatientstotable(response, stats) {
	// console.log(response);
	$('.queing-status-button button').each(function(){
		if ($(this).attr('data') == stats) {
			$(this).attr('id', 'selected').siblings('button').attr('id', '');
		} 
	});

	$('tbody.queued-patient-tbody').empty();
	if (response.length > 0) {
		// alert(1);
		for (var i = 0; i < response.length; i++) {
			var tr = $('<tr>').attr('data-id', response[i].id);
			var td1 = $('<td>').html('<span class="fa fa-caret-right">');
			var td2 = $('<td>').addClass('text-center').html('<span class="fa fa-user-o"></span>');
			var td3 = $('<td>').addClass('text-center').text((response[i].hospital_no)?response[i].hospital_no:'WALK-IN-'+response[i].walkin);
			var td4 = $('<td>').text(
										response[i].last_name+', '+
										response[i].first_name
									);
			if (getAge(response[i].birthday) > 59) {
				var td5 = $('<td>').addClass('text-center text-bold text-red').text(getAge(response[i].birthday));
			}else{
				var td5 = $('<td>').addClass('text-center').text(getAge(response[i].birthday));
			}
			var sex = 'Male';
			if (response[i].sex == 'F') {
				sex = 'Female';
			}
			var td6 = $('<td>').addClass('text-center').text(sex);
			var color = 'bg-yellow';
			var status = 'Pending';
			
			if(response[i].status == 'F'){
				status = 'Done';
				color = 'bg-aqua';
			}else if(response[i].status == 'R'){
				status = 'Removed';
				color = 'bg-red';
			}
			var td7 = $('<td>').addClass('text-center').html('<span class="label '+color+' active">'+status+'</span>');
			var td8 = $('<td>').addClass('text-center').text(timeCalculateformat(response[i].created_at));
			if (stats == 'ALL') {
				$(tr).append(
							td1,
							td2,
							td3,
							td4,
							td5,
							td6,
							td7,
							td8
							);
				$('tbody.queued-patient-tbody').append(tr);
			}else{
				if (response[i].status == stats) {
					$(tr).append(
								td1,
								td2,
								td3,
								td4,
								td5,
								td6,
								td7,
								td8
								);
					$('tbody.queued-patient-tbody').append(tr);
				}
			}
		}
	} else {
		var tr = $('<tr>');
		var td1 = $('<td>');
		var td2 = $('<td>');
		var td3 = $('<td>').addClass('text-center').attr('colspan', '6').html('<span class="fa fa-warning"></span> EMPTY DATA');
			$(tr).append(
						td1,
						td2,
						td3
						);
			$('tbody.queued-patient-tbody').append(tr);
	}
}

function appendtransactedpatientstotable(response) {
	// body...
    $('#modal-patients-list table tbody.print-tbody').empty();
	for (var i = 0; i < response.length; i++) {
		var tr = $('<tr>');
		var checked = '';
		if($.inArray(""+response[i].id+"", print_id) != -1){
			checked = 'checked';
		}
		var td1 = $('<td>').addClass('text-center').html('<input type="checkbox" name="transacted" class="transacted" value="'+response[i].id+'" '+checked+'>');
		var td2 = $('<td>').addClass('text-center').text(response[i].hospital_no);
		var td3 = $('<td>').addClass('text-capitalize').text(response[i].last_name+', '+response[i].first_name);
		var td4 = $('<td>').addClass('text-uppercase').text(response[i].sub+' - '+response[i].lists);
		var td5 = $('<td>').text(timeCalculateformat(response[i].recieve_date));
		var td6 = $('<td>').text(timeCalculateformat(response[i].request_date));

		var pr_span = '<span class="label bg-yellow active">Pending</span>';

		if(response[i].status == 'Done'){
			pr_span = '<span class="label bg-aqua active">Done</span>';
		}


		var td7 = $('<td>').addClass('text-center').html(pr_span);

		$(tr).append(
						td1,
						td2,
						td3,
						td4,
						td5,
						td6,
						td7,
					)
		$('#modal-patients-list table tbody.print-tbody').append(tr);
	}
}
