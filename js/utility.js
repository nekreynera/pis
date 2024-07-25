window.utility = window.utility || (function(global){

	return {
		createEl : 	function(el, id, cls, parent){
						let elem = document.createElement(el);
						elem.setAttribute("id", id);
						if(cls !== ""){
							elem.setAttribute("class", cls);
							// elem.setAttribute("unselectable", "on");
						}
						parent.appendChild(elem);
						return elem;
					},
		wrapText: 	function(ctx, text, maxWidth) {
			        	let words = text.split(' '),
			        		line = '',
			        		wrappedText = [];

			        	ctx.font = "1em Calibri";	
			        	for(let n = 0; n < words.length; n++) {
			          		let testLine = line + words[n] + ' ',
			          			metrics = ctx.measureText(testLine),
			          			testWidth = metrics.width;

			          		if (testWidth > maxWidth && n > 0) {
			            		wrappedText.push(line.replace(/[\s]$/gi, ''))
			            		line = words[n] + ' ';
			          		}else{
			            		line = testLine;
			          		}
			        	}
			        	if(line.length > 0){
			        		wrappedText.push(line.replace(/[\s]$/gi, ''));
			        	}
			        	return wrappedText;
			      	},
			      	
		loadCSS: 	function(filename){
						let fileRef = document.createElement('link');
						fileRef.rel = "stylesheet";
						fileRef.type = "text/css";
						fileRef.href = filename;
						document.getElementsByTagName("head")[0].appendChild(fileRef);
					},
		fromPxToInt: function(el, style){
			return parseInt(el.style[style].replace("px", ""), 10);
		},
		clearRect: function(ctx){
			ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
		},
		screenToClient: function(canvas, x, y){
			return 	{
						x: (x - canvas.getBoundingClientRect().left * (canvas.width/canvas.getBoundingClientRect().width)),
						y: (y - canvas.getBoundingClientRect().top * (canvas.height/canvas.getBoundingClientRect().height))
					};
		},
		rect: function(el){
			return el.getBoundingClientRect();
		},
		isActive: function(el){
			return (el.style.visibility === "visible");
		},
		activate: function(el){
			el.style.display = "block";
			el.style.visibility = "visible";
		},
		deactivate: function(el){
			el.style.display = "none";
			el.style.visibility = "hidden";
		},
		setResizeCursor: function(el, dp){
			el.style.cursor = global.constants.resizeCursors[(dp%4)] + "-resize";
		},
		hunong: function(e){
			e.stopPropagation();
			e.preventDefault();
			return false;
		},
		drawDragPoints: function(ctx, o, onBuffer = 0){
			const 	dpSize = 10;
			let 	dpHS = (dpSize / 2),
					coords =
					[
						[o.x - dpHS, o.y - dpHS],
						[o.x + (o.w / 2) - dpHS, o.y - dpHS],
						[(o.x + o.w) - dpHS, o.y - dpHS],
						[(o.x + o.w) - dpHS, o.y + ((o.h / 2) - dpHS)],
						[(o.x + o.w) - dpHS, (o.y + o.h) - dpHS],
						[o.x + ((o.w / 2) - dpHS), (o.y + o.h) - dpHS],
						[o.x - dpHS, (o.y + o.h) - dpHS],
						[o.x - dpHS, o.y + ((o.h/2) - dpHS)]	
					],
				dpCtr = 1;

			for(let i = 0; i < coords.length; i+=1){
				let rgba = "rgba(" + o.id.toString() + ", " + dpCtr.toString() + ", 0, 1)";
				ctx.strokeStyle = onBuffer === 0 ? "#000000" : rgba;
				ctx.fillStyle = onBuffer === 0 ? "#00ff00" : rgba;
				ctx.strokeRect(coords[i][0],coords[i][1], dpSize, dpSize);
				ctx.fillRect(coords[i][0],coords[i][1], dpSize, dpSize);
				dpCtr += 1;
			}
		},
		drawBufferImage : function(ctx, o){
			let img = global.pintor.els[o.img];
			ctx.save();
			ctx.fillStyle = "rgba(" + o.id.toString() + ", 9, 10, 1)";
			ctx.drawImage(img, 0, 0, o.iw, o.ih, o.x, o.y, o.w, o.h);
			ctx.globalCompositeOperation = "source-in";
			ctx.fillRect(o.x, o.y, o.w, o.h);
			ctx.restore();
		},
		drawSelectionRect: function(ctx, o){
			ctx.setLineDash([2, 4]);
			ctx.setLineDashOffset = 0;
			ctx.strokeRect(o.x, o.y, o.w, o.h);
		},
		isTransparent: function(p){
			return ((p/255) === 0); 
		},
		isResizePoint: function(r){
			return ((r >= 1) && (r <= 8));
		},
		isObject: function(g, b){
			return ((g > 8) && (b === 10));
		},
		isHit: function(a, r){
			return ((a === 255) && (r > 0));
		},
		objectify: function(objCtr, objType, id, x, y, w, h){
			return {
				"objId": objCtr,
				"objType": objType,
				"imgId": id,
				"location": {
								"left": x,
								"top": y
							},
				"size":  	{	
								"original": {
									"width": w,
									"height": h
								},
								"current":{
									"width": w,
									"height": h
								}
							}
			};
		},
		simplifyObj: function(curObj){
			return{
				id: curObj.objId,
				type: curObj.objType,
				img: curObj.imgId,
				x: parseInt(curObj.location.left, 10),
				y: parseInt(curObj.location.top, 10),
				w: curObj.size.current.width,
				h: curObj.size.current.height,
				iw: curObj.size.original.width,
				ih: curObj.size.original.height
			};
		},
		dragPoint: function(o, r, x, y){
			let ndp = 	[	[],
							[x, y, o.w+(o.x-x), o.h+(o.y-y)],
							[o.x, y, o.w, o.h+(o.y-y)],
							[o.x, y, (x-o.x), o.h+(o.y-y)],
							[o.x, o.y, x-o.x, o.h],
							[o.x, o.y, x-o.x, y-o.y],
							[o.x, o.y, o.w, y-o.y],
							[x, o.y, o.w+(o.x-x), y-o.y],
							[x, o.y, o.w+(o.x-x), o.h]
						];

			return 	{	
						x: ndp[r][0],
						y: ndp[r][1],
						w: ndp[r][2],
						h: ndp[r][3]
					};
		},
		currentObject: function(objId){
			let shpObjs = window.thumbnails.shapeObjects,
				retObj;
			shpObjs.forEach(function(obj){
				if(obj.objId === objId){
					retObj = obj;
				}
			});
			return retObj;
		},
		setMoveCursor: function(el){
			el.style.cursor = "move";
		},
		setDefaultCursor: function(el){
			el.style.cursor = "default";
		},
		setObjectCursor: function(el){
			el.style.cursor = "crosshair";
		},
		pixel: function(ctx, x, y){
			let p = ctx.getImageData(x, y, 1, 1),
				data = p.data;
			return {
				r: data[0],
				g: data[1],
				b: data[2],
				a: data[3]
			};
		},
		computedValue : function(el, prop){
			return parseInt(global.getComputedStyle(el, null).getPropertyValue(prop).replace("px",""), 10);
		},
		getTitles: function(){

			// Compose a selector for all the toolbox items.
			let selector = ""; 
			global.constants.toolboxItems.forEach(function(tb){
				selector += "[id^='" + tb.toLowerCase() + "'],";
			});	
			// Remove the last comma character.
			selector = selector.substring(selector.length-1, 0);

			// Set the 'title' attribute of all the div elements contained in the global.pintor.els.toolbox element.
			let els = this.arrifyNodeList(selector);
			els.forEach(function(el){
				el.setAttribute("title", el.id);
			});
		},
		arrifyNodeList: function(selector){
			return Array.prototype.slice.call(document.querySelectorAll(selector));
		},
		toRadians: function(deg){
			return (Math.PI/180) * deg;
		},
		toDegrees: function(rad){
			return (180/Math.PI) * rad;
		},
		getColorIndex: function(){
			return parseInt(global.toolbox.options.current("colors").replace(/\_/gi, ''), 10);
		},
		newNumArray: function(size){
			let arr = [];
			for(let i = 0; i<size; i+=1){
				arr[i] = i + 1;
			}
			return	 arr;
		},
		getEndPoint: function(radius, degAngle){
			let point = {},
				radAngle = this.toRadians(360-degAngle);

			point.x = radius * Math.cos(radAngle);
			point.y = radius * Math.sin(radAngle);

			return point;

		}, 
		xhrObj: function(){
					let xhr;
					if(global.XMLHttpRequest || global.ActiveXObject){
						if(global.ActiveXObject){
							try{
								xhr = new global.ActiveXObject("Msxml2.XMLHTTP");
							}catch(exception){
								xhr = new global.ActiveXObject("Microsoft.XMLHTTP");
							}

						}else{
							xhr = new global.XMLHttpRequest();
						}
					}else{
						xhr = "Browser does not support XMLHttpRequest Object.";
					}
					return xhr;
				}

	};	// end return
		
})(window);