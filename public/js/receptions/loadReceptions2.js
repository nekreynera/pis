
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('click', '.assignToDoctor', function(e){
    e.preventDefault();
    console.log('Assign');
    openLoader();
    let pid = $(this).attr('name');
    let did = $(this).attr('rel');

    let that = $(this);
    $.ajax({
        url: baseUrl+"/assign",
        type: 'post',
        data: {
            pid:pid,
            did:did
        },
        cache: false,
        dataType: 'JSON',
        success: function(data){
            console.log('Success response:', data);
            closeLoader();
			loadDoctors();
			loadStatus();
			if(data != 0)
			{
				let myString = $('.loadPatients').attr('charoff');
				let status = myString.charAt(myString.length-1);
				if(status != 'T' && status != 'P' && status != 'H')
				{
					ctr = 1;
					$(that).closest('tr').hide(1000, function(){
						$(this).remove();
						$('tr.ctr').each(function(){
							$(this).find('td').eq(1).text(ctr);
							ctr++;
						});
						noPatient(ctr);
					});
				}
				else
				{
					if(confirm("Do you wish to reload the patient lists? If canceled, then, it will update only the patient that you've taken in action.") == true)
					{
					    openLoader();
						loadPatient();
					}
					else
					{
						$(that).closest('td').find('.dropdown').find('a').addClass('disabled').prop('disabled', true);
						$(that).closest('td').next().find('.dropdown').find('a').removeClass('disabled').removeAttr('disabled').attr('data-toggle', 'dropdown');
						$(that).closest('td').next().next().find('a').attr('name', 'btn-cancelAssignation');
						data == 1 ? '' : $(that).closest('td').next().next().find('a').attr('rel', data);
						let scope = $(that).closest('td').next().find('.dropdown').find('a').next();
						getAllDoctors(that,scope,data,did);
					}
				};
	            toastr.success('Patient Successfully Assigned.');
	        }
	        else
	        {
	        	toastr.error('Patient Already Assigned.');
	        }
        },
		error: function(data) {
	        console.log('Failure response :', data);
		}
    });
});
$(document).on('click', '.reassignToDoctor', function(e){
    e.preventDefault();
    openLoader();
    let aid = $(this).attr('name');
    let did = $(this).attr('rel');

	console.log('pid did: ',aid+' '+did);
    let that = $(this);
    $.ajax({
        url: baseUrl+"/reassign",
        type: 'post',
        data: {
            aid:aid,
            did:did
        },
        cache: false,
        dataType: 'JSON',
        success: function(data){
            // console.log('Success response :', data);
            closeLoader();
			loadDoctors();
			loadStatus();
			let myString = $('.loadPatients').attr('charoff');
			let status = myString.charAt(myString.length-1);
			if(status != 'T' && status != 'P' && status != 'H')
			{
				ctr = 1;
				$(that).closest('tr').hide(1000, function(){
					$(this).remove();
					$('tr.ctr').each(function(){
						$(this).find('td').eq(1).text(ctr);
						ctr++;
						noPatient(ctr);
					});
				});
				$(that).closest('tr').hide(1000);
			}
			else
			{
				if(confirm("Do you wish to reload the patient lists? If canceled, then, it will update only the patient that you've taken in action.") == true)
				{
					loadPatient();
				}
				else
				{
					let scope = $(that).closest('td').find('.dropdown').find('a').next();
					getAllDoctors(that,scope,aid,did);
				}
			}
            toastr.success('Patient successfully Reassigned.');
        },
        error: function(data) {
            console.log('Error response :', data);
        }
    });
});

// This is used for getting the list of all online doctors at assign & reassign button patient
function getAllDoctors(that,scope,aid,did)
{
	$.ajax({
		url: baseUrl+"/getAllActiveDoctors",
		type: "POST",
		data: {
			aid:aid
		},
		cache: false,
		dataType: 'JSON',
		success: function(data) {
            // console.log('Success response :', data);
			let myString = $('.loadPatients').attr('charoff');
			let status = myString.charAt(myString.length-1);
            let doctorsName = $(that).html();
			let doctors = '';
			let sameDoctor = '';
			let onclickAttr = '';
			let count = data.length;
			doctors += did == 0 ? '<li class="dropdown-header">-- Assign to Doctor --</li>' : '<li class="dropdown-header">-- Re-assign to Doctor --</li>';
			let trgClass = did == 0 ? 'assignToDoctor' : 'reassignToDoctor';
            for (i=0;count>i;i++) {
        		checkAssigned = data[i].assignedDoctor.includes(data[i].id) ? '#adebad' : '';
        		if(data[i].doctorActiveStat == true)	
        		{
        			sameDoctor = data[i].id == did ? 'disabled' : '';
        			onclickAttr = data[i].id == did ? 'onclick="return false"' : 'onclick="return confirm("Re-assign this patient?")"';
        			doctors += '<li class="'+sameDoctor+'">\
			                        <a href="?#" name="'+aid+'" rel="'+data[i].id+'" class="'+trgClass+'" style="background-color: '+checkAssigned+' '+onclickAttr+'">\
			                            <div class="online"></div> <span class="text-uppercase">Dr. '+data[i].name+'</span>\
			                        </a>\
			                    </li>';
        		}
            }

            $(that).closest('tr').find('td').eq(9).find('a').removeClass('disabled').removeAttr('disabled');
            $(that).closest('tr').find('td').eq(1).removeClass('cancel finished serving').addClass('pending');
            $(that).closest('tr').find('td').eq(4).html(doctorsName);
        	did != 0 ? $(scope).empty().append(doctors) : $(scope).append(doctors);
            // console.log('doctors name: ', that);
		},
		error: function(data) {
            console.log('Failure response :', data);
		}
	});
}

$(document).on('click', '.btn-nawc', function(e){

    openLoader();
	e.preventDefault();
    let that = $(this);
    let aid = $(this).attr('rel');
    let classUrl = $(this).attr('name') == 'btn-cancelUnassigned' ? baseUrl+"/cancelUnassigned" : baseUrl+"/cancelAssignation";
    if(confirm('Cancel this patient?') == true)
    {
		let ajax = $.ajax({
			url: classUrl,
			type: 'POST',
			data: {
				pid:aid
			},
			cache: false,
			dataType: "JSON",
			success: function(data) {
	            console.log('Success response :', data);
				loadDoctors();
				loadStatus();
				if($(that).attr('name') == 'btn-cancelUnassigned')
				{
		            closeLoader();

					ctr = 1;
					$(that).closest('tr').hide(1000, function(){
						$(this).remove();
						$('tr.ctr').each(function(){
							$(this).find('td').eq(1).text(ctr);
							ctr++;
						});
						noPatient(ctr);
					});
				}
				else
				{
		            closeLoader();
					let myString = $('.loadPatients').attr('charoff');
					let status = myString.charAt(myString.length-1);
					if(status == 'P')
					{
						ctr = 1;
						$(that).closest('tr').hide(1000, function(){
							$(this).remove();
							$('tr.ctr').each(function(){
								$(this).find('td').eq(1).text(ctr);
								ctr++;
							});
							noPatient(ctr);
						});
					}
					else
					{
						$(that).closest('td').find('a').addClass('disabled').prop('disabled', true);
						$(that).closest('td').prev().find('a').addClass('disabled').prop('disabled', true);
						$(that).closest('td').prev().prev().find('.dropdown').find('a').removeClass('disabled').removeAttr('disabled').attr('data-toggle', 'dropdown');
			            $(that).closest('tr').find('td').eq(1).removeClass('pending').addClass('cancel');
			            $(that).closest('tr').find('td').eq(4).html('<span class="text-danger">N/A</span>');
					}
				}
			},
			error: function(data) {
	            console.log('Failure response :', data);
			}
		});
    }
    else
    {
        closeLoader();
    	return false;
    }
});

// Call all functions
loadDoctors();
loadStatus();
loadPatient();

openLoader();
let metaTag = $('meta[name="csrf-token"]').attr('content');

// Loads all online doctors
function loadDoctors() {

	let metaTag = $('meta[name="csrf-token"]').attr('content');
	let loadDoctors = new Worker('../../opd/public/js/workers/loadDoctors.js');
	loadDoctors.onmessage = (e) => {
		// console.log(e.data);
		$('.doctorsName').empty().append(e.data);
	}
	loadDoctors.postMessage([metaTag,baseUrl]);
}

function loadStatus() {

	let metaTag = $('meta[name="csrf-token"]').attr('content');
	let loadStatus = new Worker('../../opd/public/js/workers/loadStatus.js');
	loadStatus.onmessage = (e) => {
		// console.log('Status :', e.data);
		let survey = $('.status').attr('id');

		let statusTag = '';
		let statusData = e.data;
		let status_O = survey == '' ? 'unassignedTabActive' : '';
		let status_P = survey == 'P' ? 'pendingTabActive' : '';
		let status_H = survey == 'H' ? 'pausedTabActive' : '';
		let status_C = survey == 'C' ? 'nawcTabActive' : '';
		let status_S = survey == 'S' ? 'servingTabActive' : '';
		let status_F = survey == 'F' ? 'finishedTabActive' : '';
		let status_T = survey == 'T' ? 'totalTabActive' : '';
		let noDoctorsClinic = [10,48,22,21];
		unassigned = statusData.unassigned.length;
		try
		{

			statusP = statusData[0].pending != ''? statusData[0].pending : '0';
			statusH = statusData[0].paused != ''? statusData[0].paused : '0';
			statusC = statusData[0].nawc != ''? statusData[0].nawc : '0';
			statusS = statusData[0].serving != ''? statusData[0].serving : '0';
			statusF = statusData[0].finished != ''? statusData[0].finished : '0';
			countAll = statusData != '' ? Number(statusP)+Number(statusH)+Number(statusC)+Number(statusS)+Number(statusF)+Number(unassigned) : unassigned;

			statusTag = '<ul class="nav nav-pills">\
					    <li>\
					        <a href="'+baseUrl+'/overview"\
					           class="unassignedTab '+status_O+'">\
					            Unassigned <span class="badge">'+unassigned+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/P"\
					           class="pendingTab '+status_P+'">\
					            Pending <span class="badge">'+statusP+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/H"\
					           class="pausedTab '+status_H+'">\
					            Paused <span class="badge">'+statusH+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/C"\
					           class="nawcTab '+status_C+'">\
					            NAWC <span class="badge">'+statusC+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/S"\
					           class="servingTab '+status_S+'">\
					            Serving <span class="badge">'+statusS+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/F"\
					           class="finishedTab '+status_F+'">\
					            Finished <span class="badge">'+statusF+'</span>\
					        </a>\
					    </li>\
					    <li>\
					        <a href="'+baseUrl+'/overview/T"\
					           class="totalTab '+status_T+'">\
					            Total <span class="badge">\
					            '+countAll+'\
					                </span>\
					        </a>\
					    </li>';

		}
		catch(e)
		{
			if(!noDoctorsClinic.includes(statusData.userClinic))
			{
				statusTag = '<ul class="nav nav-pills">\
						    <li>\
						        <a href="'+baseUrl+'/overview"\
						           class="unassignedTab '+status_O+'">\
						            Unassigned <span class="badge">'+unassigned+'</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/P"\
						           class="pendingTab '+status_P+'">\
						            Pending <span class="badge">0</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/H"\
						           class="pausedTab '+status_H+'">\
						            Paused <span class="badge">0</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/C"\
						           class="nawcTab '+status_C+'">\
						            NAWC <span class="badge">0</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/S"\
						           class="servingTab '+status_S+'">\
						            Serving <span class="badge">0</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/F"\
						           class="finishedTab '+status_F+'">\
						            Finished <span class="badge">0</span>\
						        </a>\
						    </li>\
						    <li>\
						        <a href="'+baseUrl+'/overview/T"\
						           class="totalTab '+status_T+'">\
						            Total <span class="badge">'+unassigned+'</span>\
						        </a>\
						    </li>';
			}
		}
		$('.overviewstatus').empty().append(statusTag);
	}
	loadStatus.postMessage([metaTag,baseUrl]);
	// loadStatus.postMessage([metaTag,baseUrl,$('.status').attr('id')]);
}

function loadPatient() {
	let metaTag = $('meta[name="csrf-token"]').attr('content');
	let loadPatient = new Worker('../../opd/public/js/workers/loadPatient.js');
	let patientsIDs = new Array();
	let chargingIDs = new Array();
	let chargingQueueStatus = new Array();
	let drpIDs = new Array();
	loadPatient.onmessage = (e) => {
		// console.log('patient: ',e.data);
		$('.loadPatients').empty().append(e.data);
		$('.clinic-notes').each(function() {
			patientsIDs.push($(this).attr('id'));
		});
		$('.loader-field2').hide();
        closeLoader();
		countConsultation(patientsIDs);
		if($('.clinic-notes')[0])
		{
			$('.clinic-notes').each(function() {
				chargingIDs.push($(this).attr('id'));
				chargingQueueStatus.push($(this).attr('rel'));
			});

			loadCharging(chargingIDs,chargingQueueStatus);
		}

		$('.ul-id').each(function(){
			drpIDs.push($(this).attr('id'));
		});

		loadAllUndonePatients(drpIDs);
	}
	loadPatient.postMessage([metaTag,baseUrl,$('.status').attr('id'),$('.loadPatients').attr('id'),$('.loadPatients').attr('data-id'),$('[name="_token"]').val()]);
}

function countConsultation(id)
{
	let consultationCount = new Worker('../../opd/public/js/workers/loadCountConsultation.js');
	consultationCount.onmessage = (e) => {
		// console.log('count consultation :', e.data);
		let countCheck = e.data;
		notes(countCheck);
	}
	consultationCount.postMessage([metaTag,baseUrl,id]);
}

function notes(note)
{
	note.forEach( (note) => {
		if(note.consultationCount == 0)
		{
			$('.note'+note.id).removeClass('disabled');
		}
		else
		{
			if(note.note_id[0].role != 7)
			{
				$('.note'+note.id).removeClass('disabled');
				// $('.note'+note.id).attr('href',baseUrl+'/rcptn_consultationDetails/'+note.note_id[0].id);
				$('.note'+note.id).removeClass('btn-chiefcomplaint-modal').addClass('btn-rcptnconsultationDetails-modal').attr('id', note.note_id[0].id);
			}
		}
	});
	$('.clinic-notes').find('i').removeClass('fa-spinner fa-pulse').addClass('fa-pencil');
}

function loadCharging(id,charge)
{
	let charging = new Worker('../../opd/public/js/workers/loadCharging.js');
	charging.onmessage = (e) => {
		// console.log('load charging :', e.data);
		let charging = e.data;
		let chrgingClinics = [3,5,8,24,32,34,10,48,22,21,25,11,26,52,17];
		let userClinic = '';
		let pid = '';
		let chargingLength = charging.length;
		let check = '';
		let lbl = '';
		let btnClass = '';
		let done = '';

		charging.forEach( (patient) => {

			userClinic = patient.userClinic;
			pid = patient.id;
			lbl = '';
			btnClass = '';
			patient.charging.forEach( (checkCharging) => {

				// A
				done = checkCharging.paid <= 0 || patient.queue_status == 'D' ? 'disabled' : '';
				checkCharging.paid <= 0 || patient.queue_status == 'D' ? '' : $('.'+patient.id).removeClass('disabled');
				btnClass = (done != 'disabled') ? $('.'+patient.id).removeClass('btn-default').addClass('btn-primary') : '';

				done = checkCharging.paid <= 0 || patient.queue_status == 'D' ? 'disabled' : '';
				checkCharging.paid <= 0 || patient.queue_status == 'D' ? '' : $('.check'+patient.id).removeClass('disabled');
				btnClass = (done != 'disabled') ? $('.check'+patient.id).removeClass('btn-default').addClass('btn-primary') : '';

				// B
				if(chrgingClinics.includes(userClinic))
				{
					if(chargingLength > 0)
					{
						if(checkCharging.request > 0)
						{
							chargeClass = checkCharging.paid == 0 ? 'label-danger' : 'label-success';
							lbl += '<label class="label label-primary"\
	                               data-placement="top" data-toggle="tooltip" title="Requests">'+checkCharging.request+'</label>\
			                        <label class="label '+chargeClass+'"\
			                               data-placement="top" data-toggle="tooltip" title="Paid">'+checkCharging.paid+'</label>';
						}
						else
						{
							lbl += '<label class="label label-danger">No Pending Request</label>';
						}
					}
					else
					{
						lbl += '<label class="label label-danger" data-placement="top" data-toggle="tooltip" title="Requests">No Pending Request</label>';
					}
				}

			});
			$('.'+patient.id).addClass(btnClass);

			// B
			$('.btn-undone > ul.'+pid).parent().parent().find('.label').remove();
			$('.btn-undone > ul.'+pid).parent().parent().append(lbl);
			closeLoader();

		});

	}
	charging.postMessage([metaTag,baseUrl,id,charge])
}

function loadAllUndonePatients(id)
{
	let loadAllUndone = new Worker('../../opd/public/js/workers/loadAllUndonePatients.js');

	loadAllUndone.onmessage = (e) => {

		// console.log(e.data);
		let undonePatient = e.data;
		let li = '';
		let uA = ''
		let created_at = '';
		let pid = '';
		let countUndonePatient = '';
		let allServiceDone = '';
		let month = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVERMBER','DECEMBER'];

		try
		{
			undonePatient.forEach( (undone) => {

				li = '';
				uA = '';
				pid = undone.id;
				countUndonePatient = undone.loadAllUndone.length;
				// allServiceDone = (countUndonePatient > 0) ? '' : 'disabled';
				// $('.btn-undone > ul.'+pid).prev().addClass(allServiceDone);
				allServiceDone = (countUndonePatient > 0) ? 'disabled' : '';
				$('.btn-undone > ul.'+pid).prev().removeClass(allServiceDone);
				undone.loadAllUndone.forEach( (undone2) => {

					created_at = new Date(undone2.created_at);
					if(undone2.get == 'N')
					{
						uA = '<a href="'+baseUrl+'/done/'+undone2.id+'/Y" data-placement="left" data-toggle="tooltip" title="Click to Done this service">\
		                            <i class="fa fa-check text-success"></i> &nbsp; '+undone2.sub_category+' | <label class="label label-default">'+month[created_at.getMonth()]+' '+created_at.getDate()+', '+created_at.getFullYear()+'</label>\
		                        </a>';
					}
					else
					{
						uA = '<a href="'+baseUrl+'/done/'+undone2.id+'/N" data-placement="left" data-toggle="tooltip" title="Click to Done this service">\
		                            <i class="fa fa-check text-success"></i> &nbsp; '+undone2.sub_category+' | <label class="label label-default">'+month[created_at.getMonth()]+' '+created_at.getDate()+', '+created_at.getFullYear()+'</label>\
		                        </a>';
					}

					rowClass= (undone2.get == 'N') ? 'bg-success' : 'bg-danger';
					li += '<li class="'+rowClass+'">'+uA+'</li>';

				});
				$('.btn-undone > ul.'+pid).empty().prepend(li);

			});
		}
		catch(e)
		{
			// console.log('Empty');
		}

	}

	loadAllUndone.postMessage([metaTag,baseUrl,id,$('.loadPatients').attr('id')]);
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

function noPatient(ctr)
{
	let trTag = '<tr>\
			    <td colspan="11" class="text-center nopatient">\
			        <div class="well">\
			            <strong class="text-danger">No patient on the list <i class="fa fa-exclamation"></i></strong>\
			        </div>\
			    </td>\
			</tr>';
	ctr == 1 ? $('.loadPatients').append(trTag) : '';
}