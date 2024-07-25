
$(document).ready(function(){
    
	let months = ['January','February','March','April','May','June','July','August','September','October','Novermber','December'];
    $(document).on('click', '.btn-patient-info-modal', function(e){
        e.preventDefault();
        id = $(this).attr('name');
        // console.log(id);
        openLoader();
        $("#patientinfo-modal").modal('toggle');
        $('.refferal-info').hide();
        $('.pending-info').hide();
        $('.d-text').text('');
        $('.dateexamined').html('');
        vitalSignAjax(id);

        function number_format(number, decimals, dec_point, thousands_point) {

		    if (number == null || !isFinite(number)) {
		        throw new TypeError("number is not valid");
		    }

		    if (!decimals) {
		        var len = number.toString().split('.').length;
		        decimals = len > 1 ? len : 0;
		    }

		    if (!dec_point) {
		        dec_point = '.';
		    }

		    if (!thousands_point) {
		        thousands_point = ',';
		    }

		    number = parseFloat(number).toFixed(decimals);

		    number = number.replace(".", dec_point);

		    var splitNum = number.split(dec_point);
		    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
		    number = splitNum.join(dec_point);

		    return number;
		}

    });

    function vitalSignAjax(id)
    {
        $.ajax({
        	url: baseUrl+"/patient_info",
        	type: 'POST',
        	data: {
        		id:id
        	},
        	cache: false,
        	dataType: "JSON",
        	success: function(data) {
	            console.log('Success response :', data);

	            // Patient Information
	            $('.hospitalno').text(data[0].hospital_no ? data[0].hospital_no : '');
	            $('.barcode').text(data[0].barcode ? data[0].barcode : '');
	            $('.name').text(data[0].last_name+', '+data[0].first_name+' '+data[0].middle_name);
				date = new Date(data[0].birthday);
				day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
				// month = (date.getMonth() + 1) > 9 ? (date.getMonth() + 1) : '0'+(date.getMonth() + 1);
	            $('.birhtday').text(months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear());
	            $('.age').text(getpatientAge(data[0].birthday));

	            $('.address').text(data[0].address ? data[0].address : '');
	            let sex = '';
	            switch(data[0].sex) {
				  case 'F':
				    sex = 'Female';
				    break;
				  case 'M':
				    sex = 'Male';
				    break;
				}
	            $('.sex').text(sex);
	            $('.civilstat').text(data[0].civil_status ? data[0].civil_status : '');

	            $('.mssclass').text(data[0].label ? data[0].label+' '+(data[0].discount) * 100+'%' : 'Unclassified');
				date = new Date(data[0].created_at);
				day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
				let superscript = day > 3 ? 'th' : day > 2 ? 'rd' : day > 1 ? 'nd' : 'st';
	            $('.datereg').text(day + superscript + ' of ' + months[date.getMonth()] + ', ' +  date.getFullYear());

	            // console.log('blood pressure', data[1][0].blood_pressure);

	            // Vital Signs
	            try 
	            {
		            $('.bloodpressure').text(data[1][0].blood_pressure ? data[1][0].blood_pressure : '');
		            $('.pulserate').text(data[1][0].pulse_rate ? data[1][0].pulse_rate : '');
		            $('.resprate').text(data[1][0].respiration_rate ? data[1][0].respiration_rate : '');
		            $('.btemp').text(data[1][0].body_temperature ? data[1][0].body_temperature : '');
		            $('.weight').text(data[1][0].weight ? data[1][0].weight : '');
		            $('.height').text(data[1][0].height ? data[1][0].height : '');
		            let bmi = '';
	                if(data[1][0].vital_signs > 0)
	                {
	                    if(data[1][0].weight && data[1][0].height)
	                    {
	                        let w = data[1][0].weight;
	                        let h = data[1][0].height / 100;
	                        let th = h * h;
	                        bmi = w / th;
	                        bmi = number_format(bmi, 3, '.', '');
	                    }
	                }
		            $('.bmi').text(bmi);

		            let thTaG = '';
	                if(data[1][0].created_at)
	                {
						created_at = new Date(data[1][0].created_at);
					    let hours = created_at.getHours();
					    let minutes = created_at.getMinutes();
						let ampm = hours >= 12 ? 'pm' : 'am';

						// Hours
						hours = hours % 12;
						hours = hours ? hours : 12;
						hours = hours < 10 ? '0'+hours : hours;
						minutes = minutes < 10 ? '0'+minutes : minutes;

						// Date
						day = created_at.getDate() > 9 ? created_at.getDate() : '0'+created_at.getDate();
						month = (created_at.getMonth() + 1) > 9 ? (created_at.getMonth() + 1) : '0'+(created_at.getMonth() + 1);

	                    thTaG = '<th class="text-right" colspan="2">\
	                                Date examined : '+created_at.getFullYear() + '-' + month + '-' + day +' '+hours+':'+minutes+':'+created_at.getSeconds()+'\
	                            </th>';
	                }
	                else
	                {
	                    // thTaG = '<th class="text-right" colspan="2">\
	                    //             <span class="text-danger">Todays Vital Signs is Unavailable!</span>\
	                    //             <br>\
	                    //             Click this to insert vital signs\
	                    //             <a href="'+baseUrl+"/vitalSigns/"+data[0].id+'" class="btn btn-danger btn-circle">\
	                    //                 <i class="fa fa-heartbeat"></i>\
	                    //             </a>\
	                    //         </th>';
	                    thTaG = '<th class="text-right" colspan="2">\
	                                <span class="text-danger">Todays Vital Signs is Unavailable!</span>\
	                                <br>\
	                                Click this to insert vital signs\
	                                <a href="/?#" class="btn btn-danger btn-circle btn-vital-sign-modal" rel="'+id+'">\
	                                    <i class="fa fa-heartbeat"></i>\
	                                </a>\
	                            </th>';
	            	}
		            $('.dateexamined').html(thTaG);

		            // Referral
		            let trTaGR = '';
		            try
		            {
			            if(data[2].length > 0)
			            {
			            	$('.refferal-info').show();

				            let trTaGR = '', fromClinic = '', fromDoctor = '', toClinic = '', toDoctor = '', reason = '', status = '', date = '', day = '';
		            		for(i=0;data[2].length>i;i++)
		            		{
		            			fromClinic = data[2][i].fromClinic ? data[2][i].fromClinic : 'N/A';
		            			fromDoctor = data[2][i].fromDoctor ? 'Dr. '+data[2][i].fromDoctor : 'N/A';
		            			toClinic = data[2][i].toClinic ? data[2][i].toClinic : 'N/A';
		            			toDoctor = data[2][i].toDoctor ? data[2][i].toDoctor : 'Unassigned';
		            			reason = data[2][i].reason ? data[2][i].reason : 'N/A';
		            			status = data[2][i].status ? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>';
								date = new Date(data[2][i].created_at);
								day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
			            		trTaGR += '<tr>\
				            					<td>'+data[2][i].name+'</td>\
				            					<td>'+fromClinic+'</td>\
				            					<td>'+fromDoctor+'</td>\
				            					<td>'+toClinic+'</td>\
				            					<td>'+toDoctor+'</td>\
				            					<td>'+reason+'</td>\
				            					<td>'+status+'</td>\
				            					<td>'+months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear()+'</td>\
						            		</tr>';
			            	}
			            	$('.referraltbody').empty().append(trTaGR);
				            $('.refferal-info').show();
			            }
			            // console.log('referral', data[2]);
		            }
		            catch(e)
		            {

		            }

	            	// Pending
	            	try
	            	{
			            trTaGP = '';
			            if(data[3].length > 0)
			            {
			            	$('.pending-info').show();
			            	let doctorsname = '', reason = '', status = '', date = '', day = '';
		            		for(i=0;data[3].length>i;i++)
		            		{
		            			doctorsname = data[3][i].doctorsname ? data[3][i].doctorsname : 'N/A';
		            			reason = data[3][i].reason ? data[3][i].reason : 'N/A';
		            			status = data[3][i].status ? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>';
								date = new Date(data[3][i].created_at);
								day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
			            		trTaGP += '<tr>\
				            					<td>'+doctorsname+'</td>\
				            					<td>'+data[3][i].name+'</td>\
				            					<td>'+reason+'</td>\
				            					<td>'+status+'</td>\
				            					<td>'+months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear()+'</td>\
						            		</tr>';
		            		}
			            	$('.pendingtbody').empty().append(trTaGP);
				            $('.pending-info').show();
			            }

	            	}
	            	catch(e)
	            	{

	            	}
	            }
	            catch(e)
	            {
		            let thTaG = '';
                    thTaG = '<th class="text-right" colspan="2">\
                                <span class="text-danger">Todays Vital Signs is Unavailable!</span>\
                                <br>\
                                Click this to insert vital signs\
                                <a href="/?#" class="btn btn-danger btn-circle btn-vital-sign-modal" rel="'+id+'">\
                                    <i class="fa fa-heartbeat"></i>\
                                </a>\
                            </th>';
		            $('.dateexamined').html(thTaG);

		            // Referral
		            try
		            {
			            if(data[2].length > 0)
			            {
			            	$('.refferal-info').show();

				            let trTaGR = '', fromClinic = '', fromDoctor = '', toClinic = '', toDoctor = '', reason = '', status = '', date = '', day = '';
		            		for(i=0;data[2].length>i;i++)
		            		{
		            			fromClinic = data[2][i].fromClinic ? data[2][i].fromClinic : 'N/A';
		            			fromDoctor = data[2][i].fromDoctor ? 'Dr. '+data[2][i].fromDoctor : 'N/A';
		            			toClinic = data[2][i].toClinic ? data[2][i].toClinic : 'N/A';
		            			toDoctor = data[2][i].toDoctor ? data[2][i].toDoctor : 'Unassigned';
		            			reason = data[2][i].reason ? data[2][i].reason : 'N/A';
		            			status = data[2][i].status ? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>';
								date = new Date(data[2][i].created_at);
								day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
			            		trTaGR += '<tr>\
				            					<td>'+data[2][i].name+'</td>\
				            					<td>'+fromClinic+'</td>\
				            					<td>'+fromDoctor+'</td>\
				            					<td>'+toClinic+'</td>\
				            					<td>'+toDoctor+'</td>\
				            					<td>'+reason+'</td>\
				            					<td>'+status+'</td>\
				            					<td>'+months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear()+'</td>\
						            		</tr>';
			            	}
			            	$('.referraltbody').empty().append(trTaGR);
				            $('.refferal-info').show();
			            }
			            // console.log('referral', data[2]);
		            }
		            catch(e)
		            {

		            }

	            	// Pending
	            	try
	            	{
			            trTaGP = '';
			            if(data[3].length > 0)
			            {
			            	$('.pending-info').show();
			            	let doctorsname = '', reason = '', status = '', date = '', day = '';
		            		for(i=0;data[3].length>i;i++)
		            		{
		            			doctorsname = data[3][i].doctorsname ? data[3][i].doctorsname : 'N/A';
		            			reason = data[3][i].reason ? data[3][i].reason : 'N/A';
		            			status = data[3][i].status ? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>';
								date = new Date(data[3][i].created_at);
								day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
			            		trTaGP += '<tr>\
				            					<td>'+doctorsname+'</td>\
				            					<td>'+data[3][i].name+'</td>\
				            					<td>'+reason+'</td>\
				            					<td>'+status+'</td>\
				            					<td>'+months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear()+'</td>\
						            		</tr>';
		            		}
			            	$('.pendingtbody').empty().append(trTaGP);
				            $('.pending-info').show();
			            }
		            	// console.log('Pending: ', data[3]);
	            	}
	            	catch(e)
	            	{

	            	}
	            }
				closeLoader();
        	},
			error: function(data) {
	            console.log('Failure response :', data);
				closeLoader();
			}
        });
    }

	function openLoader()
	{
	    $('.pageloaderWrapper').show();
	    $('.pageloaderWrapper').css({"left":"45%","top":"20%"});
		$('.loaderBackgroundColor').show();
	}

	function closeLoader()
	{
	    $('.pageloaderWrapper').hide();
		$('.loaderBackgroundColor').hide();
	}

    $(document).on('click', '.btn-vital-sign-modal', function(e){
        e.preventDefault();
        $("#vitalsigns-modal").modal('toggle');
         $('.vital-input').val('');
        let id = $(this).attr('rel');
        $.ajax({
        	url: baseUrl+"/vitalSignsajax",
        	type: "POST",
        	data: {
        		id:id
        	},
        	cache: false,
        	dataType: "JSON",
        	success: function(data) {
        		console.log('success response a: ',data);

        		$('.v-patients_id').val(data[0].id);
        		$('.v-name').text(data[0].last_name+', '+data[0].first_name+' '+data[0].middle_name+' '+data[0].suffix);
        		$('.v-hospital').text(data[0].hospital_no);
        		$('.v-barcode').text(data[0].barcode);
				date = new Date(data[0].birthday);
				day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
        		$('.v-birthday').text(months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear());
        		$('.v-age').text(data[0].age);
        		$('.v-address').text(data[0].address);
        		$('.v-status').text(data[0].civil_status);
        		$('.v-sex').text((data[0].sex == 'M') ? 'Male' : 'Female');
        		$('.v-contact').text(data[0].contact_no ? data[0].contact_no : 'None');
				date = new Date(data[0].created_at);
				day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
        		$('.v-date').text(months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear());
        	},
        	error: function(data) {
        		console.log('failure response: ',data);
        	}
        });
    });

    $('.btn-vital-sign').click(function(){
    	let patients_id = $('.v-patients_id').val();
    	let blood_pressure = $('.blood_pressure').val();
    	let pulse_rate = $('.pulse_rate').val();
    	let respiration_rate = $('.respiration_rate').val();
    	let body_temperature = $('.body_temperature').val();
    	let weight = $('.weight').val();
    	let height =$('.height').val();

    	console.log('patient id:', patients_id);

    	$.ajax({
    		url: baseUrl+"/storeVitalSignsAjax",
    		type: "POST",
    		data: {
    			patients_id:patients_id,
    			blood_pressure:blood_pressure,
    			pulse_rate:pulse_rate,
    			respiration_rate:respiration_rate,
    			body_temperature:body_temperature,
    			weight:weight,
    			height:height
    		},
    		cache: false,
    		dataType: "JSON",
    		success: function(data) {
    			console.log('success response', data);
	            toastr.success('Vital Signs successfully saved.');
	            vitalSignAjax(patients_id);
    		},
    		error: function(data) {
    			console.log('failure response', data);
    		}
    	});
    });

    $(document).on('click', '.btn-chiefcomplaint-modal', function(e){
        e.preventDefault();
        openLoader();

        runningModal = 1;
        btn_scope = $(this);

        $('.rcptn').hide();
        $('.chiefcomplaintpart').show();
        $("#chiefcomplaint-modal").modal('toggle');
        tinyMCE.get('diagnosis').setContent(consultationTable());
        console.log(btn_scope);

        let id = $(this).attr('id');
        $.ajax({
        	url: baseUrl+"/chief_complaint_ajax",
        	type: "POST",
        	data: {
        		id:id
        	},
        	cache: false,
        	dataType: "JSON",
        	success: function(data) {
        		console.log('success response: ', data);
        		closeLoader();

        		let name = data.last_name+' '+data.first_name;
        		$('.p-name').remove();
        		$('<span class="p-name">'+name+'</span>').insertAfter('.patient-name');
        		$('.hidden-id').val(id);
        	},
        	error: function(data) {
        		console.log('error response: ', data);
        		closeLoader();
        	}
        });
    });

    function consultationTable()
    {
    	return '<table id="teddy" class="table table-bordered" style="border-collapse:collapse; width:100%;height:1200px;" border="1">' +
			    '<thead>' +
			    '<tr style="background-color: #ccc;width: 400pxnote">' +
			    '<th style="padding:5px;width:90px;text-align:center" class="mceNonEditable">DATE/TIME</th>' +
			    '<th style="padding:5px;width:330px;text-align:center" class="mceNonEditable">DOCTOR\'S CONSULTATION</th>' +
			    '<th style="padding:5px;width:130px;text-align:center" class="mceNonEditable">NURSE\'S NOTES</th>' +
			    '</tr>' +
			    '</thead>' +
			    '<tbody>' +
			    '<tr style="width: 300px;">' +
			    '<td valign="top" style="width:90px;" id="doctors" class="mceEditable">' +
			    ''+today+''+
			    '</td>' +
			    '<td valign="top" style="width:330px;height: 668px" id="doctors" class="mceEditable"><span id="uniqueId">&nbsp;</span></td>' +
			    '<td valign="top" style="width:130px;" class="mceEditable"></td>' +
			    '</tr>' +
			    '</tbody>' +
			    '</table>';
    }

    $(document).on('click', '.btn-rcptnconsultationDetails-modal', function(e){
        e.preventDefault();
        openLoader();

        $('.rcptn').show();
        $('.diagnosisWrapper').hide();
        $('.chiefcomplaintpart').hide();
        $("#chiefcomplaint-modal").modal('toggle');

        let id = $(this).attr('id');
        btn_scope = $(this);
        console.log(btn_scope);
        consultationAjax(id,btn_scope);
    });

    function consultationAjax(id,btn_scope)
    {
        $.ajax({
        	url: baseUrl+"/rcptn_consultationDetailsAjax",
        	type: "POST",
        	data: {
        		id:id
        	},
        	cache: false,
        	dataType: "JSON",
        	success: function(data) {
        		console.log('success response: ', data);

        		let icd_codes = '';
        		$('.btn-print-notes').attr('href', baseUrl+'/printNurseNotes/'+data[0].id);
        		// $('.btn-nurse-notes').attr('href', baseUrl+'/nurseNotes/'+data[0].id);
        		$('.hidden-id').val(data[0].id);
        		$('.rcptn-consultation-show').show().html(data[0].consultation);
        		$('.rcptn-lastname').text(data[2].last_name);
        		$('.rcptn-firstname').text(data[2].first_name);
        		$('.rcptn-civilstatus').text(data[2].civil_status ? data[2].civil_status : '');
        		$('.rcptn-address').text(data[2].address);
        		$('.rcptn-middlename').text(data[2].middle_name);
				date = new Date(data[2].birthday);
				day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
        		$('.rcptn-birthday').text(months[date.getMonth()] + ' ' + day + ', ' +  date.getFullYear());
        		$('.rcptn-age').text(data[2].age);
        		$('.rcptn-contact').text(data[2].contact_no ? data[2].contact_no : '');

        		if(data[4].length > 0)
        		{
        			$('.diagnosisWrapper').show();
	        		data[4].forEach((icd_code) => {
	        			icd_codes += '<div class="form-group input-group">\
	                                        <input type="text" class="form-control" value="'+icd_code.description+'" readonly="" />\
	                                        <span class="input-group-addon">\
	                                            <i class="fa fa-trash-o"></i>\
	                                        </span>\
	                                    </div>';
	        		});

	        		$('.icd_codes').append(icd_codes);
	        		console.log('icd codes: ', icd_codes);
        		}

        		let wrapper = '';
        		let wrapperContent = '';
        		let uploadedFileConsultation = '';
        		let imagePreviewModal = '';
        		$('.upload_files').empty();
        		if(typeof data[1].files != 'undefined')
        		{
        			uploadedFileConsultation = '<div class="">\
						                        <br>\
						                        <br>\
						                        <h2 class="">Uploaded Files for this Consultation</h2>\
						                        <br>\
						                        <div class="bg-danger filesWrapper">';
	        		imagePreviewModal = '<div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreview" aria-hidden="true">\
					                            <div class="modal-dialog modal-xxl colorless" role="document">\
					                                <div class="modal-content colorless">\
					                                    <div class="modal-header">\
					                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1">\
					                                            <span class="text-danger">&times;</span>\
					                                        </button>\
					                                    </div>\
					                                    <div class="modal-body colorless">\
					                                        <div class="row colorless">\
					                                            <div class="col-md-8">\
					                                                <img src="" id="showImage" alt="Failed to load image." class="img-responsive center-block" />\
					                                            </div>\
					                                            <div class="col-md-4 imageDescWrapper">\
					                                                <div class="form-group">\
					                                                    <label for="">Title</label>\
					                                                    <input type="text" class="form-control" readonly id="showTitle" />\
					                                                </div>\
					                                                <div class="form-group">\
					                                                    <label for="">Description</label>\
					                                                    <textarea id="showDescription" cols="30" rows="10" class="form-control" readonly style="background-color: transparent"></textarea>\
					                                                </div>\
					                                                <br>\
					                                            </div>\
					                                        </div>\
					                                    </div>\
					                                </div>\
					                            </div>\
					                        </div>';

        			data[1].files.forEach((file) => {

		        		let fileType = ['doc','docx','txt','xlsx','xls','pdf','ppt','pptx'];
		        		let filename = file.filename.split('.');
        				wrapper += '<div class="imgWrapperPreview">';
        				if(filetype.includes(filename[1]))
        				{
        					wrapperContent = '<img src="'+data[3].directory+file.filename+'" alt="" class="img-responsive" width="100%" />\
	                                        <a href="" class="btn btn-primary btn-circle viewImage" data-placement="top" data-toggle="tooltip" title="View this file?">\
	                                            <i class="fa fa-image"></i>\
	                                        </a>';
        				}
        				else
        				{
        					if(filename[1] == 'doc' || filename[1] == 'docx')
        					{
	        					wrapperContent = '<img src="'+baseUrl+'/public/images/mswordlogo.svg" alt="" class="img-responsive" />';
        					}
        					else if(filename[1] == 'xlsx' || filename[1] == 'xls')
        					{
	        					wrapperContent = '<img src="'+baseUrl+'/public/images/excellogo.svg" alt="" class="img-responsive" />';
        					}
        					else if(filename[1] == 'ppt' || filename[1] == 'pptx')
        					{
	        					wrapperContent = '<img src="'+baseUrl+'/public/images/powerpointlogo.svg" alt="" class="img-responsive" />';
        					}
        					else if(filename[1] == 'pdf')
        					{
	        					wrapperContent = '<img src="'+baseUrl+'/public/images/pdflogo.svg" alt="" class="img-responsive" />';
        					}
        					else
        					{
	        					wrapperContent = '<img src="'+baseUrl+'/public/images/textlogo.svg" alt="" class="img-responsive" />';
        					}
        					wrapperContent += '<a href="{{ $directory.$file->filename }}" target="_blank" class="btn btn-info btn-circle" data-placement="top" data-toggle="tooltip" title="Open this file?">\
		                                            <i class="fa fa-file-text-o"></i>\
		                                        </a>';
        				}
        				wrapperContent += '<input type="hidden" value="'+file.title+'" class="title" />\
		                                    <textarea hidden class="description">'+file.description+'</textarea>';
						wrapper += wrapperContent+'</div>';

        			});
        			uploadedFileConsultation += wrapper+'div'+imagePreviewModal+'div';
        			$('.upload_files').append(uploadedFileConsultation);
        		}
        		closeLoader();
        	},

        	error: function(data) {
        		closeLoader();
        		console.log('error response: ', data);
        	}
        });
    }

    $(document).on('click', '.btn-writenotes-modal', function(e){
        e.preventDefault();
        openLoader();
        runningModal = 2;
        $("#z-nursenotes-modal").modal('toggle');
        let cid = $('.hidden-id').val();
        $.ajax({
        	url: baseUrl+"/nurseNotesAjax",
        	type: "POST",
        	data: {
        		cid:cid
        	},
        	cache: false,
        	dataType: "JSON",
        	success: function(data) {
        		console.log('success response: ', data);
        		closeLoader();
        		$('.p-name').remove();
        		$('.iconsNurse').attr('href', baseUrl+'/printNurseNotes/'+data[0].id);
        		$('<span class="p-name"> '+data[0].patient+'</span>').insertAfter('.patient-name');
		        tinyMCE.get('diagnosis2').setContent(data[0].consultation);

        	},
        	error: function(data) {
        		closeLoader();
        		console.log('error response: ', data);
        	}
        });
    });

    $(document).on('click', '.save-nurse-notes', function(e){
    	e.preventDefault();
    	ajaxSave();
    });

});