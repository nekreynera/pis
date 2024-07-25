window.thumbnails = window.thumbnails || (function(global){

	"use strict";

	let that = {},
		util = global.utility,
		elems = global.pintor.els,
		shpObj = [],
		objId = 1;

	/*
	* Fetches the thumbnail images for the current category retrieved from the
	* id of the element (e.target) being clicked.
	* @method cHandler
	* @param  {object} e - Event object
	* @return {boolean} Halts the execution at the current scope.
	*/
	function cHandler(e){

		let category = e.target.id.replace("img_", "");
		that.setCurrentClinicThumbnails(category);

		return util.hunong(e);

	} // End cHandler

	that.setCurrentClinicThumbnails = function(category){

			// Initialize an XMLHttpRrquest object.
		let xhr = util.xhrObj(), 
			// Prepare data to be passed through the xhr object.
			data = JSON.stringify({"flag":"gallery_count", "category": category});
		
		// Set the current clinic.
		elems.currentClinic.value = category; 

		xhr.open("POST", baseUrl + "/misc", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.responseType = "text";
		xhr.send("post=" + data);

		xhr.onreadystatechange = function(){
			if(xhr.readyState === 4 && xhr.status === 200){

				// Convert the JSON formatted text to a JSON object.
				let files = JSON.parse(xhr.response);

				// Display the thumbnails.
				setFiles(category,files); 
			}
		}

	}

	/*
	* Fetches the image file associated with the img element (e.target)
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	function fHandler(e){

		let category = e.target.getAttribute("category"),
			filename = e.target.getAttribute("filename"),
			id = category + '|' + filename;

		setImageOnCanvas(id);	
		return util.hunong(e);		
	} 

	function objIdExists(objId){
		for(let i=0; i<that.shapeObjects.length; i+=1){
			if(that.shapeObjects[i].objId == objId){
				return true;
			}
		}
		return false;
	}

	/*
	* Description
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	function setImageOnCanvas(id){

		let img = elems[id],
			ch = elems.canvasHolder,
			x = (ch.scrollLeft + 100),
			y = (ch.scrollTop + 100),
			w = util.computedValue(img, "width"),
			h = util.computedValue(img, "height");

		if(global.handlers.isOnSelection()){
			global.handlers.blah();
		}
		
		// Generate an ordinal object id.
		let objId;
		for(let i = 1; i<=1000; i+=1){
			if(!objIdExists(i)){
				objId = i;
				break;
			}			
		}

		let obj = util.objectify(objId, "image", id, x, y, w, h);

		that.shapeObjects.push(obj);			
		global.handlers.setImageObject(obj);

	}

	/*
	* Description
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	function setFiles(cat,files){

		let galleryDisplay = global.pintor.els.galleryDisplay,
			count = files.length;

		// Clear the thumbnail images gallery.
		galleryDisplay.innerHTML = "";
		if(JSON.stringify(files).replace(/[\[\]\"\']+/g,"").length === 0){return;}

		// Clear the image container.
		global.pintor.els.imageContainer.innerHTML = "";
			
		files.forEach(function(file){
			
			let xhr = util.xhrObj(),
				data = JSON.stringify({"flag":"gallery_thumbnail_image", "category":cat,"filename":file}),
				id = ("gallery_" + file.replace(/[.](jpg|gif|png)$/g,"")),
				f = util.createEl("img", id, "clinic loader", galleryDisplay);
			
			f.setAttribute("filename", file);
			f.setAttribute("category", cat);
			f.addEventListener("click", fHandler);

			xhr.open("POST", baseUrl + "/misc", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.responseType = "text";
			xhr.send("post=" + data);

			xhr.onreadystatechange = function(){
				if(xhr.readyState === 4 && xhr.status === 200){
					
					// Set the thumbnail
					f.src = "data:image/png;base64," + xhr.response;
					f.style.backgroundColor = "rgba(255,255,255,.5)";

					// Immediately set the corresponding image in the document.
					that.setImageInDocument(cat, file);

				}
			}

		});

		setTimeout(function(e){
			let id = 'img_' + cat;
			elems.curClinic.src = document.getElementById(id).src;
			console.log('Passed here!');
		}, 500);

	};	

	/*
	* Sets the image associated with the currently selected category/clinic.
	* @method setImageInDocument
	* @param  {string} category - The currently selected category/clinic.
	* @param {string} filename - The image's filename.
	* @return {boolean} Indicates the process is successful.
	*/
	that.setImageInDocument = function(category, filename){

		let	id = category + '|' + filename,
			pos = filename.indexOf("."),
			ext = filename.substr(pos+1, filename.length - pos),
			path = category + "/" + filename,
			xhr = util.xhrObj(),
			data = JSON.stringify({"flag":"gallery_display_image", "path":path});

		xhr.open("post", baseUrl + "/misc", true);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhr.responseType = "text";
		xhr.send("post=" + data);

		xhr.onreadystatechange = function(){
			if(xhr.readyState === 4 && xhr.status === 200){
				let img = util.createEl("img", id, "img-display", elems.imageContainer);
				img.src = "data:image/" + ext + ";base64," + xhr.response;
				elems[id] = img;
			} 
		}

		return true;

	} 

	/*
	* Description
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	function setClinics(clinics){

		let thumbnails = global.pintor.els.thumbnailBox,
			count = clinics.length,
			iLeft = 4,
			counter = 0;

		var myInterval = global.setInterval(function(){
			
			let clinic = clinics[counter];

			let xhr = util.xhrObj(),
				data = JSON.stringify({"flag":"clinic_image", "filename":clinic + ".png"}),
				id = ("img_" + clinic),
				c = util.createEl("img", id, "clinic loader", thumbnails);
			
			c.addEventListener("click", cHandler);
			global.pintor.els[id] = c;

			xhr.open("POST", baseUrl + "/misc", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.responseType = "text";
			xhr.send("post=" + data);

			xhr.onreadystatechange = function(){
				if(xhr.readyState === 4 && xhr.status === 200){
					c.style.backgroundColor = "rgba(255,255,255,.5)";
					c.style.cursor = "pointer";
					c.classList.remove("loader");
					c.src = "data:image/png;base64," + xhr.response;
				}
			}
			counter += 1;

			if(counter === clinics.length){
				clearInterval(myInterval);
				console.log("Done!");
			}
		}, 800);

		// clinics.forEach(function(clinic){
			
		// 	let xhr = util.xhrObj(),
		// 		data = JSON.stringify({"flag":"clinic_image", "filename":clinic + ".png"}),
		// 		id = ("img_" + clinic),
		// 		c = util.createEl("img", id, "clinic loader", thumbnails);
			
		// 	c.addEventListener("click", cHandler);
		// 	global.pintor.els[id] = c;

		// 	xhr.open("POST", baseUrl + "/misc", true);
		// 	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// 	xhr.responseType = "text";
		// 	xhr.send("post=" + data);

		// 	xhr.onreadystatechange = function(){
		// 		if(xhr.readyState === 4 && xhr.status === 200){
		// 			c.style.backgroundColor = "rgba(255,255,255,.5)";
		// 			c.classList.remove("loader");
		// 			c.src = "data:image/png;base64," + xhr.response;
		// 		}
		// 	}

		// 	iLeft += 84;
		// 	counter += 1;

		// });




	};	

	/*
	* Description
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	that.init = function(){

		let xhr = util.xhrObj(),
			data = JSON.stringify({"flag":"clinic_count"});

		xhr.open("post", baseUrl + "/misc", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("post=" + data);

		xhr.onreadystatechange = function(){
			if(xhr.readyState === 4 && xhr.status  === 200){
				let folders = JSON.parse(xhr.responseText);
				setClinics(folders);	
			}
		}


	};

	that.shapeObjects = shpObj;

	return that;

})(window);