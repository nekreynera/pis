window.toolbox = window.toolbox || (function(global){

	let that = {};

	that.options = {};
	that.options.toolText = {};

	init();

	that.resetSelection = 	function(tb, bVal){
								for(prop in that[tb]){
									if(typeof that[tb][prop] !== 'function'){
										that[tb][prop] = bVal;	
									}
								}
							};
	that.clearSelection = function(arr){
							arr.forEach(function(tb){
								let isActive = tb.getAttribute("active") === "1" ? true : false;
								if(isActive){
									that.deactivateItem(tb);
								}
							});
						};
	that.activateItem = function(el){
							el.setAttribute("active", "1");
							el.style.border = "1px solid rgba(98,162,228,1)";
							el.style.backgroundColor = "rgba(201,224,247,1)";
						};
	that.deactivateItem = function(el){
							el.setAttribute("active", "0");
							el.style.border = "1px solid rgba(0,0,0,0)";
							el.style.backgroundColor = "rgba(0,0,0,0)";	
						};
	that.tools.print = 	function(tb){
							for(prop in that[tb]){
								if(typeof that[tb][prop] !== 'function'){
									console.log(prop + ": " + that[tb][prop]);	
								}
							}
						};

	that.options.tool = function(){
							for(prop in that.tools){
								if(typeof that.tools[prop] !== 'function'){
									if(that.tools[prop] === true){
										return prop;
									}
								}
							}
							return "";
						};

	that.options.current = 	function(op){
								for(prop in that[op]){
									if(typeof that[op][prop] !== 'function'){
										if(that[op][prop] === true){
											return prop;
										}
									}
								}
								return "";
							};
	that.options.colors = 	[{r:0,g:0,b:0,a:1},
							{r:127,g:127,b:127,a:1},
							{r:136,g:0,b:21,a:1},
							{r:237,g:28,b:36,a:1},
							{r:255,g:127,b:39,a:1},
							{r:255,g:242,b:0,a:1},
							{r:34,g:177,b:76,a:1},
							{r:0,g:162,b:232,a:1},
							{r:63,g:72,b:204,a:1},
							{r:163,g:73,b:164,a:1},
							{r:255,g:255,b:255,a:1},
							{r:195,g:195,b:195,a:1},
							{r:185,g:122,b:87,a:1},
							{r:255,g:174,b:201,a:1},
							{r:255,g:201,b:14,a:1},
							{r:239,g:228,b:176,a:1},
							{r:181,g:230,b:29,a:1},
							{r:153,g:217,b:234,a:1},
							{r:112,g:146,b:190,a:1},
							{r:200,g:191,b:231,a:1},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0},
							{r:0,g:0,b:0,a:0}];

	function init(){

		let itemArr = 	[
							["tools",global.constants.toolsImages], 
					   		["brushes", global.constants.brushImages],
					   		["shapes", global.constants.shapeImages],
					   		["sizes", global.utility.newNumArray(4)],
					   		["colors", global.utility.newNumArray(30)]
					   	];

		for(let i=0; i<itemArr.length; i+=1){
			let item = itemArr[i],
				ndx1 = item[0];

			that[ndx1] = {};
			for(let j=0; j<item[1].length; j+=1){
				var ndx2 = item[1][j];
				that[ndx1][ndx2] = false;
			}
		}

		for(prop in that.tools){
			if(typeof that.tools[prop] !== 'function'){
				that.options.toolText[prop.toUpperCase()] = prop;
			}
		}

	}

	return that;

})(window);