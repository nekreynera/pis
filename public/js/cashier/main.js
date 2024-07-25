
$('#scan-modal').on('shown.bs.modal', function(){
    $('#scan-modal input').val('').focus();
})

$('#editreciept-modal').on('shown.bs.modal', function(){
    $('#editreciept-modal input').val('').focus();
})

$('.modal-button').click(function(){
    $('#scan-modal').modal('toggle');
    var id = ($(this).attr('id'));
    $('#scan-modal form').attr('class', id+'form')
})

$('#edit-reciept').click(function(){
    $(this).toggleClass("fa-remove");
    $('.invoicno').css('display', 'none');
    $('.input-reciept').css('display', 'block').focus();
})

$(document).on('click', '.fa-remove',function(){
    $('.invoicno').show();
    $('.input-reciept').css('display', 'none');
})
$('.submitreciept').submit(function(e){
    e.preventDefault();
    var reciept = $('.input-reciept').val();
    var type = $('.select-reciept').val();
    $('.reciept-msg').text('O.R number save').css('display', 'block')
    $('.invoicno').val(reciept).show();
    $.post(baseUrl+"/setrecieptnumber", {
        reciept: reciept,
        type: type,
      },
        function (data, status){
        }
    );
    setTimeout(function(){
        $('.reciept-msg').css('display', 'none')
        $('#editreciept-modal').modal('toggle');
    },1000);
    
})
$('.cash').keyup(function(){
    var total = $('.tot_payment').val();
    var change = $(this).val() - total;
        $('.change').val(change.toFixed(2));
})

$('.submittransaction').submit(function(e){
    var conf = confirm('proceed for payment?');
    $(this).attr('target', '_blank')
        if (conf) {
            var total = Number($('.tot_payment').val());
            var cash = Number($('.cash').val());
            if (total > cash) {
                e.preventDefault();
                $('.cash').css('border', '1px solid red').focus();
            }
            else{
                printreciept();
            }
            }else{
                e.preventDefault();
            }
});

function printreciept(){
    setTimeout(function(){
        window.location.reload(true);
        setTimeout(function(){
            window.location.reload(true);
       },100);
   },100);

}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function hidemsg(content){
  setTimeout(function(){
        $(content).hide();
    },10000);
}

