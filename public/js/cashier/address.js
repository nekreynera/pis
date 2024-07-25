$('select.region').on('select2:select', function (e) {
    var data = e.params.data;
    var regCode = data.id;
    getprovinces(regCode);
});

function getprovinces(regCode) {
	request = $.ajax({
		url: baseUrl+"/province",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'regCode':regCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		$("select[name='province']").empty().prepend('<option value="" hidden>Select Province</option>');

		if (response.length > 0) {

			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				// if (response[i].provCode == ED_province) {
				// 	selected = "selected";
				// }
				var option = $('<option '+ selected +'>').val(response[i].provCode).text(response[i].provDesc);
				$("select[name='province']").append(option);
			}
			// getcityMunicipality(ED_province);
		}
	});
   	request.always(function(){
		$("select[name='city_municipality']").empty().prepend('<option value="" hidden>Select Province first</option>');
		$("select[name='brgy']").empty().prepend('<option value="" hidden>Select Province first</option>');
   	});
}

$(document).on('select2:select', 'select.province', function (e) {
    var data = e.params.data;
    var provCode = data.id;
    getcityMunicipality(provCode);
});



function getcityMunicipality(provCode){

	request = $.ajax({
		url: baseUrl+"/city_municipality",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'provCode':provCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		$("select[name='city_municipality']").empty().prepend('<option value="" hidden>Select City/Municipality</option>');

		if (response.length > 0) {

			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				// if (response[i].citymunCode == ED_city) {
				// 	selected = "selected";
				// }
				var option = $('<option '+ selected +'>').val(response[i].citymunCode).text(response[i].citymunDesc);
				$("select[name='city_municipality']").append(option);
			}

			// showBrgy(ED_city);
		}
	});
	request.always(function(){
		$("select[name='brgy']").empty().prepend('<option value="" hidden>Select City/Municipality first</option>');
   	});
}

$(document).on('select2:select', 'select.city_municipality', function(e){
	var data = e.params.data;
    var citymunCode = data.id;
	getBrgy(citymunCode);
});

function getBrgy(citymunCode){
	request = $.ajax({
		url: baseUrl+"/brgy",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'citymunCode':citymunCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		$("select[name='brgy']").empty().prepend('<option value="" hidden>Select Brgy</option>');;
		if (response.length > 0) {
			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				// if (response[i].id == ED_brgy) {
				// 	selected = "selected";
				// 	brgy = response[i].brgyDesc; 
				// }
				var option = $('<option '+ selected +'>').val(response[i].id).text(response[i].brgyDesc);
				$("select[name='brgy']").append(option);
			}
		}
	});
  
}


