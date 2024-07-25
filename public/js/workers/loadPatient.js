

self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadPatients";
	let content = e.data[0];
	let statusS = e.data[2];
	let baseUrl = e.data[1];
	let request = e.data[3];
	let request2 = e.data[4];
	let token = e.data[5];
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader('X-CSRF-Token', content);

	http.onreadystatechange = () => {
		if(http.readyState === 4 && http.status === 200) {

			let tr_tag = '', td1 = '', td2 = '', td2Content = '', td3 = '', td3Div = '', td4 = '', tdContentInfo = '', tdContentInfo2 = '', td4Anchor = '', td5 = '', td5Cont = '',
			td6 = '', td6Class = '', td6Cont = '', td7 = '', td7Class = '', td7Cont = '', sameDoctor = '', onclickAttr = '',
			td8 = '', td8UrlCancel = '', td8QueueStat = '', td9 = '', td10 = '', td11Cont = '', td11 = '', td12 = '', td12Cont = '',
			tdBtnClass, eturnConfirm = '', returnConfirm1 = '', cancelClass = '';
			count = 1;
			let patients = JSON.parse(http.responseText);
			let chrgingClinics = [3,5,8,24,32,34,10,48,22,21,25,11,26,52,17];
			let noDoctorsClinic = [48,22,21];
			let queueStatus = '';
			let numPatient = patients.length;

			if(numPatient > 0)
			{
                let fin = 0, can = 0, asgn = '', reasgn = '', cancel = '', pau = 0, unassgned = 0, pen = 0, serv = 0, status = '';

				patients.forEach( (patient) => {
					status = 'cancel';
					tdContentInfo = '';
					tdContentInfo2 = '';

                    if(patient.status == 'P')
                    {
                        asgn = 'disabled onclick="return false"';
                        reasgn =	 '';
                        cancel = '';
                        status = 'pending';
                        pen++;
                    }
                    else if(patient.status == 'S')
                    {
                        asgn = 'disabled onclick="return false"';
                        reasgn = 'disabled onclick="return false"';
                        cancel = 'disabled onclick="return false"';
                        status = 'serving';
                        serv++;
                    }
                    else if(patient.status == 'F')
                    {
                        asgn = '';
                        reasgn = 'disabled onclick="return false"';
                        cancel = 'disabled onclick="return false"';
                        status = 'finished';
                        fin++;
                    }
                    else if(patient.status == 'C')
                    {
                        asgn = '';
                        reasgn = 'disabled onclick="return false"';
                        cancel = 'disabled onclick="return false"';
                        $status = 'cancel';
                        can++;
                    }
                    else if(patient.status == 'H')
                    {
                        asgn = '';
                        reasgn = 'disabled onclick="return false"';
                        cancel = 'disabled onclick="return false"';
                        status = 'paused';
                        pau++;
                    }
                    else
                    {
                        asgn = '';
                        reasgn = 'disabled onclick="return false"';
                        cancel = '';
                        status = 'unassigned';
                        unassgned++;
                    }

                    // ORDER #
					td1 = '<tr class="ctr"><td hidden>\
								    '+ count+1 +'\
								</td>';

					// PATIENT NAME & AGE
					if(noDoctorsClinic.includes(patient.userClinic))
					{
						if(patient.queue_status == 'C')
						{
							queueStatus = 'nawc';
						}
						else if(patient.queue_status == 'F')
						{
							queueStatus = 'finished';
						}
						else if(patient.queue_status == 'D')
						{
							queueStatus = 'serving';
						}
						else
						{
							queueStatus = 'pending';
						}

						td2Content = '<td class="'+queueStatus+'">\
							        '+ count++ +'\
							    </td>';
					}
					else
					{
						td2Content = '<td class="'+status+'">\
							        '+ count++ +'\
							    </td>';
					}

					// PATIENT NAME AND AGE
					ageStat = (patient.age >= 60) ? "<strong style='color: red'>"+patient.age+"</strong>" : "<span class='text-default'>"+patient.age+"</span>";
					td2 = td2Content+'<td>'+patient.name+'</td>\
						    <td>'+ageStat+'</td>'

					// DOCTOR NAME
					if(patient.userClinic != 31)
					{
						if(patient.status == 'S' || patient.status == 'P' || patient.status == 'F' || patient.status == 'H')
						{
							if(patient.activeStat)
							{
								td3Div = '<div class="online"></div> <span class="text-default">Dr. '+(patient.doctorsname ? patient.doctorsname.toUpperCase() : '' )+'</span>';
							}
							else
							{
								td3Div = '<div class="offline"></div> <span class="text-default">Dr. '+(patient.doctorsname ? patient.doctorsname.toUpperCase() : '' )+'</span>';
							}
						}
						else
						{
							td3Div = '<span class="text-danger">N/A</span>';
						}

						td3 = '<td>'+td3Div+'</td>';
					}

					// PATIENT INFO
					if(patient.checkIfForRefferal > 0)
					{
						// td4Anchor = '<a href="'+baseUrl+'/patient_info/'+patient.id+'" class="btn btn-info btn-circle">\
						// 	            <i class="fa fa-user-o"></i>\
						// 	        </a>';
						td4Anchor = '<a href="?#" name="'+patient.id+'" class="btn btn-info btn-patient-info-modal btn-circle">\
							            <i class="fa fa-user-o"></i>\
							        </a>';
					}
					else
					{
						// td4Anchor = '<a href="'+baseUrl+'/patient_info/'+patient.id+'" class="btn btn-default btn-circle">\
						// 	            <i class="fa fa-user-o text-primary"></i>\
						// 	        </a>';
						td4Anchor = '<a href="?#" name="'+patient.id+'" class="btn btn-default btn-patient-info-modal btn-circle">\
							            <i class="fa fa-user-o text-primary"></i>\
							        </a>';
					}

					if(patient.rf)
					{
						tdContentInfo = '<span class="notifyBadgeNumber badge">'+patient.rf+'</span>';
					}
					if(patient.ff)
					{
						tdContentInfo2 = '<span class="notifyFollowUpBadgeNumber badge">'+patient.ff+'</span>';
					}
					td4 = '<td>'+td4Anchor+tdContentInfo+tdContentInfo2+'</td>';

					// PATIENT RECORD
					if(patient.userClinic != 21 || patient.userClinic != 22)
					{
						if(patient.cid == null)
						{
							td5Cont = "<button class='btn btn-default btn-circle'\
								                onclick='medicalRecords("+patient.id+")' id='"+patient.id+"' rel='"+patient.queue_status+"' title='View medical record's'>\
								            <i class='fa fa-file-text-o text-primary'></i>\
								        </button>";
						}
						else
						{
							td5Cont = "<button class='btn btn-primary btn-circle'\
								                onclick='medicalRecords("+patient.id+")' id='"+patient.id+"' rel='"+patient.queue_status+"' title='View medical record's'>\
								            <i class='fa fa-file-text-o text-default'></i>\
								        </button>";
						}
						td5 = '<td>'+td5Cont+'</td>';
					}

					// PATIENT ASSIGN & REASSIGN
					if(!noDoctorsClinic.includes(patient.userClinic))
					{
						td6Class = asgn.length == 0 ? 'data-toggle="dropdown"' : asgn;

						// assign
						if(typeof patient.allDoctors != 'undefined')
						{
				            if(patient.allDoctors.length > 0)
				            {
				            	td6Cont = '';
				            	patient.allDoctors.forEach( (doctor) => {
				            		checkAssigned = patient.assignedDoctor.includes(doctor.id) ? '#adebad' : '';
				            		if(doctor.doctorActiveStat == true)
				            		{
				            			// td6Cont = '<li>\
								           //              <a href="'+baseUrl+'/assign/'+patient.id+'/'+doctor.id+'" style="background-color: '+checkAssigned+'">\
								           //                  <div class="online"></div> <span class="text-uppercase">Dr. '+doctor.name+'</span>\
								           //              </a>\
								           //          </li>';
				            			td6Cont += '<li>\
								                        <a href="?#" name="'+patient.id+'" rel="'+doctor.id+'" class="assignToDoctor" style="background-color: '+checkAssigned+'">\
								                            <div class="online"></div> <span class="text-uppercase">Dr. '+doctor.name.toUpperCase()+'</span>\
								                        </a>\
								                    </li>';
				            		}
				            	})
				            }
				        }

						td6 = '<td>\
								    <div class="dropdown">\
								        <a href="" class="btn btn-default btn-circle dropdown-toggle" '+td6Class+'>\
								            <i class="fa fa-arrow-left text-success"></i>\
								        </a>\
								        <ul class="dropdown-menu dropdown-menu-right">\
								            <li class="dropdown-header">--Assign to Doctor--</li>\
								            '+td6Cont+'\
								        </ul>\
								    </div>\
								</td>';

						td7Class = reasgn.length == 0 ? 'data-toggle="dropdown"' : reasgn;

						// REASSIGN
						if(typeof patient.allDoctors != 'undefined')
						{
							if(patient.allDoctors.length > 0)
							{
								td7Cont = '';
				            	patient.allDoctors.forEach( (doctor) => {
				            		checkAssigned = patient.assignedDoctor.includes(doctor.id) ? '#adebad' : '';
				            		if(doctor.doctorActiveStat == true)
				            		{
				            			sameDoctor = doctor.id == patient.doctors_id ? 'disabled' : '';
				            			onclickAttr = doctor.id == patient.doctors_id ? 'onclick="return false"' : 'onclick="return confirm("Re-assign this patient?")"';
				            			// td7Cont = '<li class="'+sameDoctor+'">\
								           //              <a href='+baseUrl+'/reassign/'+doctor.id+'/'+patient.asgnid+' style="background-color: '+checkAssigned+' '+onclickAttr+'">\
								           //                  <div class="online"></div> <span class="text-uppercase">Dr. '+doctor.name+'</span>\
								           //              </a>\
								           //          </li>';
				            			td7Cont += '<li class="'+sameDoctor+'">\
								                        <a href="?#" name="'+patient.asgnid+'" rel="'+doctor.id+'" class="reassignToDoctor" style="background-color: '+checkAssigned+' '+onclickAttr+'">\
								                            <div class="online"></div> <span class="text-uppercase">Dr. '+doctor.name.toUpperCase()+'</span>\
								                        </a>\
								                    </li>';
				            		}
				            	})
							}
						}

						td7 = '<td>\
								    <div class="dropdown">\
								        <a href="" class="btn btn-default btn-circle dropdown-toggle" '+td7Class+'>\
								            <i class="fa fa-refresh text-primary"></i>\
								        </a>\
								        <ul class="dropdown-menu dropdown-menu-right">\
								            <li class="dropdown-header">-- Re-assign to Doctor --</li>\
								            '+td7Cont+'\
								        </ul>\
								    </div>\
								</td>';
					}

					// CANCEL
					if(!noDoctorsClinic.includes(patient.userClinic))
					{
						// returnConfirm = "return confirm('Cancel this patient?')"
						// td8UrlCancel = patient.status == null ? baseUrl+'/cancelUnassigned/'+patient.id : baseUrl+'/cancelAssignation/'+patient.asgnid;
						// td8 = '<td>\
						// 	        <a href="'+td8UrlCancel+'"\
						// 	           class="btn btn-default btn-nawc btn-circle" '+cancel+' onclick="'+returnConfirm+'">\
						// 	            <i class="fa fa-remove text-danger"></i>\
						// 	        </a>\
						// 	    </td>';
						cancelName = patient.status == null ? 'btn-cancelUnassigned' : 'btn-cancelAssignation';
						patientId = patient.status == null ? patient.id : patient.asgnid;
						td8 = '<td>\
							        <a rel="'+patientId+'" href="/?#"\
							           class="btn btn-default btn-nawc btn-circle" '+cancel+' name="'+cancelName+'">\
							            <i class="fa fa-remove text-danger"></i>\
							        </a>\
							    </td>';
					}
					else
					{
						if(patient.queue_status == 'C')
						{
							returnConfirm = "return confirm('Restore this patient?')"
							td8QueueStat = patient.queue_status == 'F' ? 'disabled' : '';
							td8 = '<td>\
							            <a href="'+baseUrl+'/queueStatus/'+patient.id+'/P"\
							               data-placement="top" data-toggle="tooltip" title="Click to mark as pending"\
							               class="btn btn-default btn-nawc btn-circle '+td8QueueStat+'"\
							               onclick="'+returnConfirm+'">\
							                <i class="fa fa-refresh text-success"></i>\
							            </a>\
							        </td>';
						}
						else
						{
							returnConfirm = "return confirm('Cancel this patient?')";
							td8QueueStat = patient.queue_status == 'F' || patient.queue_status == 'D' ? 'disabled' : '';
							td8 = '<td>\
							            <a href="'+baseUrl+'/queueStatus/'+patient.id+'/C"\
							               data-placement="top" data-toggle="tooltip" title="Click to mark as NAWC"\
							               class="btn btn-default btn-nawc btn-circle '+td8QueueStat+'"\
							               onclick="'+returnConfirm+'">\
							                <i class="fa fa-remove text-danger"></i>\
							            </a>\
							        </td>';
						}
					}

					// NOTES
					// td9 = '<td>\
					// 		    <a href="'+baseUrl+'/chief_complaint/'+patient.id+'"\
					// 		       class="btn btn-default btn-circle clinic-notes disabled note'+patient.id+'" id="'+patient.id+'">\
					// 		        <i class="fa fa-spinner fa-pulse text-primary"></i>\
					// 		    </a>\
					// 		</td>';
					td9 = '<td>\
							    <a href="/?#"\
							       class="btn btn-default btn-circle clinic-notes btn-chiefcomplaint-modal disabled note'+patient.id+'" id="'+patient.id+'">\
							        <i class="fa fa-spinner fa-pulse text-primary"></i>\
							    </a>\
							</td>';

				    // TIMESTAMP
					created_at = new Date(patient.created_at);
				    var hours = created_at.getHours();
				    var minutes = created_at.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12;
					minutes = minutes < 10 ? '0'+minutes : minutes;
					td10 = '<td>'+hours+':'+minutes+':'+created_at.getSeconds()+' '+ampm+'</td>';

					// 
					if(noDoctorsClinic.includes(patient.userClinic))
					{
						if(patient.queue_status == 'F')
						{
							returnConfirm1 = "return confirm('Do you really want to revert this patient?')";
							td11Cont = '<a href="'+baseUrl+'/queueStatus/'+patient.qid+'/F"\
						                   data-placement="top" data-toggle="tooltip" title="Click to revert"\
						                   class="btn btn-warning btn-circle " data-toggle=""\
						                   onclick="'+returnConfirm1+'">\
						                    <i class="fa fa-refresh"></i>\
						                </a>';
						}
						else
						{
							returnConfirm1 = "return confirm('Do you really want to marked this patient as done?')";
							td11Cont = '<a href="'+baseUrl+'/queueStatus/'+patient.qid+'/F"\
						                   data-placement="top" data-toggle="tooltip" title="Click to mark as done"\
						                   class="btn btn-circle disabled btn-default check'+patient.id+'"\
						                   onclick="'+returnConfirm1+'">\
						                    <i class="fa fa-check"></i>\
						                </a>';
						}
						td11 = '<td>'+td11Cont+'</td>';
					}

					// CHARGING
					if(chrgingClinics.includes(patient.userClinic))
					{

						if(request == 1)
						{
							td12Cont = '<form id="charging'+patient.id+'" action="'+baseUrl+'/scandirect" method="POST" style="display: none;">\
								            <input type="hidden" name="_token" value="'+token+'">\
								            <input type="hidden" name="barcode" value="'+patient.barcode+'">\
								        </form>';
						}else{
							td12Cont = '';
						}

						tdBtnClass = (request2 == 1) ? 'disabled' : '';

						td12 = '<td align="center" class="tdCharging">\
						            <div class="btn-group btn-undone">\
						                <a href="#" class="btn btn-info '+tdBtnClass+'"\
						                   onclick="chargeuser($(this))" data-id="'+patient.id+'"\
						                   data-placement="top" data-toggle="tooltip" title="Proceed to charging">\
						                    &#8369;\
						                </a>\
						                <button type="button" class="btn btn-primary disabled btn-charging dropdown-toggle " data-toggle="dropdown">\
						                    <span class="caret"></span>\
						                </button>\
						                <ul class="dropdown-menu dropdown-menu-right ul-id '+patient.id+'" id="'+patient.id+'" role="menu">\
						                </ul>\
						            </div>'+td12Cont+'</td></tr>';
					}

					tr_tag += td1+td2+td3+td4+td5+td6+td7+td8+td9+td10+td11+td12;

				});

			}
			else
			{
				tr_tag = '<tr>\
						    <td colspan="11" class="text-center nopatient">\
						        <div class="well">\
						            <strong class="text-danger">No patient on the list <i class="fa fa-exclamation"></i></strong>\
						        </div>\
						    </td>\
						</tr>';
			}
			self.postMessage(tr_tag);
		}
	}
	http.send('status='+statusS);

}