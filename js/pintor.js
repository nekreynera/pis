window.pintor = window.pintor || (function(global){
	
	let that = {},
		util = global.utility,
		elems = {},
		pintorCon = document.querySelector('.container-fluid');

	function createEls(){
		elems.container = document.getElementById("pintor-container");
		elems.overlay = util.createEl("div", "overlay", "", elems.container);
		elems.ribbon = util.createEl("div", "ribbon", "", elems.container);
		elems.toolbox = util.createEl("div", "toolbox", "", elems.ribbon);

		let tbItems = global.constants.toolboxItems;

		elems.container.style.visibility = "hidden";

		// let con = document.querySelector('.container-fluid');
		// con.style.background = "rgba(0,0,0,0) url('./img/system/notifier.gif') no-repeat 50% 50%";


		for(let i = 0; i < 7; i += 1){
			let curItem = "tb"+tbItems[i];
			elems[curItem] = util.createEl("div", "tb-" + tbItems[i].toLowerCase(), "toolbox-item", elems.toolbox);
			elems[curItem + "Img"] = util.createEl("div", "tb-" + tbItems[i].toLowerCase() + "-img", "toolbox-item-img", elems[curItem]);
			elems[curItem + "Img"].style.backgroundImage = "url('./img/system/" + tbItems[i].toLowerCase() + ".png')";

			elems[curItem + "Text"] = util.createEl("div", "tb-" + tbItems[i].toLowerCase() + "-text", "toolbox-item-text", elems[curItem]);
			let text = (tbItems[i] === "ClipBoard") ? "Clip" + "\r\n" + "Board" : tbItems[i];
			elems[curItem + "Text"].innerHTML = text;
			elems[curItem + "Darr"] = util.createEl("div", "tb-" + tbItems[i].toLowerCase() + "-darr", "toolbox-item-darr", elems[curItem]);

		}

		// clipboard box
		elems.clipboard = util.createEl("div", "clipboard", "tb-containers", elems.toolbox);
		elems.clipboard.innerHTML = global.constants.clipboardElements;

		// image box
		elems.image = util.createEl("div", "image", "tb-containers", elems.toolbox);
		elems.image.innerHTML = global.constants.imageElements;

		// tools box
		elems.tools = util.createEl("div", "tools", "tb-containers", elems.toolbox);
		// elems.tools.innerHTML = global.constants.toolsElements;
		global.constants.toolsElements();

		// brushes box
		elems.brushes = util.createEl("div", "brushes", "tb-containers", elems.toolbox);
		// elems.brushes.innerHTML = global.constants.brushesElements;
		global.constants.brushesElements();

		// shapes box
		elems.shapes = util.createEl("div", "shapes", "tb-containers", elems.toolbox);
		global.constants.shapesElements();

		// sizes box
		elems.sizes = util.createEl("div", "sizes", "tb-containers", elems.toolbox);
		global.constants.sizesElements();

		// colors box
		elems.colors = util.createEl("div", "colors", "tb-containers", elems.toolbox);
		global.constants.colorsElements();

		elems.clinicsContainer = util.createEl('div', 'clinics-container', '', elems.ribbon);
		elems.curClinic = util.createEl('img', 'current-clinic-img', '', elems.clinicsContainer);
		elems.clinicsLoader = util.createEl('div', 'clinics-loader', '', elems.clinicsContainer);

		// TEMPORARY
		// ---------
		global.utility.getTitles();

		elems.thumbnailBox = util.createEl("div", "thumbnailBox", "", elems.container);
		elems.board = util.createEl("div", "board", "", elems.container);

		elems.canvasHolder = util.createEl("div", "canvas-holder", "", elems.board);
		elems.canvas = util.createEl("canvas", "canvas", "", elems.canvasHolder);
		elems.canvasBuffer = util.createEl("canvas", "canvas-buffer", "", elems.canvasHolder);
		elems.scratch = util.createEl("canvas", "scratch", "", elems.canvasHolder);
		elems.scratchBuffer = util.createEl("canvas", "scratch-buffer", "", elems.canvasHolder);
		
		elems.gallery = util.createEl("div", "gallery", "", elems.board);
		elems.galleryHeader = util.createEl("span", "gallery-header", "", elems.gallery);
		elems.galleryDisplay = util.createEl("div", "gallery-display", "", elems.gallery);
		
		elems.fileMenu = util.createEl("div", "file-menu", "", elems.canvasHolder);
		elems.fileSave = util.createEl("div", "file-save", "file-save-open", elems.fileMenu);
		elems.fileOpen = util.createEl("div", "file-open", "file-save-open", elems.fileMenu);

		elems.statusBox = util.createEl("div", "status-box", "", elems.container);
		elems.sbMove = util.createEl("div", "sb-move", "sb-detail", elems.statusBox);
		elems.sbmSpanImg = util.createEl("span", "sbm-span-img", "sb-detail-img", elems.sbMove);
		elems.sbmSpanText = util.createEl("span", "sbm-span-text", "sb-detail-text", elems.sbMove);
		
		elems.sbDim1 = util.createEl("div", "sb-dim1", "sb-detail", elems.statusBox);
		elems.sbd1SpanImg = util.createEl("span", "sbd1-span-img", "sb-detail-img", elems.sbDim1);
		elems.sbd1SpanText = util.createEl("span", "sbd1-span-text", "sb-detail-text", elems.sbDim1);

		elems.sbDim2 = util.createEl("div", "sb-dim2", "sb-detail", elems.statusBox);
		elems.sbd2SpanImg = util.createEl("span", "sbd2-span-img", "sb-detail-img", elems.sbDim2);
		elems.sbd2SpanText = util.createEl("span", "sbd2-span-text", "sb-detail-text", elems.sbDim2);

		elems.imageContainer = util.createEl("div", "image-container", "", elems.container);
		elems.imageContainer.style.visibility = "hidden";

		elems.currentClinic = util.createEl("input", "current-clinic", "", elems.container);
		elems.currentClinic.setAttribute('type', 'hidden');

		setTimeout(function(e){
			elems.container.style.visibility = "visible";
			pintorCon.style.background = "";
		}, 2500);

	};

	function adjustUI(){

		let header = document.querySelector('.cd-main-header'),
			hOffset = util.computedValue(header, "height"),
			galleryOffset = 30,
			hPadding = 15;

		let vw = document.documentElement.clientWidth ,
			vh = document.documentElement.clientHeight - (hOffset + hPadding);
		
		elems.board.style.height = (vh - (elems.ribbon.offsetHeight + elems.statusBox.offsetHeight + 16)).toString() + "px";
		elems.gallery.style.left = (vw - elems.gallery.offsetWidth - 8 - galleryOffset).toString() + "px"; 
		elems.gallery.style.height = elems.board.style.height;
		elems.galleryDisplay.style.height = (parseInt(elems.gallery.style.height.replace("px",""), 10) - global.utility.computedValue(elems.galleryHeader, "height") - 5).toString() + "px";
		elems.canvasHolder.style.height = elems.board.style.height;	
		elems.canvasHolder.style.width = (vw - elems.gallery.offsetWidth - 16).toString() + "px";


		elems.thumbnailBox.style.left = (util.computedValue(elems.ribbon, 'width') - 756).toString() + 'px';

		let conSideNav = document.querySelector(".cd-side-nav"),
			conSideNavH = util.computedValue(conSideNav, "height") - hOffset;
		conSideNav.style.minHeight = "99vh";
		conSideNav.style.position = "absolute";

		let conW = document.querySelector(".content-wrapper"),
			conWH = util.computedValue(conW, "height") - hOffset;
		conW.style.height = conWH.toString() + "px";

	}

	function resizeCanvas(w, h){
		elems.canvas.width = w;
		elems.canvas.height = h;
		elems.scratch.width = w;
		elems.scratch.height = h;
		elems.canvasBuffer.width = w;
		elems.canvasBuffer.height = h;
		elems.scratchBuffer.width = w;
		elems.scratchBuffer.height = h;
	}

	function windowResize(){
		timer = setTimeout(function(e){
			adjustUI();			
			clearTimeout(timer);
			timer2 = setTimeout(function(e){
				adjustUI();
				clearTimeout(timer2);
			}, 50, true);
		}, 50, true);
	}

	that.init = function(){
		
		pintorCon.style.background = "rgba(0,0,0,0) url('./img/system/evrmc.gif') no-repeat 50% 50%";

		util.loadCSS('.\\css\\clipboard.css');
		util.loadCSS('.\\css\\image.css');
		util.loadCSS('.\\css\\tools.css');
		util.loadCSS('.\\css\\brushes.css');
		util.loadCSS('.\\css\\shapes.css');
		util.loadCSS('.\\css\\sizes.css');
		util.loadCSS('.\\css\\colors.css');
		createEls();
		resizeCanvas(1500, 1500);
		windowResize();

	};
	
	that.els = elems;


	return that;

})(window);