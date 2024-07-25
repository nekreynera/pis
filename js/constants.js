window.constants = window.constants  || (function(global){

	// let util = global.utility;

	function createTempCanvas(stc){
		let tC = global.utility.createEl("canvas", "tC", "", document.getElementsByTagName("body")[0]),
					tCCtx = tC.getContext("2d");

		tC.setAttribute("width", "40");
		tC.setAttribute("height", "40");
		tC.style.display = "none";
		
		tCCtx.drawImage(global.pintor.els.canvas, stc.x-20, stc.y-20, 40, 40, 0, 0, 40, 40);
		tCCtx.fillStyle = 'rgba(255,255,255,255)';
		tCCtx.globalCompositeOperation = 'destination-in';
		tCCtx.beginPath();
		tCCtx.arc(20, 20, 20, 0, 2 * Math.PI, true);
		tCCtx.closePath();
		tCCtx.fill();
		return tC;
	};

	function createButton(container, id, stc){
		
		let util = global.utility,
			btn = util.createEl("div", id, "text-entry-button", container);
		
		// Add event listener for the mouse click event.
		btn.addEventListener('click', function(e){
			let btnType = btn.id.replace("text-entry-button-", ""), // Remove the common button id prefix to get the type of button being passed.
				cCtx = global.pintor.els.canvas.getContext("2d"); // Get the context of the drawing target canvas.
				cCtx.font = "1em Calibri";	// Set the font.

			if(btnType === "ok"){

				let te = document.getElementById("text-entry"), // The text area element that accepts the part's label entry.
					txt = te.value, // Label entry.
					maxWidth = util.computedValue(te, "width") - 16, // Maximum text width.
					wrappedText = util.wrapText(cCtx, txt, maxWidth), // Arrified text.
					lineHeight = 20, // Text height per line.
					teHeight = (lineHeight * wrappedText.length) + 5, // Height of the text containing rectangle.
					teWidth = ((wrappedText.length > 1) ? maxWidth : ctx.measureText(wrappedText[0]).width) + 16, // Width of the text containing rectangle.
					teX = 0, // Left position of the containing rectangle.
					teY = 0; // Top position of the containing rectangle.

					let rect = util.rect(container), // The bounding rectangle of the text container.
						cLeft = util.fromPxToInt(container, "left") + (rect.width/2), // Left position of the text area container.
						cTop = util.fromPxToInt(container, "top") + (rect.height/2); // Top position of the text area container.

					// Draw a circle on the clicked area of the current image object.
					global.drawing.drawArc(cCtx, stc, 20, 0, 360);
					
					// Remove the temporary clipping canvas if it exists.
					let pTC = document.getElementById("tC");
					if(pTC !== null){
						pTC.parentNode.removeChild(pTC);
					}

					// Prepare the clipped stamp image. This must comes first
					// before the label line is drawn on the canvas, otherwise 
					// the line inside the circle will also be included in the clip.
					let tC = createTempCanvas(stc);

					// Draw the label line connector.
					global.drawing.drawLine(cCtx, {'stc':stc, 'left':cLeft, 'top':cTop});

					// Draw a rounded clip over the inner part of the circle.
					cCtx.drawImage(tC, 0, 0, 40, 40, stc.x-19, stc.y-19, 38, 38);

					// Set the position of the label.
					teX = cLeft - (teWidth/2);
					teY = cTop - (teHeight/2);

					// Draw the rectangle.
					global.drawing.drawRect(cCtx, teX, teY, teWidth, teHeight);

					// Initialize the text line position.
					let x = teX + 8,
						y = teY + 16;

					// Render the array of text line by line.	
					cCtx.font = "1em Calibri";
					for(let i=0; i<wrappedText.length; i+=1){
						cCtx.fillText(wrappedText[i], x, y);
						y += lineHeight;
					}	

					// Hide the scratch canvas.
					let sCtx = global.pintor.els.scratch.getContext("2d");
					util.clearRect(sCtx);
					util.deactivate(global.pintor.els.scratch);
					container.parentNode.removeChild(container);

			}else{
				let sCtx = global.pintor.els.scratch.getContext("2d");
				global.utility.clearRect(sCtx);
				global.utility.deactivate(global.pintor.els.scratch);
				container.parentNode.removeChild(container);
			}
		}, false);
	}

	return {
		toolboxItems : ["ClipBoard","Image","Tools","Brushes","Shapes","Sizes","Colors"],
		resizeCursors : ["ew","nwse","ns","nesw"],
		shapeImages: ["line","curve","oval","rectangle","rounded_rectangle","polygon","triangle","right_triangle","diamond","pentagon","hexagon","right_arrow","left_arrow","up_arrow","down_arrow","four_point_star","five_point_star","six_point_star","rounded_rectangular_callout","oval_callout","cloud_callout","heart","lightning"],
		toolsImages: ["default", "pencil", "fill", "text", "eraser", "picker", "magnifier", "label"],
		brushImages: ["brush", "calligraphy_brush1", "calligraphy_brush2", "air_brush", "oil_brush", "crayon", "marker", "natural_pencil", "water_color_brush"],
		clipboardElements: 	'<div id="clipboard-paste">' +
							'<div id="clipboard-paste-clickable-img" title="clipboard-paste-clickable-img"></div>' +
							'<div id="clipboard-paste-clickable-text-arrow" title="clipboard-paste-clickable-text-arrow">' +
							'<div id="clipboard-paste-clickable-text"></div>' +
							'<div id="clipboard-paste-clickable-arrow"></div>' +
							'</div>' +
							'</div>' +
							'<div id="clipboard-cut" class="clipboard-cut-copy" title="clipboard-cut">' +
							'<div id="clipboard-cut-img" class="clipboard-cut-copy-img"></div>' +
							'<div id="clipboard-cut-text" class="clipboard-cut-copy-text"></div>' +
							'</div>' +
							'<div id="clipboard-copy" class="clipboard-cut-copy" title="clipboard-copy">' +
							'<div id="clipboard-copy-img" class="clipboard-cut-copy-img"></div>' +
							'<div id="clipboard-copy-text" class="clipboard-cut-copy-text"></div>' +
							'</div>' +
							'<span id="clipboard-text">' +
							'Clipboard' +
							'</span>',

		imageElements: 		'<div id="image-select">' +
							'<div id="image-select-clickable-img"></div>' +
							'<div id="image-select-clickable-text-arrow">' +
							'<div id="image-select-clickable-text"></div>' +
							'<div id="image-select-clickable-arrow"></div>' +
							'</div>' +
							'</div>' +
							'<div id="image-crop" class="image-crop-resize-rotate">' +
							'<div id="image-crop-img" class="image-crop-resize-rotate-img"></div>' +
							'<div id="image-crop-text" class="image-crop-resize-rotate-text"></div>' +
							'</div>' +
							'<div id="image-resize" class="image-crop-resize-rotate">' +
							'<div id="image-resize-img" class="image-crop-resize-rotate-img"></div>' +
							'<div id="image-resize-text" class="image-crop-resize-rotate-text"></div>' +
							'</div>' +
							'<div id="image-rotate" class="image-crop-resize-rotate">' +
							'<div id="image-rotate-img" class="image-crop-resize-rotate-img"></div>' +
							'<div id="image-rotate-text" class="image-crop-resize-rotate-text"></div>' +
							'<div id="image-rotate-darr"></div>' +
							'</div>' +
							'<span id="image-text">' +
							'Image' +
							'</span>',
		toolsElements: 	function(){
							let imgs = this.toolsImages,
								toolsEl = document.getElementById("tools"),
								size = 20,
								sLeft = 8,
								sTop = 11;

							for(let i=0; i<imgs.length; i+=1){
								let toolId = "tools-clickable-" + imgs[i].replace(/_/gi, '-'),
									tool = global.utility.createEl("img", toolId, "tools-clickable", toolsEl);

								tool.setAttribute("src", "./img/system/tools/" + imgs[i] + ".png");
								tool.setAttribute("active", "0");
								tool.style.left = sLeft.toString() + "px";
								tool.style.top = sTop.toString() + "px";

								if(i===0){
									global.toolbox.tools[imgs[i]] = true;
									global.toolbox.activateItem(tool);
								}

								tool.addEventListener("mouseover", function(e){
									e.stopPropagation();
									e.preventDefault();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(148, 190, 234, 1)";
										e.target.style.backgroundColor = "rgba(233, 239, 246, 1)";		
									}
								}, false);

								tool.addEventListener("mouseout", function(e){
									e.preventDefault();
									e.stopPropagation();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(0,0,0,0)";
										e.target.style.backgroundColor = "rgba(0,0,0,0)";	
									}
								}, false);

								if((( i+1 ) % 3) === 0){
									sLeft = 8;
									sTop += 28;
								}else{
									sLeft += 24;
								}

							}

							global.utility.createEl("div", "tools-text", "", toolsEl);
							return false;

						}, // End toolsElements

		brushesElements:function(){
							let brsh = this.brushImages,
								brushEl = document.getElementById("brushes"),
								size = 40,
								sLeft = 2,
								sTop = 2;

							for(let i=0; i<brsh.length; i+=1){
								let brshId = "brushes-clickable-" + brsh[i].replace(/_/gi, '-'),
									brush = global.utility.createEl("img", brshId, "brushes-clickable", brushEl);

								brush.setAttribute("active", "0");
								brush.setAttribute("src", "./img/system/brushes/" + brsh[i] + ".png");
								brush.style.left = sLeft.toString() + "px";
								brush.style.top = sTop.toString() + "px";

								if(i===0){
									global.toolbox.activateItem(brush);
								}

								brush.addEventListener("mouseover", function(e){
									e.stopPropagation();
									e.preventDefault();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(148, 190, 234, 1)";
										e.target.style.backgroundColor = "rgba(233, 239, 246, 1)";		
									}
								}, false);

								brush.addEventListener("mouseout", function(e){
									e.preventDefault();
									e.stopPropagation();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(0,0,0,0)";
										e.target.style.backgroundColor = "rgba(0,0,0,0)";	
									}
								}, false);

								if((( i+1 ) % 4) === 0){
									sLeft = 2;
									sTop += 40;
								}else{
									sLeft += 40;
								}	

							}

							global.utility.createEl("div", "brushes-text", "", brushEl);	

						},
		shapesElements: function(){

							let shps = 	this.shapeImages,
								shapesEl = document.getElementById("shapes"),
								size = 20,
								sLeft = 9,
								sTop = 5;

							for(let i=0; i<shps.length;i+=1){
								let shpId = "shapes-clickable-" + shps[i].replace(/_/g,'-'),
									shp = global.utility.createEl("img", shpId, "shapes-clickable", shapesEl);
								
								shp.setAttribute("src", "./img/system/shapes/" + shps[i] + ".png");
								shp.setAttribute("active", "0");
								shp.style.left = sLeft.toString() + "px";
								shp.style.top = sTop.toString() + "px";
								
								shp.addEventListener("mouseover", function(e){
									e.stopPropagation();
									e.preventDefault();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(148, 190, 234, 1)";
										e.target.style.backgroundColor = "rgba(233, 239, 246, 1)";		
									}
								}, false);

								shp.addEventListener("mouseout", function(e){
									e.preventDefault();
									e.stopPropagation();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(0,0,0,0)";
										e.target.style.backgroundColor = "rgba(0,0,0,0)";	
									}
								}, false);

								if(((i+1) % 7) === 0){	
									sLeft = 9;	
									sTop += 20;
								}else{
									sLeft += 20;
								}

							}

							let outline = global.utility.createEl("div", "shapes-outline", "shapes-outline-fill", shapesEl),
								fill = global.utility.createEl("div", "shapes-fill", "shapes-outline-fill", shapesEl);

							outline.setAttribute("title", "shapes-outline");
							fill.setAttribute("title", "shapes-fill");
							global.utility.createEl("div", "shapes-outline-img", "shapes-outline-fill-img", outline);
							global.utility.createEl("div", "shapes-outline-text", "shapes-outline-fill-text", outline);
							global.utility.createEl("div", "shapes-outline-darr", "shapes-outline-fill-darr", outline);

							global.utility.createEl("div", "shapes-fill-img", "shapes-outline-fill-img", fill);
							global.utility.createEl("div", "shapes-fill-text", "shapes-outline-fill-text", fill);
							global.utility.createEl("div", "shapes-fill-darr", "shapes-outline-fill-darr", fill);

							global.utility.createEl("div", "shapes-text", "", shapesEl);

							return false;	

						},
		sizesElements: 	function(){

							let sizesEl = document.getElementById("sizes"),
								height = 25,
								sLeft = 2,
								sTop = 2;

							for(let i=0; i<4; i+=1){
								let sizeId = "sizes-clickable-" + (i+1).toString(),
									size = global.utility.createEl("img", sizeId, "sizes-clickable", sizesEl);

								size.setAttribute("active", i === 0 ? "1" : "0");
								size.setAttribute("src", "./img/system/sizes/_" + (i+1).toString() + ".png");
								size.style.left = sLeft.toString() + "px"; 
								size.style.top = sTop.toString() + "px";

								if(i===0){
									global.toolbox.activateItem(size);
									global.toolbox.sizes["1"] = true;
								}

								size.addEventListener("mouseover", function(e){
									e.stopPropagation();
									e.preventDefault();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(148, 190, 234, 1)";
										e.target.style.backgroundColor = "rgba(233, 239, 246, 1)";		
									}
								}, false);

								size.addEventListener("mouseout", function(e){
									e.preventDefault();
									e.stopPropagation();
									let isActive = e.target.getAttribute("active") === "1" ? true : false;
									if(!isActive){
										e.target.style.border = "1px solid rgba(0,0,0,0)";
										e.target.style.backgroundColor = "rgba(0,0,0,0)";	
									}
								}, false);

								sTop += 26;
							}		

							global.utility.createEl("div", "sizes-text", "", sizesEl);

							return false;					

						},
		colorsElements: function(){

							let colorsEl = document.getElementById("colors"),
								colors = ["black","gray_50","dark_red","red","orange","yellow","green","turquoise","indigo","purple","white","gray_25","brown","rose","gold","light_yellow","lime","light_turquoise","blue_gray","lavender","empty"],
								size = 19,
								sLeft = 97,
								sTop = 3;

							// Color selector 1
							let color1 = global.utility.createEl("div", "colors-clickable-selector-color1", "colors-clickable-selector", colorsEl),
								color1SpanCon = global.utility.createEl("div", "colors-clickable-selector-color1-span-container", "", color1),
								color1Span = global.utility.createEl("span", "colors-clickable-selector-color1-span", "", color1SpanCon),
								color1Text = global.utility.createEl("div", "colors-clickable-selector-color1-text", "colors-clickable-selector-text", color1),
							// Color selector 2
								color2 = global.utility.createEl("div", "colors-clickable-selector-color2", "colors-clickable-selector", colorsEl),
								color2SpanCon = global.utility.createEl("div", "colors-clickable-selector-color2-span-container", "colors-clickable-selector-color-span-container", color2),
								color2Span = global.utility.createEl("span", "colors-clickable-selector-color2-span", "", color2SpanCon),
								color2Text = global.utility.createEl("div", "colors-clickable-selector-color2-text", "colors-clickable-selector-text", color2),
							// Color selector 3 (Rainbow)
								color3 = global.utility.createEl("div", "colors-clickable-selector-color3", "colors-clickable-selector", colorsEl),
								color3SpanCon = global.utility.createEl("div", "colors-clickable-selector-color3-span-container", "colors-clickable-selector-color-span-container", color3),
								color3Span = global.utility.createEl("span", "colors-clickable-selector-color3-span", "", color3SpanCon),
								color3Text = global.utility.createEl("div", "colors-clickable-selector-color3-text", "colors-clickable-selector-text", color3);
							

							// Color boxes. 
							for(let i=0; i<30; i+=1){
								let colorName = (i>20) ? "empty" + (i-20).toString() : colors[i],
									colorId = "colors-clickable-" + colorName,
									colorCon = global.utility.createEl("div", colorId, "color-box", colorsEl),
									colorVal = (i > 20) ? "empty" : colors[i];

								colorCon.setAttribute("active", i === 0 ? "1" : "0");
								colorCon.style.left = sLeft.toString() + "px";
								colorCon.style.top = sTop.toString() + "px";
								
								if(i===0){
									global.toolbox.colors["0"] = true;
									document.getElementById('colors-clickable-selector-color1-span').style.backgroundColor = "rgba(" + JSON.stringify(global.toolbox.options.colors[0]).replace(/[\"rgba\:\{\}]/gi,'') + ")";
								}

								let color = global.utility.createEl("div", "colors-clickable-" + i.toString(), "colors-clickable", colorCon);
								color.setAttribute("active", "0");
								color.style.backgroundColor = "rgba(" + JSON.stringify(global.toolbox.options.colors[i]).replace(/[\"rgba\:\{\}]/gi,'') + ")";

								color.addEventListener("mouseover", function(e){
									e.stopPropagation();
									e.preventDefault();
									e.target.parentNode.style.backgroundColor = "rgba(233, 239, 246, 1)";	
									e.target.parentNode.style.border = "1px solid rgba(148, 190, 234, 1)";	
								});

								color.addEventListener("mouseout", function(e){
									e.stopPropagation();
									e.preventDefault();
									e.target.parentNode.style.backgroundColor = "rgba(0,0,0,0)";	
									e.target.parentNode.style.border = "1px solid rgba(0, 0, 0, 1)";	
								});

								if(((i+1)%10)===0){
									sLeft = 97;
									sTop += size + 3;
								}else{
									sLeft += size + 3;
								}	

  							}

							global.utility.createEl("div", "colors-text", "", colorsEl);
							return false;
						},
		textEntryCon	: function(sCtx, stc){

							let onMouseDown = false,
								sX = 0, sY = 0;

							let pWin = document.getElementById("text-entry-container");
							if(pWin !== null){
								pWin.parentNode.removeChild(pWin);
							}

							let win = global.utility.createEl("div", "text-entry-container", "", global.pintor.els.canvasHolder);
							// let form = global.utility.createEl("form", "form-entry", "", win);
							let label = global.utility.createEl("textarea", "text-entry", "", win);
							label.setAttribute("cols", "30");
							label.setAttribute("rows", "10");

							win.style.left = (stc.x + 100).toString() + "px";
							win.style.top = (stc.y-200).toString() + "px";

							// Create ok and cancel action buttons.
							createButton(win, "text-entry-button-ok", stc);
							createButton(win, "text-entry-button-cancel", stc);

							let conDragger = global.utility.createEl("div", "text-entry-dragger", "", win);

							let rect = global.utility.rect(win),
								cLeft = parseInt(win.style.left.replace("px", ""), 10),
								cTop = parseInt(win.style.top.replace("px", ""), 10);

							// Show the scratch canvas.
							global.utility.activate(global.pintor.els.scratch);	

							// Clear scratch canvas.
							global.utility.clearRect(sCtx);

							// Draw a circle on the clicked area of the current image object.
							global.drawing.drawArc(sCtx, stc, 20, 0, 360);
							
							let pTC = document.getElementById("tC");
							if(pTC !== null){
								pTC.parentNode.removeChild(pTC);
							}

							global.drawing.drawLine(sCtx, {'stc':stc, 'left':cLeft + (rect.width/2), 'top':cTop + (rect.height/2)});

							// Draw a rounded clip over the inner part of the circle.
							let tC = createTempCanvas(stc);
							sCtx.drawImage(tC, 0, 0, 40, 40, stc.x-19, stc.y-19, 38, 38);

							conDragger.addEventListener('mousedown', function(e){
								onMouseDown = true;
								sX = e.layerX;
								sY = e.layerY;
								return false;
							}, false);

							conDragger.addEventListener('mousemove', function(e){
								e.preventDefault();
								e.stopPropagation();
								if(onMouseDown){
									let container = this.parentNode,
										cLeft = parseInt(container.style.left.replace("px", ""), 10),
										cTop = parseInt(container.style.top.replace("px", ""), 10);

									container.style.left = (cLeft + (e.layerX - sX)).toString() + "px";
									container.style.top = (cTop + (e.layerY - sY)).toString() + "px";

									let rect = global.utility.rect(container);

									// Clear scratch canvas.
									global.utility.clearRect(sCtx);

									// Draw a circle on the clicked area of the current image object.
									global.drawing.drawArc(sCtx, stc, 20, 0, 360);
									
									// Draw a line connecting the circle and the text box entry div.
									global.drawing.drawLine(sCtx, {'stc':stc,'left':cLeft + (rect.width/2), 'top':cTop + (rect.height/2)});

									// Erase the segment of line created inside the circle by 
									// drawing the clipped image over the circle.
									sCtx.drawImage(tC, 0, 0, 40, 40, stc.x-19, stc.y-19, 38, 38);

								}
								return false;
							}, false);

							conDragger.addEventListener('mouseup', function(e){
								e.stopPropagation();
								e.preventDefault();
								onMouseDown = false;
								return false;
							}, false);


							label.focus();
						}
	};
})(window);