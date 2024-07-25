

$(document).ready(function() {
	$(document).on('change', '.abackground:checked' ,function() {
		if($(this).closest('tr').next().find('td').eq(1).find('input').hasClass('datediagnosis'))
		{
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().find('td').eq(1).find('input').prop('disabled', true).val('');
			$(this).closest('tr').next().next().next().next().find('td').eq(1).find('input').prop('disabled', true).val('');
		}
		else
		{
			$(this).closest('tr').prev().find('td').eq(1).find('input').prop('disabled', true).val('');
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', false);
		}
	});

	$(document).on('change', '.typeOfDiabetes:checked', function() {
		if($(this).hasClass('otherstypeOfDiabetes'))
		{
			$(this).next().next().prop('disabled', false);
		}
		else
		{
			$('.otherstypeOfDiabetes').closest('tr').find('td').find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.cMedicalNutritionTherapy', function() {
		if($(this).is(':checked'))
		{
			// $('.TotalCaloricRequirementsInput').prop('disalbed', true);
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().next().next().find('td').eq(1).find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().next().next().find('td').eq(1).find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.cPhysicalActivity', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.coralAntidiabetic', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('tr').next().find('td').eq(0).find('input').prop('disabled', false);
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().find('td').eq(0).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().find('td').eq(0).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().find('td').eq(0).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().find('td').eq(1).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(0).find('input').prop('disabled', false);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(1).find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').next().find('td').eq(0).find('input').prop('disabled', true);
			$(this).closest('tr').next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().find('td').eq(0).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().find('td').eq(0).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().find('td').eq(0).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().find('td').eq(1).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(0).find('input').prop('disabled', true);
			$(this).closest('tr').next().next().next().next().next().find('td').eq(1).find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.cinsulin', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.dhypertension', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', false);
			$(this).closest('tr').next().find('td').find('input').eq(0).prop('disabled', false);
			$(this).closest('tr').next().find('td').find('input').eq(1).prop('disabled', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(0).prop('disabled', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(1).prop('disabled', false);
			$(this).closest('tr').next().next().next().find('td').find('input').eq(0).prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('input').prop('disabled', true);
			$(this).closest('td').next().next().find('input').prop('disabled', true).prop('checked', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', true).val('');
			$(this).closest('tr').next().find('td').find('input').eq(0).prop('disabled', true).prop('checked', false);
			$(this).closest('tr').next().find('td').find('input').eq(1).prop('disabled', true).val('');
			$(this).closest('tr').next().next().find('td').find('input').eq(0).prop('disabled', true).prop('checked', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(1).prop('disabled', true).val('');
			$(this).closest('tr').next().next().next().find('td').find('input').eq(0).prop('disabled', true).val('');
		}
	});

	$(document).on('change', '.ddyslipidemia', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', false);
			$(this).closest('tr').next().find('td').find('input').eq(0).prop('disabled', false);
			$(this).closest('tr').next().find('td').find('input').eq(1).prop('disabled', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(0).prop('disabled', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(1).prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('input').prop('disabled', true);
			$(this).closest('td').next().next().find('input').prop('disabled', true).prop('checked', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', true).val('');
			$(this).closest('tr').next().find('td').find('input').eq(0).prop('disabled', true).prop('checked', false);
			$(this).closest('tr').next().find('td').find('input').eq(1).prop('disabled', true).val('');
			$(this).closest('tr').next().next().find('td').find('input').eq(0).prop('disabled', true).prop('checked', false);
			$(this).closest('tr').next().next().find('td').find('input').eq(1).prop('disabled', true).val('');
		}
	});

	$(document).on('change', '.dotherhypertension', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.eOthers', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.fothers', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.gDiabetes', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('tr').find('td').eq(2).find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').find('td').eq(2).find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.iSmoking', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().next().next().find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().next().find('input').prop('disabled', true);
			$(this).closest('td').next().next().next().find('input').prop('disabled', true).prop('checked', false);
			$(this).closest('td').next().next().next().next().find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.iAlcolholbeverage', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().find('input').prop('disabled', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('input').prop('disabled', true);
			$(this).closest('td').next().next().find('input').prop('disabled', true).prop('checked', false);
			$(this).closest('td').next().next().next().find('input').prop('disabled', true);
		}
	});

	$(document).on('change', '.othermedicalconditions', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('td').next().find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('td').next().find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.j_Other', function() {
		if($(this).is(':checked'))
		{
			$(this).closest('tr').next().find('td').eq(2).find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').next().find('td').eq(2).find('textarea').prop('disabled', true);
		}
	});

	$(document).on('change', '.iv_Others', function() {
		// alert('yes');
		if($(this).is(':checked'))
		{
			$(this).closest('tr').find('td').find('textarea').prop('disabled', false);
		}
		else
		{
			$(this).closest('tr').find('td').find('textarea').prop('disabled', true);
		}
	});

    // $('.group-sub-font').click(function(){
    // 	$('.group-sub-font').each(function(){
    // 		$(this).removeClass('active-category');
    // 	});
    // 	$(this).addClass('active-category');
    // });

	// resizing the diabetes panel
	$('.diabetes-panel-body').css({'height': (($(window).height()) - 120)+'px'});
	$(window).bind('resize', function(){
		$('.diabetes-panel-body').css({'height': (($(window).height()) - 120)+'px'});
    });

    // $('.txtareaAssessment').focus();

    // submit patient diabetes information
    $(document).on('click', '.btnSaveDiabetesInfo', function() {

		showLoader();
		let val, val2;
		$('.diabetes-info input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        val += '&'+this.name+'='+this.value;
		    }
		    return val;
		});

		$('.diabetes-info input[type=number], .diabetes-info input[type=text], .diabetes-info textarea').each(function() {     
		    if (this.disabled) {
		        val2 += '&'+this.name+'='+this.value;
		    }
		    return val2;
		});

		let values = $('.diabetes-info').serialize()+(val+val2).replace(/undefined/gi,'').replace(/&nbsp;/gi,' ');

		console.log('values 1: ', values);

    	let ajax = $.ajax({
    		url: baseUrl+'/savediabetesinfo',
    		type: 'POST',
    		data: values,
    		cache: false,
    		dataType: 'JSON',
    		success: function(data) {
    			console.table('Success response: ', data);
    			$('.hidden-did').val(data);
    			savediabetesinfo(data);
    			$('.diabetes-info').prepend('<input type="hidden" class="hidden-did" name="id" value="'+data+'">');
    		},
    		error: function(data) {
    			console.table('Failure response: ', data);
    		}
    	});

    });

    let follow_up_id = '';

	function savediabetesinfo(did) {

		let val;
		$('.follow-up input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        val += '&'+this.name+'='+this.value;
		    }
		    return val;
		});
		let values = ($('.follow-up').serialize()+'&'+'txtareaAssessment'+'='+tinymce_instance.activeEditor.getContent()+(val)).replace(/undefined/gi,'').replace(/&nbsp;/gi,'```');

		console.log('values 2: ', values);

	    let ajax2 = $.ajax({
	    	url: baseUrl+'/savediabetesfollowupinfo',
	    	type: 'POST',
	    	data: values,
	    	cache: false,
	    	dataType: 'JSON',
	    	success: function(data) {
	    		console.table('Success response @ ', data);
	    		follow_up_id = data;
    			$('.btnStatus').removeClass('btnSaveDiabetesInfo btnSaveDiabetesInfo2').addClass('btnUpdateDiabetesInfo');
    			$('.follow-up').prepend('<input type="hidden" class="follow_up_id" name="id" value="'+data+'">');
    			savediabeteslaboratory();
	    	},
	    	error: function(data) {
	    		console.table('Failure response @ ', data);
				hideLoader();
	    	}
	    });

	}

	function savediabeteslaboratory() {

		let values = $('.laboratory-result').serialize();

		let ajax = $.ajax({
			url: baseUrl+"/savediabeteslaboratory",
			type: "POST",
			data: values,
			cache: false,
			dataType: "JSON",
			success: function(data) {
				console.log('Success response: ', data);

    			saveicd(follow_up_id);
				hideLoader();
    			toastr.success("Patient's information and consultation has been successfully saved!");
			},
			error: function(data) {
				console.log('Failure response: ', data);
				hideLoader();
			}
		})
	}

    function saveicd(did)
    {
    	let boolean = $(this).is(':checked'), pid = $('.patient_id').val(), icd = [];
    	$('.remove-icd').each(function() {
    		icd.push($(this).attr('remove-icd'));
    	});

    	$.ajax({
    		url: baseUrl+"/saveicd",
    		type: "POST",
    		data: {
    			icd:icd,did:did,pid:pid
    		},
    		cache: false,
    		dataType: "JSOn",
    		success: function(data) {
    			console.log('Success response saved id: ', data);
				hideLoader();
    		},
    		error: function(data) {
    			console.log('Failure response: ', data);
				hideLoader();
    		}
    	})
    }

	$(document).on('change', 'input[type=checkbox]', function() {
		$(this).is(':checked') ? $(this).val('yes') : $(this).val('no');
	});

	$(document).on('click', '.btnUpdateDiabetesInfo', function() {

		showLoader();
		let val, val2;
		$('.diabetes-info input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        val += '&'+this.name+'='+this.value;
		    }
		    return val;
		});

		$('.diabetes-info input[type=number], .diabetes-info input[type=text], .diabetes-info textarea').each(function() {     
		    if (this.disabled) {
		        val2 += '&'+this.name+'='+this.value;
		    }
		    return val2;
		});

		let values = $('.diabetes-info').serialize()+(val+val2).replace(/undefined/gi,'').replace(/&nbsp;/gi,'```');

		console.log(values);

		let ajax = $.ajax({
			url: baseUrl+'/updatediabetesinfo',
			type: 'POST',
			data: values,
			cache: false,
			dataType: 'JSON',
			success: function(data) {
				// console.log('Success response: ', data);
				updatediabetes(data);
			},
			error: function(data) {
				// console.log('Failure response: ', data);
				hideLoader();
			}
		});

	});

	function updatediabetes(did) {

		let val;
		$('.follow-up input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        val += '&'+this.name+'='+this.value;
		    }
		    return val;
		});

		let values = ($('.follow-up').serialize()+'&'+'txtareaAssessment'+'='+tinymce_instance.activeEditor.getContent()+(val)).replace(/undefined/gi,'').replace(/txtareaAssessment=&/gi,'').replace(/&nbsp;/gi,'```');

		let ajax = $.ajax({
			url: baseUrl+"/updatediabetesfollowup",
			type: "POST",
			data: values,
			cache: false,
			dataType: "JSON",
			success: function(data) {
				// console.log('Success response: ', data);
				updatelaboratory();
			},
			error: function(data) {
				console.log('Failure response: ', data);
				hideLoader();
			}
		})
	}

	function updatelaboratory() {

		let values = $('.laboratory-result').serialize();

		console.table(values);

		let ajax = $.ajax({
			url: baseUrl+"/updatediabeteslaboratory",
			type: "POST",
			data: values,
			cache: false,
			dataType: "JSON",
			success: function(data) {
				// console.log('Success response: ', data);
				saveicd($('.follow_up_id').val());
				hideLoader();
    			toastr.success("Patient's information has been successfully saved!");
			},
			error: function(data) {
				console.log('Failure response: ', data);
				hideLoader();
			}
		})
	}

    $(document).on('click', '.btnSaveDiabetesInfo2', function() {

		showLoader();
		let val, val2;
		$('.diabetes-info input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        val += '&'+this.name+'='+this.value;
		    }
		    return val;
		});

		$('.diabetes-info input[type=number], .diabetes-info input[type=text], .diabetes-info textarea').each(function() {     
		    if (this.disabled) {
		        val2 += '&'+this.name+'='+this.value;
		    }
		    return val2;
		});

		let values = $('.diabetes-info').serialize()+(val+val2).replace(/undefined/gi,'').replace(/&nbsp;/gi,'```');

		console.log('values: ', values);

		let ajax = $.ajax({
			url: baseUrl+'/updatediabetesinfo',
			type: 'POST',
			data: values,
			cache: false,
			dataType: 'JSON',
			success: function(data) {
				// console.log('Success response @ ', data);
				savediabetesinfo($('.hidden-did').val());
			},
			error: function(data) {
				// console.log('Failure response @ ', data);
				hideLoader();
			}
		});

    });

	$('.date_picker').datepicker();

	function showLoader()
	{
	    $('.pageloaderWrapper').show();
	    $('.pageloaderWrapper').css({"left":"45%","top":"34%"});
		$('.loaderBackgroundColor').show();
	}

	function hideLoader()
	{
	    $('.pageloaderWrapper').hide();
		$('.loaderBackgroundColor').hide();
	}

	$('.time_taken').wickedpicker();

    $( "#accordion" ).accordion({
        heightStyle: "content"
    });

    let icd_array = [];

    $('.remove-icd').each(function() {
	    icd_array.push($(this).attr('remove-icd'));
    });

    $('.btn-icd-codes').click(function() {

    	let pid = $('.patient_id').val();

    	$('.icd_codes').each(function() {
    		(icd_array.includes($(this).attr('id').toString()) ? $(this).prop('checked', true) : '');
    	});
    });

    var emailHeaderConfig = {
        selector: '.txtareaAssessment',
        content_css : "../public/css/diabetes/diabetes.css",
        menubar: false,
        statusbar: false,
        plugins : "pagebreak,textcolor,paste,nonbreaking,code",
        // toolbar : "undo redo | fontsizeselect | bold italic underline | fontsizeselect",
        toolbar : "false",
        fontsize_formats : "6pt 7pt 8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
        branding: false,
		setup: function (editor) {
		    editor.on('init', function () {
		        // editor.focus();
		        editor.selection.select(editor.getBody(), true);
		        editor.selection.collapse(false);
		    });
		}
    };

    let tinymce_instance = tinyMCE;
    tinymce_instance.init(emailHeaderConfig);

    $(document).on('change', '.icd_codes', function() {

    	let id = $(this).attr('icd-id');
    	if($(this).is(':checked'))
    	{
		    tinymce_instance.activeEditor.execCommand('mceInsertContent', false, '<strong class="icd_code" contenteditable="false"\
		     id="'+$(this).attr('icd-id')+'">('+$(this).closest('tr').find('td').eq(1).text()+') '+$(this).closest('tr').find('td').eq(2).text()+'</strong>&nbsp;');

		    icd_array.push($(this).attr('icd-id'));

		    let tag = '<div class="row">\
	                      <div class="col-sm-12">\
	                        <div class="input-group">\
	                          <input type="text" class="form-control"\
	                           value="('+$(this).closest('tr').find('td').eq(1).text()+') '+$(this).closest('tr').find('td').eq(2).text()+'" readonly>\
	                          <span class="input-group-btn">\
	                            <button class="btn btn-danger remove-icd" type="button" id="id'+$(this).attr('icd-id')+'"\
	                             remove-icd="'+$(this).attr('icd-id')+'"><span class="fa fa-trash"></span></button>\
	                          </span>\
	                        </div>\
	                      </div>\
	                    </div>';
		    $('.icd-input-list').prepend(tag);

		    console.log(icd_array);
    	}
    	else
    	{
	    	if(confirm('Are you sure you want to remove this ICD?') == true)
	    	{
		    	// remove icd code
		        $('#id'+id).closest('div.row').remove();
		        tinymce_instance.activeEditor.dom.remove(tinymce_instance.activeEditor.dom.select('#'+id));

		        let index = icd_array.indexOf(id);
		        (index > -1 ? icd_array.splice(index, 1) : '');
			    console.log(icd_array);
			}
    	}

    });

    $(document).on('click', '.remove-icd', function() {

    	let id = $(this).attr('remove-icd');
    	if(confirm('Are you sure you want to remove this ICD?') == true)
    	{
	    	// remove icd code
	        $(this).closest('div.row').remove();
	        tinymce_instance.activeEditor.dom.remove(tinymce_instance.activeEditor.dom.select('#'+id));

	        let index = icd_array.indexOf(id);
	        (index > -1 ? icd_array.splice(index, 1) : '');
		    $('#'+id).prop('checked', false);
		    console.log(icd_array);
    	}

    });

    var emailHeaderConfig2 = {
        selector: '.txtareaAssessment2',
        content_css : "../public/css/diabetes/diabetes.css",
        menubar: false,
        statusbar: false,
        plugins : "pagebreak,textcolor,paste,nonbreaking,code",
        // toolbar : "undo redo | fontsizeselect | bold italic underline | fontsizeselect",
        toolbar : "false",
        fontsize_formats : "6pt 7pt 8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
        readonly : 1,
        branding: false
    };

    tinyMCE.init(emailHeaderConfig2);

    $(document).on('keyup', '.search_icd', function(e) {
    	if(e.which == 13) {
	    	console.log($(this).val());
	    	let pid = $('.patient_id').val();

	    	$.ajax({
	    		url: baseUrl+"/getsearchedicd",
	    		type: "POST",
	    		data: {
	    			string:$(this).val()
	    		},
	    		cache: false,
	    		dataType: "JSON",
	    		success: function(data) {
	    			console.log('Success response: ', data);
	    			icds = '';
	    			data.forEach(function(icd) {
	    				icds += "<tr class='icds'>\
				    				<td><input type='checkbox' class='icd_codes' id='"+icd.id+"' patient-id='"+pid+"' \
				    				icd-id='"+icd.id+"'"+(icd_array.includes(icd.id.toString()) ? 'checked' : '')+"></td>\
				    				<td>"+icd.code+"</td>\
				    				<td>"+icd.description+"</td>\
			    				</tr>";
	    			});
	    			$('.icds').remove();
	    			$('.table-icd').append(icds);
	    		},
	    		error: function(data) {
	    			console.log('Failure response: ', data);
	    		}
	    	})
    	}
    });

    if($('.checkhasrecord').val() != '')
    {
	    let table = $('.laboratory-result .main-table').width(), div = $('.table-scroll').width(), input = $('.input-width').width();
	    $('.table-scroll').scrollLeft((table-div)-input);
    }

});