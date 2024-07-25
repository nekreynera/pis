  $(document).ready(function () {
      $("#philhealth").change(function () {
          var val = $(this).val();
              $("#phil_member").html("<option value='OWWA'>OWWA</option><option value='IPP'>IPP</option><option value='NPP'>NPP</option><option value='GOVT'>GOVT</option><option value='EMPLOYED'>EMPLOYED</option><option value='PRIVATE'>PRIVATE</option><option value='4Ps'>4Ps</option><option value='NHTS'>NHTS</option><option value='POS'>POS</option><option value='POC'>POC</option></option><option value='OTHERS'>OTHERS</option>");
      });
  });
  $(document).ready(function () {
      $("#phil_member").change(function () {
          var val = $(this).val();
              if (val == "OTHERS") {
              $('#philinputToOthers').css("display", "block");
              $("#inputToOthers").css("display", "none");
              $('#sectinputToOthers').css("display", "none");
              $('#inputmodal').modal("toggle");
                  $("#philinputToOthers").keyup(function(){
                      var others = $(this).val();
                      $('#phil_member').html("<option value='OTHERS: " +others+"'>OTHERS: "+others+"</option><option value='OWWA'>OWWA</option><option value='IPP'>IPP</option><option value='NPP'>NPP</option><option value='GOVT'>GOVT</option><option value='EMPLOYED'>EMPLOYED</option><option value='PRIVATE'>PRIVATE</option><option value='4Ps'>4Ps</option><option value='NHTS'>NHTS</option><option value='POS'>POS</option><option value='OTHERS'>OTHERS</option>");
                  });
              }
      });
  });
  $(document).ready(function(){
      $("#civil_status").change(function () {
          var cs = $(this).val();
          if (cs == "Sep") {
               $("#civil_modal").modal("toggle");
          }
      });
  });
  $(document).ready(function(){
      $("input[type='radio']#civilchoose").click(function () {
          var csr = $(this).val();
          //alert($(this).val());
          $('#civil_status').html("<option value='Sep-"+csr+"'>Separated - "+csr+"</option><option value='Common-law'>Common law</option><option value='Maried'>Maried</option><option value='sep'>Separated</option><option value='Single'>Single</option><option value='Widow'>Widow</option><option value='Devorce'>Devorce</option>");
      })
  });
  $(document).ready(function(){
      $("#referral").change(function () {
          var ref = $(this).val();
          if (ref == "others") {
              $("#inputToOthers").css("display", "block");
              $('#philinputToOthers').css("display", "none");
              $('#sectinputToOthers').css("display", "none");
              $('#inputmodal').modal("toggle");
              $("#inputToOthers").keyup(function(){
                  var otherso = $(this).val();
                  $('#referral').html("<option value='OTHERS-"+otherso+"'>OTHERS: "+otherso+"</option><option value='GH'>GH</option><option value='PH/PC'>PH/PC</option><option value='POLITICIAN'>POLITICIAN</option><option value='MEDIA'>MEDIA</option><option value='HCT/RHU/TACRU'>HCT/RHU/TACRU</option><option value='NGO/PRIVATE WELFARE AGENCIES'>NGO/PRIVATE WELFARE AGENCIES</option><option value='GOVT AGENCIES'>GOV'T AGENCIES</option><option value='WALK-IN'>WALK-IN</option><option value='others'>OTHERS:</option>");
              });
          }
      });
  });

  $(document).ready(function(){
      $("#referral").change(function () {
          var ref = $(this).val();
          if (ref != "") {
              $("#referral").css("color", "black");
          }
      });
  });
  $(document).ready(function(){
      $("#patient_type").change(function () {
          var ref = $(this).val();
          if (ref != "") {
              $("#patient_type").css("color", "#212121");
          }
      });
  });
  $(document).ready(function(){
      $("#sect_membership").change(function () {
          var ref = $(this).val();
          if (ref != "") {
              $("#sect_membership").css("color", "#212121");
          }
      });
  });
  $(document).ready(function(){
      $("#4ps").change(function () {
          var ref = $(this).val();
          if (ref != "") {
              $("#4ps").css("color", "#212121");
          }
      });
  });
  $(document).ready(function(){
      $("#classification").change(function () {
          var ref = $(this).val();
          if (ref != "") {
              $("#classification").css("color", "#212121");
          }
      });
  });
  $(document).ready(function(){
      $("#sect_membership").change(function () {
          var ref = $(this).val();
          if (ref == "OTHERS") {
              $('#sectinputToOthers').css("display", "block");
              $("#inputToOthers").css("display", "none");
              $('#philinputToOthers').css("display", "none");
              $('#inputmodal').modal("toggle");
              $("#sectinputToOthers").keyup(function(){
                  var otherso = $(this).val();
                  $('#sect_membership').html("<option value='OTHERS-"+otherso+"'>OTHERS: "+otherso+"</option><option value='SC'>SC</option><option value='BRGY'>BRGY. OFFICIAL</option><option value='PWD'>PWD</option><option value='BHW'>BHW</option><option value='INDIGENOUS PEOPLE'>INDIGENOUS PEOPLE</option><option value='VETERANS'>VETERANS</option><option value='VAWC/IN INSTITUTION'>VAWC/IN INSTITUTION</option><option value='ELDERLY'>ELDERLY</option><option value='OTHERS'>OTHERS:</option>");
              });
          }
      });
  });
  $(document).ready(function(){
      $(".choosdateok").click(function(){
          $('.submitclassificationloader').css("display", "block");
          var date =$("#choose_date").val();
         $.post(URL+"model/get_classifiedpatient.php", {
              date: date
          },
              function (data, status){
                  $('.data-table').append(data);
                  $('.patienttoday').css('display', 'none');
              }
          );
          setTimeout( function () {
             $('.submitclassificationloader').css("display", "none");
          }, 500);
      });
  });
  $(window).on('load',function(){
      $('#choosedatemodal').modal('show');
  });
  $(function() {
      $( "#date_of_adm" ).datepicker(
        {
          dateFormat: 'yy-mm-dd',
          maxDate:0,
          changeMonth: true,
          changeYear: true,

        }
      );
  });

  $(document).ready(function(){
      $("#philhealth").change(function(){
          if ($(this).val.length !=0)
          $("#phil_member").focus();
      })
  })
  $(document).ready(function(){
      $("#house_lot").change(function(){
          if ($(this).val.length !=0)
          $("#H_php").focus().val("00.00");
      })
  })
      
  $(document).ready(function(){
      $("#light_source").change(function(){
          if ($(this).val.length !=0)
          $("#L_php").focus().val(" 00.00");
      })
  })
  $(document).ready(function(){
      $("#water_source").change(function(){
          if ($(this).val.length !=0)
          $("#W_php").focus().val(" 00.00");
      })
  })
  $(document).ready(function(){
      $("#fuel_source").change(function(){
          if ($(this).val.length !=0)
          $("#F_php").focus().val(" 00.00");
      })
  })
  $(document).ready(function(){
      $("#barcode").keyup(function(){
          if ($(this).val().length >= 4) {
              $("#addonbarcode").fadeOut("slow");
          }
          else{
              $("#addonbarcode").fadeIn("slow");
          }
      });
  });


  /*=================classified patient============================*/
  $(document).ready(function(){
      $(".choosdateok").click(function(){
          $('.submitclassificationloader').css("display", "block");
          var date =$("#choose_date").val();
         $.post(URL+"model/get_classifiedpatient.php", {
              date: date
          },
              function (data, status){
                      $('.data-table').append(data);
                      $('.patienttoday').css('display', 'none');
              }
          );
          setTimeout( function () {
             $('.submitclassificationloader').css("display", "none");
          }, 500);
      });
  });
  /*========================================================================*/


      /*/************* START OF FOR YEAER SCRIPT *****************/

      $('#birthplace').on('shown.bs.modal', function () {
        $('#myInput').focus()
      })

  $(document).ready(function(){
      $(".mssformsubmit").submit(function () {
          $('button#submit_classification').hide();
          $('.submitclassificationloader').css("display", "block");
         /* setTimeout( function () { 
              ikaw = return false;
          }, 3000);*/
      });
  });
