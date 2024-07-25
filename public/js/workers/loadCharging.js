

self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadCharging";
	let metaTag = e.data[0];
	let baseUrl = e.data[1];
	let ids = e.data[2];
	let queueStat = e.data[3];
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader('X-CSRF-Token', metaTag);

	http.onreadystatechange = () => {
		if(http.readyState === 4 && http.status === 200) {
			let charging = JSON.parse(http.responseText);
			self.postMessage(charging);
		}
	}
	http.send('ids='+ids+'&queueStat='+queueStat);
}