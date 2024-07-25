var region = "";
var province = "";
var city_municipality = "";
var brgy = "";

$(document).ready(function () {
	$("#address").on('focus', function(){
		$("#addressModal").modal("show");
		$("select[name='province']").focus();
	});
});



/*---------------------------- REGION --------------------------*/


$(document).ready(function () {

	request = $.ajax({
		url: baseUrl+"/regions",
		type: "get",
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		if (response.length > 0) {
			for (var i = 0 ; i < response.length; i++) {
				if (response[i].regCode == '08') {
					var selected = "selected";
					region = response[i].regDesc;
				}else{
					var selected = "";
				}
				var option = $('<option '+ selected +'>').val(response[i].regCode).text(response[i].regDesc);
				$("select[name='region']").append(option);
			}
			showProvince('08');
			// errorHide();
			//$("#address").val(region);
		}
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

});




/*----------------------- PROVINCE ------------------------*/


function showProvince($scope){
		$("select[name='province']").find('option').first().text('Loading...');

		$("select[name='province']").find('option').first().nextUntil().remove();
		$("select[name='city_municipality']").find('option').first().nextUntil().remove();
		$("select[name='brgy']").find('option').first().nextUntil().remove();

		if ($scope == '08') {
			var regCode = '08';
			region = $("select[name='region'] option[value="+regCode+"]").text();
		}else{
			var regCode = $($scope).val();
			region = $("select[name='region'] option[value="+regCode+"]").text();
			$("#address").val(region);
		}

		request = $.ajax({
			url: baseUrl+"/province",
			type: "post",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'regCode':regCode},
			dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			$("select[name='province']").find('option').first().nextUntil().remove();
			if (response.length > 0) {
				for (var i = 0 ; i < response.length; i++) {
					var option = $('<option>').val(response[i].provCode).text(response[i].provDesc);
					$("select[name='province']").append(option);
				}
				$("select[name='province']").focus();
				var spin = $('<i class="fa fa-spinner fa-spin text-success">');
				$('.provinceLabel').append(spin);
				errorHide();
			}
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
	   	});

	   	request.always(function(){
	   		$("select[name='province']").find('option').first().text('Select Province');
			$('.provinceLabel').find('i').fadeOut('slow');
	   	});

}

$(document).ready(function () {
	$($("select[name='province']")).on('click', function () {
		if($("select[name='region']").val() == ''){
			$('.provinceError').fadeIn('fast');
		}
	});
});







/*----------------------- CITY / MUNICIPALITY ------------------------*/


$(document).ready(function () {

	$("select[name='province']").on('change', function(){
			$("select[name='city_municipality']").find('option').first().text('Loading...');

			$("select[name='city_municipality']").find('option').first().nextUntil().remove();
			$("select[name='brgy']").find('option').first().nextUntil().remove();

			var provCode = $(this).val();
			province = $("select[name='province'] option[value="+provCode+"]").text();
			$("#address").val(region+', '+province);

			request = $.ajax({
				url: baseUrl+"/city_municipality",
				type: "post",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {'provCode':provCode},
				dataType: "json"
			});

			request.done(function (response, textStatus, jqXHR) {
				$("select[name='city_municipality']").find('option').first().nextUntil().remove();
				if (response.length > 0) {
					for (var i = 0 ; i < response.length; i++) {
						var option = $('<option>').val(response[i].citymunCode).text(response[i].citymunDesc);
						$("select[name='city_municipality']").append(option);
					}
					$("select[name='city_municipality']").focus();
					var spin = $('<i class="fa fa-spinner fa-spin text-success">');
					$('.citymunicipalityLabel').append(spin);
					errorHide();
				}
			});

			request.fail(function (jqXHR, textStatus, errorThrown){
		       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
		   	});

		   	request.always(function(){
		   		$("select[name='city_municipality']").find('option').first().text('Select Province');
				$('.citymunicipalityLabel').find('i').fadeOut('slow');
		   	});

	});

});


	$(document).ready(function () {
		$($("select[name='city_municipality']")).on('click', function () {
			if($("select[name='province']").val() == ''){
				$('.citymunError').fadeIn('fast');
			}
		});
	});




/*----------------------- BARANGAY ------------------------*/


$(document).ready(function () {

	$("select[name='city_municipality']").on('change', function(){
			$("select[name='brgy']").find('option').first().text('Loading...');

			$("select[name='brgy']").find('option').first().nextUntil().remove();

			var citymunCode = $(this).val();
			city_municipality = $("select[name='city_municipality'] option[value="+citymunCode+"]").text();
			$("#address").val(region+', '+province+', '+city_municipality);

			request = $.ajax({
				url: baseUrl+"/brgy",
				type: "post",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {'citymunCode':citymunCode},
				dataType: "json"
			});

			request.done(function (response, textStatus, jqXHR) {
				$("select[name='brgy']").find('option').first().nextUntil().remove();
				if (response.length > 0) {
					for (var i = 0 ; i < response.length; i++) {
						var option = $('<option>').val(response[i].id).text(response[i].brgyDesc);
						$("select[name='brgy']").append(option);
					}
					$("select[name='brgy']").focus();
					var spin = $('<i class="fa fa-spinner fa-spin text-success">');
					$('.brgyLabel').append(spin);
					errorHide();
				}
			});

			request.fail(function (jqXHR, textStatus, errorThrown){
		       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
		   	});

		   	request.always(function(){
		   		$("select[name='brgy']").find('option').first().text('Select Province');
				$('.brgyLabel').find('i').fadeOut('slow');
		   	});

	});

});


	$(document).ready(function () {
		$($("select[name='brgy']")).on('click', function () {
			if($("select[name='city_municipality']").val() == ''){
				$('.brgyError').fadeIn('fast');
			}
		});
	});



	$(document).ready(function () {
		$($("select[name='brgy']")).on('change', function () {
			brgy = $("select[name='brgy'] option[value="+$(this).val()+"]").text();
			$("#address").val(region+', '+province+', '+city_municipality+', '+brgy);
		});
	});





// function errorHide() {
// 	$('p.text-danger').fadeOut(0);
// }


















