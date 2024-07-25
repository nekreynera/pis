window.scratch = window.scratch || (function(global){

	let that = {}, // The returning object.
		util = global.utility,
		elems,
		mousePressed = false,
		sX, sY, eX, eY;

	/*
	* Mouse down event handler for the main drawing canvas element
	* @namespace js.scratch.hs
	* @method canvasMouseDown
	* @param  {Object} e - Event object
	* @return {boolean} Stops the execution at once, thus cancelling bubbling effect of the event.
	*/	
	function canvasMouseDown(e){

		// Disallow the use of the mouse middle and right buttons.
		if(e.which === 2 || e.which === 3){
			return;
		}


		if((global.toolbox.options.tool() === global.toolbox.options.toolText.PENCIL) || 
		  (global.toolbox.options.tool() === global.toolbox.options.toolText.ERASER)) {
			
			// Flag that the mouse is clicked/pressed.
			mousePressed = true;

			// Get the x and y positions of the mousepointer relative 
			// to the current element (e.target)
			let stc = util.screenToClient(e.target, e.clientX, e.clientY);
			sX = stc.x;
			sY = stc.y;

			// Set the canvas pen location to the x and y positions of the mousepointer.
			ctx.beginPath();
			ctx.moveTo(sX, sY);
			
			// Halt the execution.
			util.hunong(e);
		}

	}	

	/*
	* Mouse move event handler for the main drawing canvas element.
	* @namespace js.scratch.js
	* @method canvasMouseMove
	* @param  {Object} e - Event object
	* @return {Boolean} Halts the further execution of the function.
	*/
	function canvasMouseMove(e){
		
		let stc = util.screenToClient(e.target, e.clientX, e.clientY);
			eX = stc.x,
			eY = stc.y;

		if(mousePressed){
			ctx.lineWidth = global.drawing.settings.lineWidth();
			
			if(global.toolbox.options.tool() === global.toolbox.options.toolText.PENCIL){
				ctx.strokeStyle = "rgba(0,255,0,1)";
				ctx.lineTo(eX, eY);
				ctx.stroke();
			}else if(global.toolbox.options.tool() === global.toolbox.options.toolText.ERASER){
				// TODO: A temporary canvas element should be used to mimic the eraser functinality.
				// The following codes do not yield the expected results.
				ctx.globalCompositeOperation = "destination-out";
				// ctx.strokeStyle = "rgba(0,0,0,0)";
				global.drawing.settings.setStrokeOptions(ctx);
				ctx.lineTo(eX, eY);
				ctx.stroke();
			}

		}else{
			elems.sbmSpanText.innerHTML = parseInt(eX, 10).toString() + ", " + parseInt(eY, 10).toString() + " px";	
		}	

		return util.hunong(e);

	}	

	function canvasMouseUp(e){
		mousePressed = false;
		ctx.globalCompositeOperation = "source-over";
		ctx.closePath();
		return util.hunong(e);
	}

	function boardMouseMove(e){
		elems.sbmSpanText.innerHTML = "";
		return util.hunong(e);
	}

	that.init = function(){
		elems = global.pintor.els;
		canvas = elems.canvas;
		ctx = canvas.getContext("2d");
		elems.board.addEventListener("mousemove", boardMouseMove);
		canvas.addEventListener("mousemove", canvasMouseMove);
		canvas.addEventListener("mousedown", canvasMouseDown);
		canvas.addEventListener("mouseup", canvasMouseUp);
	}

	return that;

})(window);