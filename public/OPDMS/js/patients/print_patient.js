function updatetablecontent(ele) {
    if(event.key === 'Enter') {
    	if (ele.value <= 300 && ele.value >= 1 && ele.value != '') {
			$('#modal-print-patient .search-print').css({'display': 'none'});
			$('#modal-print-patient .search-print-patient').val('');
        	printMultipleTable(ele.value);        
    	}else{
    		toastr.error("The input value must be lesser than or equal 300 or greater than 0");
    	}
    }
}

$(function(){
	$("#selectall").click(function () {
		$('.check').prop('checked', this.checked);
		tobePrint();
	});
});


$(document).on('click', '#print-table tbody tr', function(){
	var ini = $(this).find('td input.check').prop('checked');
	$(this).find('td input.check').prop('checked', !ini);
	if($(".check").length == $(".check:checked").length) {
		$("#selectall").prop("checked", "checked");
	} else {
		$("#selectall").removeAttr("checked");
	}
	if (ini) {
		var inis = $(this).find('td input.check').val();
		value_id = jQuery.grep(value_id, function(value){
			return value != inis;
		});			
	}
	tobePrint();
});
var value_id = [];
function tobePrint()
{	
	$('.check').each(function(){
		if (this.checked) {
			var ini = $(this).val();
			
			if($.inArray(ini, value_id) == -1){
				value_id.push($(this).val());
			}
		}
	});
	// alert(value_id);
}


$(document).on('click', '#print-selected-record', function(){
	for (var i = 0; i < value_id.length; i++) {
		$('#patient-table tbody tr').each(function(){
			var tr = $(this);
			var tr_id = $(tr).attr("data-id");
			if (value_id[i] == tr_id) {
				$(tr).find('.print_status').html('<small class="label bg-green">Printed</small>');
			}
		})
	}
	if (value_id.length > 0) {
		window.open(baseUrl+'/patients/'+value_id, '_blank');
		value_id = [];
		$('#modal-print-patient').modal('toggle');
	}else{
		toastr.error('Kindly Select Patient Record First');
	}
});	

function printMultipleTable(count) {
	$('#modal-print-patient .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/printMultiple/'+count,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
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
