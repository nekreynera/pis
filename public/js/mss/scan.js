$('.inputbarcode').focus(function(){
  $('.spanbarcode').css('border', '1px solid #00b300');
  $('.spanbarcode').css('border-left', 'none');
  $('.spanbarcode').css('box-shadow', '1px -1px 5px #b3ffb3, -1px 1px 8px #b3ffb3');
})
$('.inputbarcode').blur(function(){
  $('.spanbarcode').css('border', '1px solid rgb(204, 204, 204)');
  $('.spanbarcode').css('border-left', 'none');
  $('.spanbarcode').css('box-shadow', 'none');
})
