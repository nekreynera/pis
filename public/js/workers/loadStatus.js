

self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadStatus";
	let content = e.data[0];
	// let survey = e.data[2];
	let baseUrl = e.data[1];
	http.open("POST", url, true);
	http.setRequestHeader('X-CSRF-Token', content);

	http.onreadystatechange = () => {

		if(http.readyState === 4 && http.status === 200) {

			// let ul_tag = '';
			// let statusData = JSON.parse(http.responseText);
			// let status_O = survey == '' ? 'unassignedTabActive' : '';
			// let status_P = survey == 'P' ? 'pendingTabActive' : '';
			// let status_H = survey == 'H' ? 'pausedTabActive' : '';
			// let status_C = survey == 'C' ? 'nawcTabActive' : '';
			// let status_S = survey == 'S' ? 'servingTabActive' : '';
			// let status_F = survey == 'F' ? 'finishedTabActive' : '';
			// let status_T = survey == 'T' ? 'totalTabActive' : '';
			// unassigned = statusData.unassigned.length;
			// try
			// {

			// 	statusP = statusData[0].pending != ''? statusData[0].pending : '0';
			// 	statusH = statusData[0].paused != ''? statusData[0].paused : '0';
			// 	statusC = statusData[0].nawc != ''? statusData[0].nawc : '0';
			// 	statusS = statusData[0].serving != ''? statusData[0].serving : '0';
			// 	statusF = statusData[0].finished != ''? statusData[0].finished : '0';
			// 	countAll = statusData != '' ? Number(statusP)+Number(statusH)+Number(statusC)+Number(statusS)+Number(statusF)+Number(unassigned) : unassigned;

			// 	ul_tag = '<ul class="nav nav-pills">\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview"\
			// 			           class="unassignedTab '+status_O+'">\
			// 			            Unassigned <span class="badge">'+unassigned+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/P"\
			// 			           class="pendingTab '+status_P+'">\
			// 			            Pending <span class="badge">'+statusP+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/H"\
			// 			           class="pausedTab '+status_H+'">\
			// 			            Paused <span class="badge">'+statusH+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/C"\
			// 			           class="nawcTab '+status_C+'">\
			// 			            NAWC <span class="badge">'+statusC+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/S"\
			// 			           class="servingTab '+status_S+'">\
			// 			            Serving <span class="badge">'+statusS+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/F"\
			// 			           class="finishedTab '+status_F+'">\
			// 			            Finished <span class="badge">'+statusF+'</span>\
			// 			        </a>\
			// 			    </li>\
			// 			    <li>\
			// 			        <a href="'+baseUrl+'/overview/T"\
			// 			           class="totalTab '+status_T+'">\
			// 			            Total <span class="badge">\
			// 			            '+countAll+'\
			// 			                </span>\
			// 			        </a>\
			// 			    </li>';

			// }
			// catch(e)
			// {
			// 	if(statusData.userClinic != 10 || statusData.userClinic != 48 || statusData.userClinic != 22 || statusData.userClinic != 21)
			// 	{
			// 		ul_tag = '<ul class="nav nav-pills">\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview"\
			// 				           class="unassignedTab '+status_O+'">\
			// 				            Unassigned <span class="badge">'+unassigned+'</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/P"\
			// 				           class="pendingTab '+status_P+'">\
			// 				            Pending <span class="badge">0</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/H"\
			// 				           class="pausedTab '+status_H+'">\
			// 				            Paused <span class="badge">0</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/C"\
			// 				           class="nawcTab '+status_C+'">\
			// 				            NAWC <span class="badge">0</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/S"\
			// 				           class="servingTab '+status_S+'">\
			// 				            Serving <span class="badge">0</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/F"\
			// 				           class="finishedTab '+status_F+'">\
			// 				            Finished <span class="badge">0</span>\
			// 				        </a>\
			// 				    </li>\
			// 				    <li>\
			// 				        <a href="'+baseUrl+'/overview/T"\
			// 				           class="totalTab '+status_T+'">\
			// 				            Total <span class="badge">'+unassigned+'</span>\
			// 				        </a>\
			// 				    </li>';
			// 	}
			// }
			self.postMessage(JSON.parse(http.responseText));
		}
	}
	http.send('o');
}