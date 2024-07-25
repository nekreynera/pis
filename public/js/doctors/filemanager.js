$(document).ready(function () {

	$('.filemanager').on('change', function () {
    $('#uploadingLoader').fadeIn('fast');
		var data = new FormData();
        data.append('filemanager', $(this).prop('files')[0]);
        data.append('editCID', $('.editCID').val());

        request = $.ajax({
            url: baseUrl+'/filemanager',
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false, // important
            contentType: false, // important
            dataType : 'json',
            data: data
        });

        request.done(function (response, textStatus, jqXHR) {
			console.log(response);
			var ext = ['doc','docx','txt','xlsx','xls','pdf','ppt','pptx'];
			if(typeof (response.uploadError) != 'undefined' && response.uploadError !== null){
                toastr.error('Error on uploading file!');
            }else{
                toastr.success('Upload Successful.');
                var isInArray = $.inArray(response.extension, ext);
                if (isInArray != -1) {
                	if (response.extension == 'doc' || response.extension == 'docx') {
                		var img = $('<img src="./public/images/mswordlogo.svg" class="img-responsive" data-path="'+response.filepath+'" data-file="docx" data-random="'+response.random+'" onclick="showattachments($(this))" />');
                	}else if(response.extension == 'xlsx' || response.extension == 'xls'){
                		var img = $('<img src="./public/images/excellogo.svg" class="img-responsive" data-path="'+response.filepath+'" data-file="xlsx" data-random="'+response.random+'" onclick="showattachments($(this))" />');
                	}else if(response.extension == 'ppt' || response.extension == 'pptx'){
                		var img = $('<img src="./public/images/powerpointlogo.svg" class="img-responsive" data-path="'+response.filepath+'" data-file="pptx" data-random="'+response.random+'" onclick="showattachments($(this))" />');
                	}else if(response.extension == 'pdf'){
                		var img = $('<img src="./public/images/pdflogo.svg" class="img-responsive" data-path="'+response.filepath+'" data-file="pdf" data-random="'+response.random+'" onclick="showattachments($(this))" />');
                	}else{
                		var img = $('<img src="./public/images/textlogo.svg" class="img-responsive" data-path="'+response.filepath+'" data-file="txt" data-random="'+response.random+'" onclick="showattachments($(this))" />');
                	}
                }else{
                	var img = $('<img src="'+response.filepath+'" class="img-responsive" data-path="'+response.filepath+'" data-file="img" data-random="'+response.random+'" onclick="showattachments($(this))" />')
                }
                var div = $('<div class="'+response.random+'">');
                var imgname = $('<input type="hidden" name="img[]" value="'+response.filename+'" />');
                var input = $('<input type="hidden" name="title[]" class="title '+response.random+'" />');
                var textarea = $('<textarea hidden name="description[]" class="description '+response.random+'" >');
                var code = $('<code hidden fn="'+response.filename+'" ft="'+response.filetype+'" fs="'+response.filesize+'" up="'+response.uploadDate+'" >');
                $('.uploadedFilesWrapper').append($(div).append(img,imgname,input,textarea,code));
                $(img).click();
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });

        request.always(function(){
          $('#uploadingLoader').fadeOut('fast');
        });

    });



	$('.showtitle').on('blur', function () {
		var random = $(this).attr('data-random');
		$("input."+random+"").val($(this).val());
	});

	$('.showdescription').on('blur', function () {
		var random = $(this).attr('data-random');
		$("textarea."+random+"").text($(this).val());
	});


});

function showattachments(scope) {
    var files = ['image/jpeg','image/jpg','image/png','image/bmp','image/pdf','image/gif','image/svg'];
    var filelocation = $(scope).attr('src');
    var title = $(scope).siblings('input.title').val();
    var description = $(scope).siblings('textarea.description').val();
    var filename = $(scope).siblings('code').attr('fn');
    var filetype = $(scope).siblings('code').attr('ft');
    var filesize = $(scope).siblings('code').attr('fs');
    var uploadDate = $(scope).siblings('code').attr('up');
    var random = $(scope).attr('data-random');
    var fileExtension = $(scope).attr('data-file');
    if (fileExtension != 'img') {
    	$('#openAttachment').attr('href',$(scope).attr('data-path'));
    	$('#openAttachment').fadeIn(0);
    }else{
		$('#openAttachment').fadeOut(0);
    }
    $('.deletefile').attr({'href': baseUrl+'/deletefile/'+filename,'data-random':random});
    $('.imagesuploaded').attr('src', filelocation);
    var checkIfImage = $.inArray(filetype.toLowerCase(), files);
    if(checkIfImage != 0){
        $('.imagesuploaded').addClass('fileFormat');
    }else{
        $('.imagesuploaded').removeClass('fileFormat');
    }
    $('.showtitle').val(title);
    $('.showtitle').attr('data-random', random);
    $('.showdescription').val(description);
    $('.showdescription').attr('data-random', random);
    $('.filename').text(filename);
    $('.filetype').text(filetype);
    $('.filesize').text(filesize +' KB');
    $('.uploadedDate').text(uploadDate);
    $('#attachments').modal('show');
};


$(document).ready(function () {
   $('.deletefile').on('click', function (e) {
       e.preventDefault();
       var answer = confirm("Delete this file?");
       if(!answer){
           return false;
       }
       $('#deleteLoader').fadeIn('fast');
       var urls = $(this).attr('href');
       var url = urls+'/'+$('.editCID').val()
       var deleteDiv = $(this).attr('data-random');
       request = $.ajax({
           url: url,
           type: "get",
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           processData: false, // important
           contentType: false, // important
       });
       request.done(function (response, textStatus, jqXHR) {
           $('div.'+deleteDiv).remove();
           $('#attachments').modal('hide');
       });
       request.fail(function (jqXHR, textStatus, errorThrown){
           console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
       });
       request.always(function(){
           $('#deleteLoader').fadeOut('fast');
       });

   });
});













