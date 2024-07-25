
self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadDoctors";
	let baseUrl = e.data[1];
	http.open("POST", url, true);
	content = e.data[0];
	http.setRequestHeader('X-CSRF-Token', content);

	http.onreadystatechange = () => {

		if(http.readyState === 4 && http.status === 200) {

			let names = '';
			let badgeServe = 0, badgePaused = 0, badgeFinished = 0,
			badgeUnassigned = 0, badgeCancel = 0, badgePending = 0,
			badgeTotal = 0, activeDoctor = false, status = '',
			btn_sty = '', countSer = '', countPen = '', countCan = '',
			countFin = '', countPau = '';
			tr_tag = '';
			let doctors = JSON.parse(http.responseText);

			if(doctors.length > 0)
			{
				doctors.forEach( (doctor) => {

					if(doctors.serving)
					{
						badgeServe += doctor.serving;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}
					if(doctors.pending)
					{
						badgePending += doctor.pending;
					}

					if(doctor.activeStat || doctor.serving || doctor.pending || doctor.finished || doctor.paused || doctor.cancel)
					{

						activeDoctor = true;
						status = doctor.activeStat ? 'online' : 'offline';
						btn_ser = doctor.serving ? 'btn-success' : 'btn-default';
						btn_pen = doctor.pending ? 'btn-warning' : 'btn-default';
						btn_can = doctor.cancel ? 'btn-danger' : 'btn-default';
						btn_fin = doctor.finished ? 'btn-info' : 'btn-default';
						btn_pau = doctor.paused ? '' : 'btn-default';
						btn_sty = doctor.paused ? 'style="background-color:saddlebrown;color:#fff"' : '';
						countSer = doctor.serving ? doctor.serving : '0';
						countPen = doctor.pending ? doctor.pending : '0';
						countCan = doctor.cancel ? doctor.cancel : '0';
						countFin = doctor.finished ? doctor.finished : '0';
						countPau = doctor.paused ? doctor.paused : '0';
						tr_tag += '<tr>\
										<td>\
											<div class="'+status+'"></div> <span class="text-uppercase">Dr. '+doctor.name+'</span>\
										</td>\
				                        <td>\
				                            <a href="'+baseUrl+'/status/'+doctor.id+'/S"\
				                               class="btn btn-circle '+btn_ser+'">\
				                                '+countSer+'\
				                            </a>\
				                        </td>\
				                        <td>\
				                            <a href="'+baseUrl+'/status/'+doctor.id+'/P"\
				                               class="btn btn-circle '+btn_pen+'">\
				                                '+countPen+' \
				                            </a>\
				                        </td>\
				                        <td>\
				                            <a href="'+baseUrl+'/status/'+doctor.id+'/C"\
				                               class="btn btn-circle '+btn_can+'">\
				                                '+countCan+'\
				                            </a>\
				                        </td>\
				                        <td>\
				                            <a href="'+baseUrl+'/status/'+doctor.id+'/F"\
				                               class="btn btn-circle '+btn_fin+'">\
				                                '+countFin+'\
				                            </a>\
				                        </td>\
				                        <td>\
				                            <a href="'+baseUrl+'/status/'+doctor.id+'/H"\
				                               class="btn btn-circle '+btn_pau+'" '+btn_sty+'>\
				                                '+countPau+'\
				                            </a>\
				                        </td>\
									</tr>';
					}

				});

				if(! activeDoctor)
				{
					tr_tag = '<tr>\
				                    <td colspan="6">\
				                        <div class="well text-danger text-center">\
				                            <strong>No Active Doctors <i class="fa fa-stethoscope"></i></strong>\
				                        </div>\
				                    </td>\
				                </tr>';
				}

			}
			else
			{
				tr_tag = '<tr class="text-danger text-center">\
			                    <td colspan="5">\
			                        NO DOCTORS FOUND <i class="fa fa-exclamation"></i>\
			                    </td>\
			                </tr>';
			}
			self.postMessage(tr_tag);
		}
	}
	http.send('o');

}