$(document).ready(function () {

    $('.dailyBtn').on('click', function () {
       $('.monthlyWrapper').fadeOut('fast');
       $('.dailyWrapper').css({'display':'inline'}).fadeIn('fast');
        $('.dailyWrapper .datepicker').attr('required','true');
        $('.monthlyWrapper .datepicker').val('').removeAttr('required');
    });

    $('.monthlyBtn').on('click', function () {
        $('.dailyWrapper').fadeOut('fast');
        $('.monthlyWrapper').css({'display':'inline'}).fadeIn('fast');
        $('.monthlyWrapper .datepicker').attr('required','true');
        $('.dailyWrapper .datepicker').val('').removeAttr('required');
    });

});


$( function() {
    $( ".datepicker" ).datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function (dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
});