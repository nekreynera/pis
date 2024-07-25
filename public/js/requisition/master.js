/*---------- for MSS Classification --------*/

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

/*----------- for MSS Classification ----------*/


function blurTable($scope) {
    $('.loaderWrapper').fadeIn('fast');
    $('#itemsDeptTable').css({'opacity':'.3'});
    $($scope).css({'background-color':'#333','color':'#fff'});
    $($scope).siblings('a').css({'background-color':'#fff','color':'#333'});
}



function chooseItem(scope) {
    $('.noSelectedTRwrapper').fadeOut(0);
    var id = $(scope).attr('data-id');
    var category = $(scope).attr('data-category');
    if(category == '1031'){
        var checkCategory = id+'M';
    }else{
        var checkCategory = id;
    }
    if ($(scope).is(':checked')){
        var item_id = $(scope).closest('tr').find('td.item_id').text();
        var item_description = $(scope).closest('tr').find('td.item_description').text();
        var price = $(scope).closest('tr').find('td.price').text();
        var discount = (price * patientDiscount).toFixed(2);
        var total = Math.abs((price - discount).toFixed(2));
        var unitofmeasure = $(scope).closest('tr').find('td.unitofmeasure').text();
        var tr = $('<tr>');
        var inputCategory = $('<input type="hidden" name="category[]" value="'+category+'">');
        var inputCheckbox = $('<td>').append('<input type="checkbox" name="item[]" value="'+id+'" ' +
            'data-check="'+checkCategory+'" data-id="'+id+'" onclick="removeItem($(this))" checked />');
        var td1 = $('<td>').append(inputCategory, inputCheckbox);
        var td2 = (item_id == '')? $('<td class="text-danger">').text('N/A') : $('<td>').text(item_id);
        var td3 = $('<td>').text(item_description);
        var td4 = $('<td class="tdprice">').text(price);
        var td5 = $('<td>').append('<input type="number" value="1" name="qty[]" class="qty" onchange="changeqty($(this))" />');
        var td6 = $('<td class="tdamount">').text(price);
        var td7 = $('<td class="tddiscount">').text('-'+discount);
        var td8 = $('<td class="tdtotal">').text(total);
        var td9 = (unitofmeasure == '')? $('<td class="text-danger">').text('N/A') : $('<td>').text(unitofmeasure);
        $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8,td9);
        $('.selectedItemsTbody').append(tr);
        grandTotal();
    }else{
        var ans = confirm('Do you really want to delete this requisition?');
        if (ans){
            $('.selectedItemsTbody input[type="checkbox"]').each(function (index) {
                if (checkCategory == $(this).attr('data-check')) {
                    $(this).closest('tr').remove();
                }
            });

        }else{
            event.preventDefault();
        }
        grandTotal();
    }
    return;
}


function removeItem(scope) {
    var ans = confirm('Do you really want to delete this requisition?');
    if (ans){
        var id = $(scope).attr('data-check');
        $('.selectitemsTbody input[type="checkbox"]').each(function (index) {
            var data_id = $(this).attr('data-check');
            if (data_id == id) {
                $(this).removeAttr('checked');
            }
        });
        $(scope).closest('tr').remove();
    }else{
        event.preventDefault();
    }
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



function search($scope) {
    var filter = $($scope).val().toUpperCase();
    var table = document.getElementById("itemsDeptTable");
    var tr = table.getElementsByTagName("tr");
    for (var i = 0; i < tr.length; i++) {
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
        td3 = tr[i].getElementsByTagName("td")[5];

        var searchType = $($scope).attr('data-search');
        if(searchType == 'description')
        {
            if ($($scope).hasClass('labsSearch')){
                if (td1) {
                    if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }else{
                if (td2) {
                    if (td2.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }else if(searchType == 'item'){
            if (td1) {
                if (td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }else{
            if (td3) {
                if (td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

    }
}



$(document).ready(function(){
    $('.cancel').on('click', function(){
        $('.selectedItemsTbody tr').not('.noSelectedTRwrapper').remove();
        grandTotal();
        $('.selectitemsTbody input').each(function (index) {
            $(this).removeAttr('checked');
        });
        toastr.error("Requisition canceled.");
    });
});




