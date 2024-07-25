

self.onmessage = (e) => {

	let http = new XMLHttpRequest();

	let url = e.data[1]+"/loadAllUndonePatients";
	let metaTag = e.data[0];
	let baseUrl = e.data[1];
	let IDs = e.data[2];
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader('X-CSRF-Token', metaTag);

	http.onreadystatechange = () => {
		if(http.readyState === 4 && http.status === 200) {
			self.postMessage(JSON.parse(http.responseText));
		}
	}
	http.send('ids='+IDs);
}