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
                var tr = $('<tr>');
                var td1 = $('<td>').text(response.from + (index));
                var td2 = $('<td>').text(response.data[index].code);
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
