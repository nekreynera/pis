$(document).ready(function () {
   $('.saveButton').on('click', function () {
       event.preventDefault();
       var answer = confirm('Save this consultation?');
       if (answer){
           $('#consultationForm').submit();
       }
   });
});


$('.saveButton').on('click', function () {
    event.preventDefault();
    $('#diagnosisForm').submit();
});

$(function () {
    icd('loadFirst');
});

$('#icdSearchForm').on('submit', function () {
    icd('searchActivate');
});
$('#icdSearchCodeForm').on('submit', function () {
    icd('searcCodeActivate');
});

function icd(scope) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    $('#tableICD').css({'opacity':.4});

    if (scope == 'loadFirst') {
        var url = baseUrl + "/searchICD";
        var searchkey = '';
    }else if(scope == 'searchActivate'){
        var url = baseUrl + "/searchICD";
        var searchkey = $('#icdSearchForm').find('input[name="search"]').val();
    }else if(scope == 'searcCodeActivate'){
        var url = baseUrl + "/searchICDByCode";
        var searchkey = $('#icdSearchCodeForm').find('input[name="search"]').val();
    }else{
        var href = $(scope).attr('href');
        var locator = href.split('?');
        var url = baseUrl+"/searchICD?"+locator[1];
        var searchkey = $('#search').val();
    }

    request = $.ajax({
        url: url,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'searchkey':searchkey},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {

        if(response.total > 0){

            /*---- get all selected icd ----------*/
            var selectedIcds = [];
            $('.icdsContainer').find('div.form-group').each(function (index) {
                selectedIcds[selectedIcds.length] = $(this).attr('data-icd');
            });

            $('.totalICDS').text(Number(response.total));

            var ul = $('<ul class="pagination">');
            var prev_page_url = (response.prev_page_url == null)? 'disabled' : '';
            var actionPreview = (response.prev_page_url == null)? 'onclick="return false"' : 'onclick="icd($(this))"';
            var prev_anchor_url = (response.prev_page_url == null)? '#' : response.prev_page_url;
            var preview = $('<li class="'+prev_page_url+' previous">');
            var angleLeft = $('<i class="fa fa-angle-double-left">');
            var anchorPreview = $('<a href="'+prev_anchor_url+'" rel="prev" '+actionPreview+'>').append(angleLeft);
            $(ul).append($(preview).append(anchorPreview));

            if (response.last_page > 9 && response.current_page > 9) {
                var li_first_page = $('<li>');
                var anchor_first_page =  $('<a href="'+response.first_page_url+'" onclick="icd($(this))">').text('...');
                $(ul).after('li.previous').append($(li_first_page).append(anchor_first_page));
            }

            $('#icdTbody').empty();

            $.each(response.data, function (index) {
                var isInArray = $.inArray(''+response.data[index].id+'', selectedIcds);
                if (isInArray != -1) {
                    var checkThisBox = 'checked';
                }else{
                    var checkThisBox = '';
                }
                var tr = $('<tr>');
                var input = $('<input '+checkThisBox+' type="checkbox" value="'+response.data[index].id+'" onclick="selectICD($(this))">');
                var td1 = $('<td>').append(input);
                var td2 = $('<td class="icdcode">').text(response.data[index].code);
                var td3 = $('<td class="description">').text(response.data[index].description);
                $('#icdTbody').append($(tr).append($(tr).append(td1,td2,td3)));
            });

            if (response.last_page > 9 && response.current_page > 4 && response.current_page < (response.last_page - 4)){
                var startPage = response.current_page - 4;
                var endPage = response.current_page + 5;
            }else if(response.last_page > 9 && response.current_page < 5){
                var startPage = 1;
                var endPage = 10;
            }else if(response.last_page > 9 && response.current_page >= (response.last_page - 5)){
                var startPage = response.last_page - 8;
                var endPage = response.last_page + 1;
            }else{
                var startPage = 1;
                var endPage = response.last_page + 1;
            }

            for(var i=startPage;i<endPage;i++){
                var active = (response.current_page == i)? 'active' : '';
                var li = $('<li class="'+active+'">');
                var a = $('<a href="'+baseUrl+'/diagnosis?page='+i+'" onclick="icd($(this))">').text(i);
                $(ul).append($(li).append(a));
            }


            var next_page_url = (response.next_page_url == null)? 'disabled' : '';
            var next_anchor_url = (response.next_page_url == null)? '#' : response.next_page_url;
            var actionNext = (response.next_page_url == null)? 'onclick="return false"' : 'onclick="icd($(this))"';
            var next = $('<li class="'+next_page_url+'" id="nextlist">');
            var angleLRight = $('<i class="fa fa-angle-double-right">');
            var anchorNext = $('<a href="'+next_anchor_url+'" rel="next" '+actionNext+'>').append(angleLRight);
            $(ul).append($(next).append(anchorNext));


            if (response.last_page > 9 && response.current_page != response.last_page) {
                var li_last_page = $('<li>');
                var anchor_last_page =  $('<a href="'+response.last_page_url+'" onclick="icd($(this))">').text('...');
                $(next).before($(li_last_page).append(anchor_last_page));
            }

            $('#paginator').empty().append(ul);

        }else{
            $('.totalICDS').text(0);
            var tr = $('<tr>');
            var strong = $('<strong class="text-danger">').text('No results found!');
            var td = $('<td class="text-center" colspan="3">').append(strong);
            $('#icdTbody').empty().append($(tr).append(td));
            $('#paginator').empty();
        }

    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
        $('#tableICD').css({'opacity':1});
    });

}
function selectICD(scope) {
    var isChecked = $(scope).is(':checked');
    var description = $(scope).closest('td').siblings('td.description').text();
    var icdcode = $(scope).closest('td').siblings('td.icdcode').text();
    var id = $(scope).val();
    if(isChecked){
        insertICD(id, icdcode, description);
        var div = $('<div class="form-group input-group icd'+id+'" data-icd="'+id+'">');
        var input = $('<input type="text" class="form-control" value="('+icdcode+') '+description+'" readonly />');
        var icd = $('<input type="hidden" name="icd[]" value="'+id+'" />');
        var trash = $('<i class="fa fa-trash-o"></i>');
        var span = $('<span class="input-group-addon" data-code="'+icdcode+'" data-desc="'+description+'" data-id="'+id+'" onclick="removeICD($(this))">').append(trash);
        $('.icdsContainer').append($(div).append(icd, input, span));
    }else{
        var confrm = confirm('Do you really want to delete this icd code?');
        if(confrm){
            deleteICD(id, icdcode, description);
            $('.icdsContainer').children('div.icd'+id).fadeOut('slow', function () {
                $(this).remove();
            });
            var ed = tinyMCE.activeEditor;
            var newNode = ed.dom.select('span#uniqueId');
            ed.selection.select(newNode[0]);
        }else{
            $(scope).prop('checked', true);
        }
    }
}


function insertICD(id, icdcode, description){
    /*var ed = tinyMCE.activeEditor;
    var newNode = ed.dom.select('span#uniqueId');
    ed.selection.select(newNode[0]);*/
    tinymce.activeEditor.execCommand('mceInsertContent', false, '<strong id="'+id+'" class="mceNonEditable">('+icdcode+') '+description+'</strong>&nbsp;');
}

function deleteICD(id, icdcode, description) {
    var editor = tinymce.get('diagnosis');
    var content = editor.getContent();
    content = content.replace('<strong id="'+id+'" class="mceNonEditable">('+icdcode+') '+description+'</strong>', '');
    editor.setContent(content);
}

function removeICD(scope) {
    var confrm = confirm('Do you really want to delete this icddsad code?');
    if(confrm){
        var dicd = $(scope).attr('data-dicd');
        var description = $(scope).attr('data-desc');
        var icdcode = $(scope).attr('data-code');
        var id = $(scope).attr('data-id');
        if(dicd == '' || dicd == null || dicd == 'undefined'){
            deleteICD(id, icdcode, description);
            $('.icdsContainer').children('div.icd'+id).fadeOut('slow', function () {
                $(this).remove();
            });
            $('input[type="checkbox"]').each(function (index) {
                if($(this).val() == id){
                    $(this).prop('checked', false);
                }
            });
        }else{
            request = $.ajax({
                url: baseUrl+'/deleteCICD',
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id':dicd}
            });
            request.done(function (response, textStatus, jqXHR) {
                toastr.error("ICD has been deleted.");
                deleteICD(id, icdcode, description);
                $('.icdsContainer').children('div.icd'+id).fadeOut('slow', function () {
                    $(this).remove();
                });
                $('input[type="checkbox"]').each(function (index) {
                    if($(this).val() == id){
                        $(this).prop('checked', false);
                    }
                });
            });
        }
        var ed = tinyMCE.activeEditor;
        var newNode = ed.dom.select('span#uniqueId');
        ed.selection.select(newNode[0]);
    }

}



$('#teddy').on('click', function () {
   alert('dasdasd');
});




/*------- abang la hit icd floating ---------*/

/*$(document).ready(function () {
    $('.deleteThisICD').hover(function () {
        $(this).css({'background-color':'red','border':'1px solid red'});
        $(this).siblings('input').css({'visibility':'visible'});
        $(this).find('i').removeClass('fa-bug');
        $(this).find('i').addClass('fa-trash');
    }, function(){
        $(this).css({'background-color':'lawngreen','border':'1px solid green'})
        $(this).siblings('input').css({'visibility':'hidden'});
        $(this).find('i').removeClass('fa-trash');
        $(this).find('i').addClass('fa-bug');
        }
    );
});*/
