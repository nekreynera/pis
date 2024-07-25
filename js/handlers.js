window.handlers = window.handlers || (function(global){

	"use strict";

	// Private variables.
	var elems = global.pintor.els, 
		util = global.utility,
		timer, timer2,
		mousePressed = false,
		onObject = false,
		onSelection = false,
		selection = [],
		resized = false,
		resizer = -1,
		cCtx, cbCtx, sCtx, sbCtx, 
		offsetX, offsetY,
		el = {},
		contexts = {},
		curObj;
	
	/*
	* Updates the currently manipulated image object.
	* @namespace js.handlers.js
	* @method setScratch
	* @param  {int} x - The left position of the currently selected object.
	* @param {int} y - The top position of the currently selected object.
	* @param {int} w - The width of the currently selected object.
	* @param {int} h - The height of the currently selected object.
	* @return {boolean} - Halts the execution.
	*/
	function setScratch(x, y, w, h){

		curObj.location.left = x;
		curObj.location.top = y;
		curObj.size.current.width = w;
		curObj.size.current.height = h;

		drawObjOnScratch(util.simplifyObj(curObj));

		return false;
		
	} // End setScratch	

	// ______________________________________________________________________________________________________________________________________________ 
	/*
	* The event handler for the resize event of the global window object.
	* @method windowResize
	* @param  {object} e - Event object
	* @return {ReturnType} ReturnDescription
	*/
	function windowResize(e){
		timer = setTimeout(function(e){
			adjustUI();			
			clearTimeout(timer);
			timer2 = setTimeout(function(e){
				adjustUI();
				clearTimeout(timer2);
			}, 50, true);
		}, 50, true);
		util.hunong(e);
	} // End windowResize

	// ______________________________________________________________________________________________________________________________________________ 
	/*
	* Adjusts the positions of the visual elemets within the viewport.
	* @method adjustUI
	* @return {boolean} Halts the execution of the current scope.
	*/
	function adjustUI(){

		let vw = document.documentElement.clientWidth,
			vh = document.documentElement.clientHeight;
		
		elems.board.style.height = (vh - (elems.ribbon.offsetHeight + elems.statusBox.offsetHeight + 16)).toString() + "px";
		elems.gallery.style.left = (vw - elems.gallery.offsetWidth - 8).toString() + "px"; 
		elems.gallery.style.height = elems.board.style.height;
		elems.galleryDisplay.style.height = (parseInt(elems.gallery.style.height.replace("px",""), 10) - global.utility.computedValue(elems.galleryHeader, "height") - 5).toString() + "px";
		elems.canvasHolder.style.height = elems.board.style.height;	
		elems.canvasHolder.style.width = (vw - elems.gallery.offsetWidth - 16).toString() + "px";

		return false;
		
	} // adjustUI

	// ______________________________________________________________________________________________________________________________________________
	/*
	* The event handler for the mouse move event of the main drawing canvas.
	* @method canvasMouseMove
	* @param  {object} e - Event object
	* @return {boolean} Halts the execution of the current scope.
	*/
	function canvasMouseMove(e){

		if(global.toolbox.options.tool() === global.toolbox.options.toolText.DEFAULT){

			let stc = util.screenToClient(e.target, e.clientX, e.clientY),
				p = util.pixel(cbCtx, stc.x, stc.y);

			if(((p.a/255) > 0) && (p.r>0)){
				if((p.g > 8) && (p.b === 10)){
					onObject = true;
					util.setObjectCursor(e.target);
					elems.sbd2SpanText.innerHTML = "Object #: " + p.r.toString();
				}
			}else{
				onObject = false;
				// util.setDefaultCursor(e.target);
				elems.sbd1SpanText.innerHTML = "";
				elems.sbd2SpanText.innerHTML = "";
			}

		}	

		return util.hunong(e);

	} // End canvasMouseMove

	// ______________________________________________________________________________________________________________________________________________ 
	function canvasMouseClick(e){

		let stc = util.screenToClient(cbCtx.canvas, e.clientX, e.clientY),
			p = util.pixel(cbCtx, stc.x, stc.y);

		if(util.isObject(p.g, p.b)){
			
			if(global.toolbox.options.tool() === global.toolbox.options.toolText.LABEL){
				global.constants.textEntryCon(sCtx, stc);

			}else if(global.toolbox.options.tool() === global.toolbox.options.toolText.DEFAULT){
				onObject = true;
				onSelection = true;

				curObj = util.currentObject(p.r)

				let o = util.simplifyObj(curObj);

				offsetX = stc.x - o.x;
				offsetY = stc.y - o.y;

				drawObjOnScratch(o);
				drawObjOnScratchBuffer(o);
				selection.push(o);

				redrawCanvas(o.id);
				util.activate(elems.scratch);
				util.setMoveCursor(elems.scratch);	
			} // End -- if(global.toolbox.options.tools)

		} // End -- if(util.isObject(p.g, p.b))

		return util.hunong(e);

	} // End canvasMouseClick

	// ______________________________________________________________________________________________________________________________________________ 
	function drawObjOnScratch(o){
		let img = elems[o.img];
		util.clearRect(sCtx);
		sCtx.drawImage(img, 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);
		util.drawSelectionRect(sCtx, o);
		util.drawDragPoints(sCtx, o);
	} // End drawObjOnScratch

	// ______________________________________________________________________________________________________________________________________________ 
	function drawObjOnScratchBuffer(o){
		util.clearRect(sbCtx)
		util.drawBufferImage(sbCtx, o);
		util.drawDragPoints(sbCtx, o, 1);
	} // End drawObjOnScratchBuffer

	// ______________________________________________________________________________________________________________________________________________ 
	function removeSelectedObj(objId){
		let shpObjs = global.thumbnails.shapeObjects;

		shpObjs.forEach(function(obj){
			if(obj.objId === objId){
				let objIndex = shpObjs.indexOf(obj),
					selIndex = selection.indexOf(obj);
				shpObjs.splice(objIndex, 1);
				selection.splice(selIndex, 1);
			}
		});

		util.deactivate(elems.scratch);
		redrawCanvas(-1);

	} // End removeSelectedObj	

	// ______________________________________________________________________________________________________________________________________________ 
	function redrawCanvas(objId){
		let shpObjs = global.thumbnails.shapeObjects,
			c = util.createEl("canvas", "", "", elems.canvasHolder);

		util.deactivate(c);
		util.clearRect(cCtx);
		util.clearRect(cbCtx);
		
		shpObjs.forEach(function(obj){
			if(obj.objId !== objId){
				
				let o = util.simplifyObj(obj),
					ctx = c.getContext("2d");

				c.width = o.w;
				c.height = o.h;

				cCtx.drawImage(elems[o.img], 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);	
				
				util.clearRect(ctx);
				ctx.drawImage(cCtx.canvas, o.x, o.y, o.w, o.h, 0, 0, o.w, o.h);
				ctx.globalCompositeOperation = "source-in";
				ctx.fillStyle = "rgba(" + o.id.toString() + ", 9, 10, 1)";
				ctx.fillRect(0, 0, o.w, o.h);

				cbCtx.drawImage(ctx.canvas, 0, 0, o.w, o.h, o.x, o.y, o.w, o.h);

			}
		});
		elems.canvasHolder.removeChild(c);
	} // End redrawCanvas


	// ______________________________________________________________________________________________________________________________________________ 
	function canvasMouseUp(e){
		e.preventDefault();
		e.stopPropagation();
	} // End canvasMouseUp

	// ______________________________________________________________________________________________________________________________________________ 
	function scratchMouseClick(e){
		e.preventDefault();
		e.stopPropagation();

		let stc = util.screenToClient(e.target, e.clientX, e.clientY),
			p = util.pixel(sbCtx, stc.x, stc.y);

		if(util.isTransparent(p.a) && !resized){

			let o = util.simplifyObj(curObj);

			cCtx.drawImage(elems[o.img], 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);	
			util.deactivate(e.target);

			// Draw the image from scratch buffer canvas buffer tracker.
			cbCtx.drawImage(elems.scratchBuffer, o.x, o.y, o.w, o.h, o.x, o.y, o.w, o.h);
			onSelection = false;

			// Remove the current selection from the selection array.
			let ndx = selection.indexOf(o);
			selection.splice(ndx, 1);

			// Remove the text entry container if it exists.
			let pWin = document.getElementById("text-entry-container");
			if(pWin !== null){
				pWin.parentNode.removeChild(pWin);
			}
		
		}
		if(resized){
			resized = false;
		}

	} // End scratchMouseClick

	// ______________________________________________________________________________________________________________________________________________ 
	function scratchMouseDown(e){
		e.preventDefault();
		e.stopPropagation();

		mousePressed = true;
		let stc = util.screenToClient(e.target, e.clientX, e.clientY);

		offsetX = stc.x - curObj.location.left;
		offsetY = stc.y - curObj.location.top;

		util.clearRect(sbCtx);

	} // End scratchMouseDown

	// ______________________________________________________________________________________________________________________________________________ 
	function scratchMouseUp(e){
		
		e.preventDefault();
		e.stopPropagation();
		
		drawObjOnScratchBuffer(util.simplifyObj(curObj));

		resizer = -1;
		onObject = false;
		mousePressed = false;

	} // End scratchMouseUp


	// ______________________________________________________________________________________________________________________________________________ 
	function scratchMouseMove(e){

		let stc = util.screenToClient(e.target, e.clientX, e.clientY),
			x = stc.x,
			y = stc.y;

		if(mousePressed){
			let o = util.simplifyObj(curObj);

			if(util.isResizePoint(resizer)){
				let dp = util.dragPoint(o, resizer, x, y);
				setScratch(dp.x, dp.y, dp.w, dp.h);	
				resized = true;
			}

			if(onObject){
				setScratch( x - offsetX, y - offsetY, o.w, o.h);	
			}

		}else{

			if(global.toolbox.options.tool() === global.toolbox.options.toolText.LABEL){
				return;
			}

			let p = util.pixel(sbCtx, x, y);
			resizer = p.g;

			util.setDefaultCursor(e.target);
			elems.sbMove.innerHTML = "(r: " + p.r.toString() + ", g: " + p.g.toString() + ", b: " + p.b.toString() + ", a: " + p.a.toString() + ")";

			if(util.isHit(p.a, p.r)){	
				if(util.isResizePoint(p.g)){
					elems.sbd1SpanText.innerHTML = p.g.toString();
					util.setResizeCursor(e.target, p.g);
				}else if(util.isObject(p.g, p.b)){
					onObject = true;
					elems.sbd2SpanText.innerHTML = "Object #: " + p.r.toString();
					util.setMoveCursor(e.target);
				}
			}else{
				onObject = false;
				elems.sbd1SpanText.innerHTML = "";
				elems.sbd2SpanText.innerHTML = "";
				util.setDefaultCursor(e.target);
			}	

		}

		return util.hunong(e);

	} // End scratchMouseMove

	// ______________________________________________________________________________________________________________________________________________ 
	function scratchKeyUp(e) {
		e.stopPropagation();
		e.preventDefault();
		
		switch(e.key){
			case 'Delete': 
				let o = curObj;
				if(selection.length > 0 && onSelection === true){
					removeSelectedObj(o.objId);	
				}
				
				break;

			default:
				break;
		}

	} // End scratchKeyUp

	// ______________________________________________________________________________________________________________________________________________ 
	
	function getImageTemplate(){

		let xhr = util.xhrObj(),
			clinic = elems.currentClinic.value.replace('cat_', ''),
			data = JSON.stringify({"flag":"get_template", "clinic": clinic});

		xhr.open("post", baseUrl + "/misc", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("post=" + data);

		xhr.onreadystatechange = function(){
			if(xhr.readyState === 4 && xhr.status  === 200){
				let templates = JSON.parse(xhr.response);
				displayFetchedTemplate(templates);
			}
		}

	}

	// ______________________________________________________________________________________________________________________________________________ 

	function getCurrentClinic(){

		let xhr = util.xhrObj(),
			data = JSON.stringify({"flag":"get_clinic"});

		xhr.open("post", baseUrl + "/misc", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("post=" + data);

		xhr.onreadystatechange = function(){
			if(xhr.readyState === 4 && xhr.status  === 200){
				// Activate the current clinic.
				let category = 'cat_' + xhr.response;
				global.thumbnails.setCurrentClinicThumbnails(category);
				setTimeout(getImageTemplate, 1000);
			}
		}

	}

	// ______________________________________________________________________________________________________________________________________________ 

	/*
	* Description
	* @method MethodName
	* @param  {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @param {ParamType} ParamName - ParamDescription
	* @return {ReturnType} ReturnDescription
	*/
	function displayFetchedTemplate(template){

		let objKeys = Object.keys(template);

		// Clear objects buffer.
		global.thumbnails.shapeObjects.length = 0;

		// Add the objects to the objects buffer.
		objKeys.forEach(function(key){
			let object = template[key];
			global.thumbnails.shapeObjects.push(object);
		});

		// Load the object into the page's document.
		global.thumbnails.shapeObjects.forEach(function(obj){
			let imgId = obj.imgId.split('|'),
				category = imgId[0],
				filename = imgId[1];
			global.thumbnails.setImageInDocument(category, filename);
		});

		// Wait for 10 seconds to render the individual objects in the image display.
		setTimeout(function(e){

			let c = util.createEl("canvas", "", "", elems.canvasHolder);
		
			util.deactivate(c);
			util.clearRect(cCtx);
			util.clearRect(cbCtx);

			global.thumbnails.shapeObjects.forEach(function(obj){
			
				let o = util.simplifyObj(obj),
					ctx = c.getContext("2d");

				c.width = o.w;
				c.height = o.h;

				let img = document.getElementById(obj.imgId); 

				cCtx.drawImage(img, 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);
				util.clearRect(ctx);
				ctx.drawImage(cCtx.canvas, o.x, o.y, o.w, o.h, 0, 0, o.w, o.h);
				ctx.globalCompositeOperation = "source-in";
				ctx.fillStyle = "rgba(" + o.id.toString() + ", 9, 10, 1)";
				ctx.fillRect(0, 0, o.w, o.h);
				cbCtx.drawImage(ctx.canvas, 0, 0, o.w, o.h, o.x, o.y, o.w, o.h);

				curObj = obj;

			});

			elems.canvasHolder.removeChild(c);

		}, 5000);

	}

	// End Private functions.

	// Start return object's routine implementations.
	// ------------------------------------------------------------------------------------------------------------------------------
	/*
	* The return object of this object.
	* @method N/A
	* @return {object} Routines container for this object.
	*/
	return {
		init: function(){

			let tbItems = global.constants.toolboxItems;
			
			window.addEventListener("resize", windowResize, false);
			sbCtx = elems.scratchBuffer.getContext("2d");
			sCtx = elems.scratch.getContext("2d");
			cCtx = elems.canvas.getContext("2d");
			cbCtx = elems.canvasBuffer.getContext("2d");

			contexts.sbCtx = sbCtx;
			contexts.sCtx = sCtx;
			contexts.cCtx = cCtx;
			contexts.cbCtx = cbCtx;

			elems.scratch.addEventListener("mousemove", scratchMouseMove, false);
			elems.scratch.addEventListener("mousedown", scratchMouseDown, false);
			elems.scratch.addEventListener("mouseup", scratchMouseUp, false);
			elems.scratch.addEventListener("click", scratchMouseClick, false);
			
			document.addEventListener("keyup", scratchKeyUp, false);

			elems.canvas.addEventListener("mousemove", canvasMouseMove, false);
			elems.canvas.addEventListener("mouseup", canvasMouseUp, false);
			elems.canvas.addEventListener("click", canvasMouseClick, false);

			elems.scratchBuffer.addEventListener("mousemove", scratchMouseMove, false);

			elems.canvasHolder.addEventListener("scroll", function(e){
				elems.fileMenu.style.top = (e.target.scrollTop + 10).toString() + "px"; 
			}, false);
			
			elems.overlay.addEventListener("click", function(e){
				
				util.deactivate(elems.clipboard);
				util.deactivate(elems.image);
				util.deactivate(elems.tools);
				util.deactivate(elems.brushes);
				util.deactivate(elems.shapes);
				util.deactivate(elems.sizes);
				util.deactivate(elems.colors);
				util.deactivate(elems.thumbnailBox)

				util.deactivate(elems.overlay);

				return false;

			}, false);
			
			// Merge edits
			// -------------------
			let sLeftA = 215,
				elTopA = 64;
			// -------------------

			let tbLefts = {},
				sLeft = 8 + sLeftA;

			for(let i=0; i<tbItems.length;i+=1){
				tbLefts[tbItems[i].toLowerCase()] = sLeft.toString() + "px";
				sLeft += 54;
			}

			// Toolbox item down arrows.
			let arrs = util.arrifyNodeList("div[id$='-darr']");
			arrs.forEach(function(arr){
				arr.addEventListener("click", function(e){
					
					let tbArr = e.target.id.replace(/(tb\-|-darr)/gi, '').toLowerCase(),
						elTop = (util.computedValue(elems.ribbon, "height") - 2 + elTopA).toString() + "px";

					util.activate(elems.overlay);
					util.activate(elems[tbArr]);
					elems[tbArr].style.left = tbLefts[tbArr];
					elems[tbArr].style.top = elTop;		

					return false;

				});
			});

			let tbArr = global.constants.toolboxItems.splice(2, 5);
			tbArr.forEach(function(tb){
				tb = tb.toLowerCase();
				let itemArr = util.arrifyNodeList("div[id^='" + tb + "-clickable-'], img[id^='" + tb + "-clickable-']");
				itemArr.forEach(function(item){
					item.addEventListener('click', function(e){
						
						let isActive = item.getAttribute("active") === "1" ? true : false;
						if(!isActive){
							let itemName = e.target.id.replace(tb + '-clickable-', '');

							elems.canvas.style.cursor = "url('./img/system/" + tb + "/" + itemName + ".png') 2 16, auto";
							// elems.canvas.setAttribute("cursor", "url('./img/system/" + tb + "/" + itemName + ".png')");

							global.toolbox.resetSelection(tb, false);
							global.toolbox[tb][itemName] = true;
							if(tb === 'colors'){
								let colorName = e.target.id.replace(tb + '-clickable-', ''),
									colorDisplay = document.getElementById(tb + '-clickable-selector-color1-span');

								colorDisplay.style.backgroundColor = "rgba(" + JSON.stringify(global.toolbox.options.colors[parseInt(colorName, 10)]).replace(/[\"rgba\:\{\}]/gi,'') + ")";
							}else{
								global.toolbox.clearSelection(itemArr);
								global.toolbox.activateItem(e.target);
							}
						}

						return false;

					});
				});
			});


			// TEMPORARY
			// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			elems.fileSave.addEventListener('click', function(e){

				let tmlObjects = {};

				thumbnails.shapeObjects.forEach(function(obj){
					tmlObjects[obj.objId] = obj;
				});

				let strObjects = JSON.stringify(tmlObjects);

				let xhr = util.xhrObj(),
					clinic = elems.currentClinic.value.replace('cat_', ''),
					data = JSON.stringify({"flag":"save_template", "clinic": clinic, "template":strObjects});

				xhr.open("post", baseUrl + "/misc", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("post=" + data);

				xhr.onreadystatechange = function(){
					if(xhr.readyState === 4 && xhr.status  === 200){
						if(xhr.response == 1){
							alert('Image template successfully saved!');
						}else{
							alert(xhr.response);
						}
					}
				}

				return false;

			}, false);

			elems.fileOpen.addEventListener('click', function(e){

				let xhr = util.xhrObj(),
					data = JSON.stringify({"flag":"patient_id"});

				xhr.open("post", baseUrl + "/misc", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("post=" + data);

				xhr.onreadystatechange = function(){
					if(xhr.readyState === 4 && xhr.status  === 200){
						console.dir(JSON.parse(xhr.response));
					}
				}

				return util.hunong(e);

			}, false);


			getCurrentClinic();
			// getImageTemplate();

			// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			elems.clinicsLoader.addEventListener('click', function(e){
				util.activate(elems.overlay);
				util.activate(elems.thumbnailBox);
				return util.hunong(e);
			}, false);





		}, // End init

		setImageObject: function(obj){
			let o = util.simplifyObj(obj);
			curObj = obj;
			onSelection = true;
			drawObjOnScratch(o);
			drawObjOnScratchBuffer(o);
			util.activate(elems.scratch);
			selection.push(o);
			redrawCanvas(o.id);

		}, // End setImageObject

		blah: function(){
			let o = util.simplifyObj(curObj);

			cCtx.drawImage(elems[o.img], 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);	
			util.deactivate(elems.scratch);

			// Draw the canvas buffer tracker.
			cbCtx.drawImage(elems.scratchBuffer, o.x, o.y, o.w, o.h, o.x, o.y, o.w, o.h);
			onSelection = false;
		}, // End blah.

		isOnSelection: function(){
			return onSelection;
		},
		context: function(){
			return contexts;
		}

	};

})(window);