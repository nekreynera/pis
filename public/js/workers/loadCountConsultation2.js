

self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadCountConsultation";
	let content = e.data[0];
	let baseUrl = e.data[1];
	let ids = new Array();
	ids = e.data[2];
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader('X-CSRF-Token', content);

	http.onreadystatechange = () => {
		if(http.readyState === 4 && http.status === 200) {
			let countConsultation = JSON.parse(http.responseText);
			self.postMessage(countConsultation);
		}
	}
	http.send('ids='+ids);
}