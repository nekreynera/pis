window.drawing = window.drawing || (function(global){
	
	"use strict";

	let that = {};

	that.settings = {};
	that.settings.lineWidth = function(){
		return parseInt(global.toolbox.options.current("sizes").replace(/\_/gi, ''), 10) * 1.5;
	}
	that.settings.getStrokeStyle = 	function(colorIndex){
		return "rgba(" + JSON.stringify(global.toolbox.options.colors[colorIndex]).replace(/[\"rgba\:\{\}]/gi,'') + ")";
	};

	/*
	* Initialize the stroke options based on the current settings.
	* @method setStrokeOptions
	* @param  {object} ctx - Canvas context
	* @return {boolean} Halts the execution for the current scope.
	*/
	that.setStrokeOptions = function(ctx){
		ctx.setLineDash([]);
		ctx.lineCap = "round";
		ctx.lineWidth = that.settings.lineWidth();
		ctx.strokeStyle = that.settings.getStrokeStyle(global.utility.getColorIndex());
		return false;
	}

	that.drawLine = function(ctx, specs){
						that.setStrokeOptions(ctx);
						ctx.beginPath();
						ctx.moveTo(specs.stc.x, specs.stc.y);
						ctx.lineTo(specs.left, specs.top);
						ctx.closePath();
						ctx.stroke();
					}

	that.drawArc = 	function(ctx, ...specs){
						let x = specs[0].x,
							y = specs[0].y,
							radius = specs[1],
							sAngle = specs[2],
							eAngle = specs[3];

						that.setStrokeOptions(ctx);

						ctx.beginPath();	
						ctx.arc(x, y, radius, sAngle, eAngle);
						ctx.stroke();
						ctx.closePath();

						return false;

					},
	that.drawRect = function(ctx, ...specs){
						ctx.save();
						ctx.fillStyle = "rgba(225,225,225,1";
						ctx.strokeStyle = "rgba(64,64,64,1";
						ctx.fillRect(specs[0], specs[1], specs[2], specs[3]);
						ctx.strokeRect(specs[0], specs[1], specs[2], specs[3]);	
						ctx.restore();
					}
	that.drawLabelLine = function(ctx, stc){

						let sX = stc.x,
							sY = stc.y,
							eX = sX + 100,
							eY = sY - 50;

						ctx.lineWidth = that.settings.lineWidth();
						ctx.lineCap = "round";
						ctx.strokeStyle = that.settings.getStrokeStyle(global.utility.getColorIndex());

						ctx.beginPath();
						ctx.moveTo(sX, sY);
						ctx.lineTo(eX, eY);
						ctx.closePath();
						ctx.stroke();

						return {x: eX, y: eY};

					}	


	return that;

})(window);