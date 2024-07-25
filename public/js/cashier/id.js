function names() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("names");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
// function hospital() {
//   // Declare variables
//   var input, filter, table, tr, td, i;
//   input = document.getElementById("hospital");
//   filter = input.value.toUpperCase();
//   table = document.getElementById("myTable");
//   tr = table.getElementsByTagName("tr");

//   // Loop through all table rows, and hide those who don't match the search query
//   for (i = 0; i < tr.length; i++) {
//     td = tr[i].getElementsByTagName("td")[1];
//     if (td) {
//       if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
//         tr[i].style.display = "";
//       } else {
//         tr[i].style.display = "none";
//       }
//     }
//   }
// }
function namess() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("namess");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTables");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function hospitals() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("hospitals");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTables");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
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
}

$(document).on('change', '.check-patient', function(){
    var parentTr = $(this).closest('tr');
    parentTr.siblings().css('background-color', 'initial');
    parentTr.css('background-color', '#a5d6a7');
    $('.hidden_id').val($(this).val());
});
$(document).on('click', 'tr', function(){
  $(this).find('.check-patient').prop('checked', true);
  $(this).siblings().css('background-color', 'initial');
  $(this).css('background-color', '#a5d6a7');
  $('.hidden_id').val($(this).find('.check-patient').val());
})


$('.choosemonth').click(function(){
    var date = $(this).attr('id');
    
    $('.submitclassificationloader').css('display', 'block');
            $.post(baseUrl+"/getpatientbymonth", {
                date: date,
              },
                function (data, status){
                  $('.tablebody').empty();
                  var request = JSON.parse(data);
                 
                  for (var i = 0; i < request.length; i++) {
                    var tr = $('<tr style="color: rgb(56, 109, 59);cursor: pointer;">');
                    var td1 = $('<td style="width: 45px"><input type="radio" name="names" id="not" class="check-patient" value="'+request[i].id+'" style="height:12px">');
                    var td2 = $('<td style="width: 142px">').text(request[i].hospital_no);
                    var td3 = $('<td style="width: 285px">').text(request[i].name);
                    var td4 = $('<td>').text(request[i].age);
                    var tr2 = $('<tr/>');
                    $(tr).append(td1, td2, td3, td4, tr2);
                    $('.tablebody').append(tr);
                  }
                  setTimeout( function () {
                      $('.submitclassificationloader').css("display", "none");
                  }, 1000);

                }
            );

})
$('.selectpatient').click(function(){
  var id = $('.hidden_id').val();
  if (id) {
    $.post(baseUrl+"/getpatientbyid", {
        id: id,
      },
        function (data, status){
          $('.itemsbody').empty();
          $('.transaction-content').empty();
          var request = JSON.parse(data);
            if (request.reciept) {
            $('.patient_name').val(request.patient.last_name+', '+request.patient.first_name+' '+request.patient.middle_name);
            $('.patient_classification').val('N/A');
            $('.patient_sex').val(request.patient.sex);
            $('.hospital_number').val(request.patient.hospital_no);
            $('.invoicno').val(request.reciept.reciept_no);
            var tr = $('<tr>');
            var td1 = $('<td>').text('HOSPITAL ID');
            var td2 = $('<td align="right" width="100px">').text('75.00');
            var td3 = $('<td align="center" width="50px">').text('1');
            var td4 = $('<td align="right" width="100px">').text('75.00');
            var td5 = $('<td align="right" width="100px">').text('0.00');
            var td6 = $('<td align="right" width="100px">').text('75.00');
            var tr = $('<tr/>');
            $(tr).append(td1, td2, td3, td4, td5, td6);
            $('.itemsbody').append(tr);
            $('.tot_amount').val('75.00');
            $('.tot_discount').val('0.00');
            $('.tot_payment').val('75.00');
            $('.change').val('75.00');

            var idinput = $('<input type="hidden" name="patient_id"  value='+id+'>');
            var input1 = $('<input type="hidden" name="category_id"  value="1">');
            var price = $('<input type="hidden" name="price"  value="75.00">');
            $('.transaction-content').append(idinput, input1, price);
            $('#searchpatient-modal').modal("hide");  
            $('#reprint-modal').modal('hide'); 
            }
            else{
              $('.reciept-msg').text('kindly set your INCOME O.R number first').css('display', 'block')
              $('#editreciept-modal').modal('show');
            }
        }
    );
    
  }
  else{
    alert("please select patient first");
  }
  
})
$('.selectpatientreprint').click(function(){
  var id = $('.hidden_id').val();
  if (id) {
    $.post(baseUrl+"/getpatientbyid", {
        id: id,
      },
        function (data, status){
          $('.itemsbody').empty();
          $('.transaction-content').empty();
          var request = JSON.parse(data);
            if (request.reciept) {
            $('.patient_name').val(request.patient.last_name+', '+request.patient.first_name+' '+request.patient.middle_name);
            $('.patient_classification').val('N/A');
            $('.patient_sex').val(request.patient.sex);
            $('.hospital_number').val(request.patient.hospital_no);
            $('.invoicno').val(request.reciept.requistion_type+'-'+request.reciept.reciept_no);
            var tr = $('<tr>');
            var td1 = $('<td>').text('REPRINT HOSPITAL ID');
            var td2 = $('<td align="right" width="100px">').text('150.00');
            var td3 = $('<td align="center" width="50px">').text('1');
            var td4 = $('<td align="right" width="100px">').text('150.00');
            var td5 = $('<td align="right" width="100px">').text('0.00');
            var td6 = $('<td align="right" width="100px">').text('150.00');
            var tr = $('<tr/>');
            $(tr).append(td1, td2, td3, td4, td5, td6);
            $('.itemsbody').append(tr);
            $('.tot_amount').val('150.00');
            $('.tot_discount').val('0.00');
            $('.tot_payment').val('150.00');
            $('.change').val('150.00');

            var idinput = $('<input type="hidden" name="patient_id"  value='+id+'>');
            var input1 = $('<input type="hidden" name="category_id"  value="1">');
            var price = $('<input type="hidden" name="price"  value="150.00">');
            $('.transaction-content').append(idinput, input1, price);
            $('#searchpatient-modal').modal("hide");  
            $('#reprint-modal').modal('hide'); 
            }
            else{
              $('.reciept-msg').text('kindly set your INCOME O.R number first').css('display', 'block')
              $('#editreciept-modal').modal('show');
            }
        }
    );
    
  }
  else{
    alert("please select patient first");
  }
  
})

$('#reprint-modal').on('shown.bs.modal', function(){
    $.post(baseUrl+"/reprintbymonth", {
      },
        function (data, status){
          $('.tablebodys').empty();
          $('.reprintmonths').empty();
          var request = JSON.parse(data);
          for (i = 0; i < request.length; i++) {
            var li = '<li><a href="#" class="reprintchoosemonth" id='+request[i].months+'>'+$.date(request[i].months)+'</a></li>';
            $('.reprintmonths').append(li);
              
          }
         
        }
    );
})

$(document).on('click','.reprintchoosemonth', function(){
    var date = $(this).attr('id');
    
    $('.submitclassificationloader').css('display', 'block');
            $.post(baseUrl+"/reprintgetpatientbymonth", {
                date: date,
              },
                function (data, status){
                  $('.tablebodys').empty();
                  var request = JSON.parse(data);
                 
                  for (var i = 0; i < request.length; i++) {
                    var tr = $('<tr style="color: rgb(56, 109, 59);cursor: pointer;">');
                    var td1 = $('<td style="width: 45px"><input type="radio" name="names" id="not" class="check-patient" value="'+request[i].id+'" style="height:12px">');
                    var td2 = $('<td style="width: 142px">').text(request[i].hospital_no);
                    var td3 = '<td style="width: 285px">'+request[i].name+'<b class="pull-right bg-info">printed - '+request[i].printed+'</b></td>';
                    var td4 = $('<td>').text(request[i].age);
                    var tr2 = $('<tr/>');
                    $(tr).append(td1, td2, td3, td4, tr2);
                    $('.tablebodys').append(tr);
                  }
                  setTimeout( function () {
                      $('.submitclassificationloader').css("display", "none");
                  }, 1000);

                }
            );

})
$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    var monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
      "July", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];   
    var date =  monthNames[month] + "-" + year;

    return date;
};
function searchpatient(scope){
  event.preventDefault();
  var hospital_no = $('#hospital').val();
  var name = $('#names').val();
  $.post(baseUrl+"/searchpatient", {
      hospital_no: hospital_no,
      name: name
    },
      function (data, status){
        $('.tablebody').empty();
        var request = JSON.parse(data);
        console.log(request);
        for (var i = 0; i < request.length; i++) {
          var tr = $('<tr style="color: rgb(56, 109, 59);cursor: pointer;">');
          var td1 = $('<td style="width: 45px"><input type="radio" name="names" id="not" class="check-patient" value="'+request[i].id+'" style="height:12px">');
          var td2 = $('<td style="width: 142px">').text(request[i].hospital_no);
          var td3 = $('<td style="width: 285px">').text(request[i].name);
          var td4 = $('<td>').text(request[i].age);
          var tr2 = $('<tr/>');
          $(tr).append(td1, td2, td3, td4, tr2);
          $('.tablebody').append(tr);
        }

      }
  );

}
function searchreprintid(scope){
  event.preventDefault();
  var hospital_no = $('#hospitals').val();
  $.post(baseUrl+"/searchreprintid", {
    hospital_no: hospital_no,
  },
    function (data, status){
      $('.tablebodys').empty();
      var request = JSON.parse(data);
      console.log(request);
      for (var i = 0; i < request.length; i++) {
        var tr = $('<tr style="color: rgb(56, 109, 59);cursor: pointer;">');
        var td1 = $('<td style="width: 45px"><input type="radio" name="names" id="not" class="check-patient" value="'+request[i].id+'" style="height:12px">');
        var td2 = $('<td style="width: 142px">').text(request[i].hospital_no);
        var td3 = $('<td style="width: 285px">').text(request[i].name);
        var td4 = $('<td>').text(request[i].age);
        var tr2 = $('<tr/>');
        $(tr).append(td1, td2, td3, td4, tr2);
        $('.tablebodys').append(tr);
      }

    }
);

}
