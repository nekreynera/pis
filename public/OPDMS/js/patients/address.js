var region = "";
var province = "";
var city_municipality = "";
var brgy = "";
var citymunCode = "";
var brgyId = "";
var action = "";


var ED_region = "08";
var ED_province = "0837";
var ED_city = null;
var ED_brgy = null;


function gotoaddressFile(patientAdress) {
	ED_region = patientAdress.regCode;
	ED_province = patientAdress.provCode;
	ED_city = patientAdress.citymunCode;
	ED_brgy = patientAdress.id;
	// body...
}

$(document).on('focus', '.modal-body .store-address', function(){
    ED_region = "08";
	ED_province = "0837";
	ED_city = null;
	ED_brgy = null;
});


$(document).on('focus', '.modal-body .address', function(){
	var add = $(this);
	getRegion();
	$('#modal-address').modal('toggle');
	action = $(add).attr('action');
});




/*---------------------------- REGION --------------------------*/

function getRegion() {
	request = $.ajax({
		url: baseUrl+"/regions",
		type: "get",
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		if (response.length > 0) {
			$("select[name='region']").empty();
			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				if (response[i].regCode == ED_region) {
					selected = "selected";
					region = response[i].regDesc; 
				}
				var option = $('<option '+ selected +'>').val(response[i].regCode).text(response[i].regDesc);
				$("select[name='region']").append(option);
			}
			showProvince(ED_region);
		}
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});
}


	

/*----------------------- PROVINCE ------------------------*/


function showProvince(regCode){

	region = $("select[name='region'] option[value="+regCode+"]").text();

	request = $.ajax({
		url: baseUrl+"/province",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'regCode':regCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		$("select[name='province']").empty().prepend('<option>Select Province</option>');

		if (response.length > 0) {

			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				if (response[i].provCode == ED_province) {
					selected = "selected";
				}
				var option = $('<option '+ selected +'>').val(response[i].provCode).text(response[i].provDesc);
				$("select[name='province']").append(option);
			}

			showcityMunicipality(ED_province);

			var spin = $('<i class="fa fa-spinner fa-spin text-success">');
			$('.provinceLabel').append(spin);
		}

	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

   	request.always(function(){
		$('.provinceLabel').find('i').fadeOut('slow');
   	});

}

$(document).on('change', 'select[name="province"]', function () {

	var provCode = $(this).val();

	showcityMunicipality(provCode);

});



/*----------------------- CITY / MUNICIPALITY ------------------------*/

function showcityMunicipality(provCode){

	province = $("select[name='province'] option[value="+provCode+"]").text();

	request = $.ajax({
		url: baseUrl+"/city_municipality",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'provCode':provCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		$("select[name='city_municipality']").empty().prepend('<option>Select City/Municipality</option>');

		if (response.length > 0) {

			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				if (response[i].citymunCode == ED_city) {
					selected = "selected";
				}
				var option = $('<option '+ selected +'>').val(response[i].citymunCode).text(response[i].citymunDesc);
				$("select[name='city_municipality']").append(option);
			}

			showBrgy(ED_city);

			var spin = $('<i class="fa fa-spinner fa-spin text-success">');
			$('.citymunicipalityLabel').append(spin);

		}

	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

   	request.always(function(){
		$('.citymunicipalityLabel').find('i').fadeOut('slow');
   	});
}
/*----------------------- BARANGAY ------------------------*/
function showBrgy(citymunCode){

	$('.city_municipality_modal').val(citymunCode);

	city_municipality = $("select[name='city_municipality'] option[value="+citymunCode+"]").text();

	$("."+action+"-address").val(region+', '+province+', '+city_municipality);

	request = $.ajax({
		url: baseUrl+"/brgy",
		type: "post",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {'citymunCode':citymunCode},
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		$("select[name='brgy']").empty().prepend('<option>Select Brgy</option>');;
		if (response.length > 0) {
			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				if (response[i].id == ED_brgy) {
					selected = "selected";
					brgy = response[i].brgyDesc; 
				}
				var option = $('<option '+ selected +'>').val(response[i].id).text(response[i].brgyDesc);
				$("select[name='brgy']").append(option);
				$("."+action+"-address").val(region+', '+province+', '+city_municipality+', '+brgy);
			}
			var spin = $('<i class="fa fa-spinner fa-spin text-success">');
			$('.brgyLabel').append(spin);
		}
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

   	request.always(function(){
		$('.brgyLabel').find('i').fadeOut('slow');
   	});
}

$(document).on('change', "select[name='city_municipality']", function(){

	citymunCode = $(this).val();
	showBrgy(citymunCode);
	
});

$(document).ready(function () {
	$(document).on('change', "select[name='brgy']", function () {
		brgy = $("select[name='brgy'] option[value="+$(this).val()+"]").text();
		brgyId = $("select[name='brgy']").val(); 
		$('.brgy_modal').val(brgyId);
		$("."+action+"-address").val(region+', '+province+', '+city_municipality+', '+brgy);
	});
});

/*===============================================================*/

function errorHide() {
	$('p.text-danger').fadeOut(0);
}
	




















