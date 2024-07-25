function qrcode_open($scope)
{
    event.preventDefault();
    $($scope).parent().toggleClass('open');
    $($scope).closest('li').find('input[type="text"]').focus();
}

function queue_search_open($scope)
{
    event.preventDefault();
    $($scope).parent().toggleClass('open');
    $($scope).closest('li').find('input[type="text"]').focus();
}

$('body').on('click', function (e) {
    if (!$('li.qrcode_main_wrapper').is(e.target)
        && $('li.qrcode_main_wrapper').has(e.target).length === 0
        && $('.open').has(e.target).length === 0
    ) {
        $('li.qrcode_main_wrapper').removeClass('open');
    }
    if (!$('li.search_queue_wrapper').is(e.target)
        && $('li.search_queue_wrapper').has(e.target).length === 0
        && $('.open').has(e.target).length === 0
    ) {
        $('li.search_queue_wrapper').removeClass('open');
    }
});
