$('#description').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("description");
    filter = name.value.toUpperCase();
    table = document.getElementById("itemsDeptTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }

})

/*========================== for selection of particular====================================*/
var mss = $('.selectedItemsTbody').attr('id');
$(document).on('change', '.check-item', function(){

    var id = $(this).attr('data-id');
    var description = $(this).closest('tr').find('.item_description').text()
    var price = $(this).closest('tr').find('.price').text()
    $('.noSelectedTRwrapper').hide();
    
    var discount = Number(price) * Number(mss);
    var netamount = Number(price) - Number(discount);

    var tr = $('<tr>');
    var td1 = '<td><input type="checkbox" name="particular_id[]" value='+id+' status="off" data-id='+id+' class="check-item2" style="margin-top: 0px;" checked/></td>';
    var td2 = $('<td>').text(description);
    var td3 = $('<td class="selprice">').text(price);
    var td4 = '<td><input type="number" class="form-control qtypart" name="qty[]" value="1"/><input type="hidden" class="form-control pricepart" name="price[]" value='+price+'/></td>';
    var td5 = $('<td class="selamount">').text(price);
    var td6 = $('<td class="seldiscount">').text(discount.toFixed(2));
    var td7 = $('<td class="selnetamount">').text(netamount.toFixed(2));
    var tr2 = $('</tr>');

    $(tr).append(td1, td2, td3, td4, td5, td6, td7);

    if (this.checked) {
        $('.selectedItemsTbody').append(tr);    
         
    }else{

        $('td .check-item2').each(function(){
            var select = $(this).attr('data-id');
            if (id == select) {
                $(this).closest('tr').remove();
            }
        })
    }
    fortotal();
  
})
$(document).on('click', '.check-item2', function(){
    
    var select = $(this).attr('data-id');
    $('td .check-item').each(function(){
        var id = $(this).attr('data-id');
        if (select == id) {
            $(this).attr('checked', false);
        }
    })
    $(this).closest('tr').remove();
    fortotal();
})

/*================================== for pricing ===============================================*/
$(document).on('change', '.qtypart', function(){
    var qty = $(this).val();
    var price = $(this).closest('tr').find('.selprice').text();
    var amount = Number(qty) * Number(price);
    $(this).closest('tr').find('.selamount').text(amount.toFixed(2));
    var discount = Number(amount) * Number(mss);
    $(this).closest('tr').find('.seldiscount').text(discount.toFixed(2));
    var netamount = Number(amount) - Number(discount);
    $(this).closest('tr').find('.selnetamount').text(netamount.toFixed(2));
    fortotal();

})
function fortotal(){
    var netamount = 0;
    $('.selamount').each(function(){
        var am = $(this).closest('tr').find('.selnetamount').text();
        netamount += Number(am); 
    });
    $('#grndTotal').text(netamount.toFixed(2));
}

$(document).on('click', '#saverequisition', function(){
    // alert(12);
    $('#requisitionformlab').submit();
})


