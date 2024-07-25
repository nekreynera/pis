function medsWatch($scope) {
    event.preventDefault();
    $('.medsPrint').fadeIn(0);
    $('.loaderWrapper').fadeIn(0);
    request = $.ajax({
        url: baseUrl+'/medsWatch',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'id':$scope},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response.length > 0) {
            $('.recordsThead').empty();
            $('.medsWatchTbody').empty();
            var thead = medsThead();
            $('.recordsThead').append(thead);

            for (var i = 0; i < response.length; i++) {
                var content = medContent(response, i);
                $('.medsWatchTbody').append(content);
            }
            $('#recordsModal').modal();
            $('.medsPrint').attr('href',baseUrl+'/requisition_print/'+$scope);
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}


function medContent(response, $i) {
    var pmQty = (response[$i].pmQty != null)? response[$i].pmQty : 0;
    var checkBoxDisabled = (response[$i].pmQty == response[$i].qty)? 'disabled' : '';
    var checkAuth = (response[$i].users_id != auth)? 'disabled' : '';
    var dateRequested = formatDate(response[$i].createdDate);
    var content = '<tr>\n' +
        '                                <td>'+response[$i].item_id+'</td>\n' +
        '                                <td>'+response[$i].item_description+'</td>\n' +
        '                                <td>'+response[$i].brand+'</td>\n' +
        '                                <td>'+response[$i].price+'</td>\n' +
        '                                <td>'+response[$i].unitofmeasure+'</td>\n' +
        '                                <td>'+dateRequested+'</td>\n' +
        '                                <td>'+pmQty+'</td>\n' +
        '                                <td>\n' +
        '                                    <button class="btn btn-default btn-circle deleteBtn" onclick="deleteMeds($(this))" disabled>\n' +
        '                                        <i class="fa fa-trash text-danger"></i>\n' +
        '                                    </button>\n' +
        '                                </td>\n' +
        '                                <td>\n' +
        '                                    <button class="btn btn-default btn-circle updateBtn" onclick="updateMeds($(this))" disabled>\n' +
        '                                        <i class="fa fa-upload text-primary"></i>\n' +
        '                                    </button>\n' +
        '                                </td>\n' +
        '                                <td>\n' +
        '                                    <input type="number" data-rid="'+response[$i].rid+'" data-qty="'+pmQty+'" value="'+response[$i].qty+'" class="form-control qtyTobeEdited" disabled>\n' +
        '                                </td>\n' +
         '                               <td>\n' +
    '                                       <input type="checkbox" '+checkAuth+' '+checkBoxDisabled+' onclick="enableCheckbosMeds($(this))">\n' +
    '                                    </td>\n' +
        '                            </tr>';
    return content;
}




function medsThead() {
    var thead = '<tr>\n' +
        '                            <th>ITEM ID</th>\n' +
        '                            <th>ITEM DESCRIPTION</th>\n' +
        '                            <th>BRAND</th>\n' +
        '                            <th>PRICE</th>\n' +
        '                            <th>UNIT</th>\n' +
        '                            <th>DATE</th>\n' +
        '                            <th>QTY_RENDERED</th>\n' +
        '                            <th>DELETE</th>\n' +
        '                            <th>UPDATE</th>\n' +
        '                            <th>QTY</th>\n' +
        '                            <th><i class="fa fa-question"></i></th>\n' +
        '                        </tr>';
    return thead;
}



function enableCheckbosMeds($scope) {
    if ($($scope).is(':checked')){
        $($scope).closest('tr').css({'background-color':'#ccfff2'}).find('input.qtyTobeEdited').removeAttr('disabled');
        $($scope).closest('tr').find('button.updateBtn').removeAttr('disabled');
        if (!$($scope).hasClass('thisdisabled')){
            $($scope).closest('tr').find('button.deleteBtn').removeAttr('disabled');
        }
    }else{
        $($scope).closest('tr').css({'background-color':'transparent'}).find('input.qtyTobeEdited').prop('disabled','true');
        $($scope).closest('tr').find('button.updateBtn').prop('disabled','true');
        if (!$($scope).hasClass('thisdisabled')){
            $($scope).closest('tr').find('button.deleteBtn').prop('disabled','true');
        }
    }
}


function updateMeds($scope) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    var qty = $($scope).closest('tr').find('input.qtyTobeEdited').val();
    var renderedQty = $($scope).closest('tr').find('input.qtyTobeEdited').attr('data-qty');
    var rid = $($scope).closest('tr').find('input.qtyTobeEdited').attr('data-rid');

    if(parseInt(qty) < parseInt(renderedQty)){
        alert('Quantity must be greater than qty rendered.');
        $('.loaderWrapper').fadeOut(0);
    }else{
        request = $.ajax({
            url: baseUrl+'/medsUpdate',
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'rid':rid,'qty':qty}
        });
        request.done(function (response, textStatus, jqXHR) {
            $($scope).closest('tr').find('input[type="checkbox"]').click();
            toastr.success("Medicine successfully updated");
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });
        request.always(function(){
            $('.loaderWrapper').fadeOut(0);
        });
    }
}


function deleteMeds($scope) {
    var ans = confirm('Delete this medecine?');
    if(ans){
        $('.loaderWrapper').fadeIn(0);
        var rid = $($scope).closest('tr').find('input.qtyTobeEdited').attr('data-rid');
        request = $.ajax({
            url: baseUrl+'/medsDelete',
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'rid':rid}
        });
        request.done(function (response, textStatus, jqXHR) {
            $($scope).closest('tr').remove();
            toastr.error("Medicine has been deleted");
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });
        request.always(function(){
            $('.loaderWrapper').fadeOut(0);
        });
    }
}






