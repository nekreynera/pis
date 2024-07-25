var patientDiscount = "";
var label = "";
var description = "";

$(function () {
    request = $.ajax({
        url: baseUrl+"/checkMssClassification",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
    	console.log(response)
		if (response){
            patientDiscount = response.discount;
            label = response.label;
            description = response.description;
		}else{
            patientDiscount = 0;
            label = 'A';
            description = 'Full Pay';
		}
		$('.classificationLabel').text(label);
		$('.classificationDisc').text(description+'%');
    });
});

$(document).ready(function () {
	$('.list-group a').on('click', function(e){

			$('.loaderWrapper').fadeIn('fast');
			$('#itemsDeptTable').css({'opacity':'.3'});
			$(this).css({'background-color':'#ccc'});
			$(this).siblings('a').css({'background-color':'white'});

			e.preventDefault();
			var clinic_code = $(this).attr('clinic-code');
			request = $.ajax({
				url: baseUrl+"/choosedepartment",
				type: "post",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {'clinic_code':clinic_code},
				dataType: "json"
			});
			request.done(function (response, textStatus, jqXHR) {
				if (response.length > 0) {
					$('.selectitemsTbody').empty();
					var selectedItemsOntable = $.makeArray($('.selectedItemsTbody tr').not('.noSelectedTRwrapper'));
					if(selectedItemsOntable.length > 0){
					    var arrayItemsSelect = [];
					    var disableThisCheckbox = [];
					    $(selectedItemsOntable).each(function (index) {
					        arrayItemsSelect.push($(this).find('input:checkbox').attr('data-id'));
					        var checkIFisEdited = $(this).find('input:checkbox').hasClass('data_disabled');
					        if (checkIFisEdited){
                                disableThisCheckbox.push($(this).find('input:checkbox').attr('data-id'));
							}
					    });
					}
					for (var i = 0; i < response.length; i++) {
						var na = $('<span class="text-danger">').text('N/A');
						var statColor = (response[i].status == 'Y' && response[i].stock)? 'bg-success' : 'bg-danger';
						var classColor = (response[i].status == 'Y' && response[i].stock)? '' : 'text-danger';
						var disabledInputIfNotMeds = (clinic_code != 1031)? 'disabled' : '';
						var tr = $('<tr class="'+statColor+'">');
						var td1 = $('<td>').append('<input type="checkbox" '+disabledInputIfNotMeds+' status="off" name="" data-id="'+response[i].id+'" onclick="chooseItem($(this))" />');
						var td2 = $('<td class="item_id ">').text(response[i].item_id);
						var td3 = $('<td class="item_description">').text(response[i].item_description);
						var td4 = $('<td class="item_brand '+classColor+'">').text((response[i].brand)? response[i].brand : 'N/A' );
                        var td5 = $('<td class="unitofmeasure '+classColor+'">').text((response[i].unitofmeasure)? response[i].unitofmeasure : 'N/A');
						var td6 = $('<td class="price">').text((response[i].price)? response[i].price : 'N/A');
						var td7 = $('<td class="stocks '+classColor+'">').text((response[i].stock)? response[i].stock : 'Out');
						var td8 = $('<td class="status '+classColor+'">').text((response[i].status && response[i].stock)? 'Available' : 'Unavailable');

						$('.selectitemsTbody').append($(tr).append(td1,td2,td3,td4,td5,td6,td7,td8));
						if(selectedItemsOntable.length > 0){
						    var isInArray = $.inArray(''+response[i].id+'', arrayItemsSelect);
						    var checkIfIsINarray = $.inArray(''+response[i].id+'', disableThisCheckbox);
						    if(isInArray != -1){
						        $(td1).find('input').attr({'checked':'true','status':'on'});
                                if(checkIfIsINarray != -1){
                                    $(td1).find('input').attr('disabled',true);
                                }
						    }
						}
					}
				}else{
					$('.selectitemsTbody').empty();
					var tr = '<tr><td colspan="8" class="text-center"><strong class="text-danger">Sorry! laboratory module is under development.</strong></td></tr>';
					$('.selectitemsTbody').append(tr);
				}
				$('#countResults').text(response.length);
			});
			request.fail(function (jqXHR, textStatus, errorThrown){
		       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
		   	});
		  request.always(function(){
		  	$('.loaderWrapper').fadeOut('fast');
              $('#itemsDeptTable').css({'opacity':'1'});
		  });
	});

});






		function chooseItem(scope) {
			$('.noSelectedTRwrapper').fadeOut(0);
			if($(scope).attr('status') == 'off'){
				$(scope).attr('status','on');
				var id = $(scope).attr('data-id');
				var item_id = $(scope).closest('tr').find('td.item_id').text();
				var item_description = $(scope).closest('tr').find('td.item_description').text();
				var price = $(scope).closest('tr').find('td.price').text();
				var stocks = $(scope).closest('tr').find('td.stocks').text();
				var unitofmeasure = $(scope).closest('tr').find('td.unitofmeasure').text();
				var discount = (price * patientDiscount).toFixed(2);
				var total = Math.abs((price - discount).toFixed(2));
				var tr = $('<tr>');
				var td1 = $('<td>').append('<input type="checkbox" name="item[]" value="'+id+'" data-id="'+id+'" onclick="removeItem($(this))" checked />');
				var td2 = $('<td>').text(item_id);
				var td3 = $('<td>').text(item_description);
				var td4 = $('<td class="tdprice">').text(price);
				var td5 = $('<td>').append('<input type="number" value="1" name="qty[]" class="qty" onchange="changeqty($(this))" />');
				var td6 = $('<td class="tdamount">').text(price);
				var td7 = $('<td class="tddiscount">').text('-'+discount);
				var td8 = $('<td class="tdtotal">').text(total);
				var td9 = $('<td>').text(unitofmeasure);
				$(tr).append(td1,td2,td3,td4,td5,td6,td7,td8,td9);
				$('.selectedItemsTbody').append(tr);
				grandTotal();
		}else{
			$(scope).attr('status','off');
			$('.selectedItemsTbody input').each(function (index) {
			    var data_id = $(scope).attr('data-id');
			    if (data_id == $(this).attr('data-id')) {
			    	$(this).closest('tr').remove();
			    }
			});
			grandTotal();
		}
			return;
	}


		function removeItem(scope) {
			var id = $(scope).attr('data-id');
			$('.selectitemsTbody input').each(function (index) {
			    var data_id = $(this).attr('data-id');
			    if (data_id == id) {
			    	$(this).removeAttr('checked');
			    }
			});
			$(scope).closest('tr').remove();
			grandTotal();
		}



		function changeqty(scope){
			if($(scope).val() > 0){
				var qty = $(scope).val();
			}else{
				var qty = 1;
				$(scope).val(1)
			}
			var amount = $(scope).closest('td').siblings('td.tdprice').text() * qty;
			var discount = amount * patientDiscount;
			var total = amount - discount;
			$(scope).closest('td').siblings('td.tdamount').text(amount);
			$(scope).closest('td').siblings('td.tddiscount').text(-discount.toFixed(2));
			$(scope).closest('td').siblings('td.tdtotal').text(total.toFixed(2));
			grandTotal();
			return;
		}



		function grandTotal() {
				if($('.selectedItemsTbody tr').not('.noSelectedTRwrapper').length > 0){
					var total = 0;
			    $('.selectedItemsTbody td.tdtotal').each(function () {
			        total += Number($(this).text());
			    });
                var grndTotal = formatCurrency(total);
			    $('#grndTotal').text(grndTotal);
					$('tfoot').fadeIn(0);
					$('.submitRequisition').fadeIn(0);
				}else{
					$('tfoot').fadeOut(0);
					$('.submitRequisition').fadeOut(0);
					$('.noSelectedTRwrapper').fadeIn(0);
				}

		}

function formatCurrency(total) {
    var neg = false;
    if(total < 0) {
        neg = true;
        total = Math.abs(total);
    }
    return parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}


// function search($scope) {
//     var filter = $($scope).val().toUpperCase();
//     var table = document.getElementById("itemsDeptTable");
//     var tr = table.getElementsByTagName("tr");
//     for (var i = 0; i < tr.length; i++) {
//         td1 = tr[i].getElementsByTagName("td")[1];
//         td2 = tr[i].getElementsByTagName("td")[2];
//         td3 = tr[i].getElementsByTagName("td")[5];

//         var searchType = $($scope).attr('data-search');
//         if(searchType == 'description')
//         {
//             if (td2) {
//                 if (td2.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
//                     tr[i].style.display = "";
//                 } else {
//                     tr[i].style.display = "none";
//                 }
//             }
//         }else if(searchType == 'item'){
//             if (td1) {
//                 if (td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
//                     tr[i].style.display = "";
//                 } else {
//                     tr[i].style.display = "none";
//                 }
//             }
//         }else{
//             if (td3) {
//                 if (td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
//                     tr[i].style.display = "";
//                 } else {
//                     tr[i].style.display = "none";
//                 }
//             }
//         }

//     }
// }



$(document).ready(function(){
		$('.cancel').on('click', function(){
			$('.selectedItemsTbody tr').not('.noSelectedTRwrapper').remove();
			grandTotal();
			$('.selectitemsTbody input').each(function (index) {
			    $(this).removeAttr('checked');
                $(this).attr('status','off');
			});
			toastr.error("Requisition canceled.");
		});
});
