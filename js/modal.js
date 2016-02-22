/*
 * modal.js (definizione classe(oggetto))
 */

/*
 * Javascript non definisce alcun metodo per dichiarare le variabili nascoste in un blocco di codice singolo
 * perciò definisco una funzione affinché agisca come SPAZIO DEI NOMI temporaneo in cui definire le variabili
 * senza inquinare lo spazio dei nomi globale.
 */
 
(function(window,document,undefined){
	
	var Modal=function(type, params, aspect){
			this.type = type;
			this.params = params || null;
			this.url = null;
			this.overlayElement = null;
			this.iframeElement = null;
			this.iframeWindow = null;
			this.pageHeight = null;
			this.pageWidth = null; 
			this.posY = null;
			this.iframeWidth = aspect || 620;
			this.iframeMarginTop = 50;
			this.iframeMarginBottom = 100;
			
			this._createIframe();
	
	};
	
	
	Modal.prototype._createIframe = function(){
			this._elaborateParams();
			
			if(this.iframeElement == null){
				this.iframeElement = document.createElement('iframe');
				this.iframeElement.style.opacity = 0;
				this.iframeElement.style.filter = 'alpha(opacity:0)';
				this.iframeElement.style.display = 'block';
				this.iframeElement.style.border = '2px solid #2185c5'; 
				this.iframeElement.frameBorder = 'none'; 
				this.iframeElement.scrolling = 'no';  
				this.iframeElement.style.width = this.iframeWidth+'px';
				this.iframeElement.name = 'modal';
				this.iframeElement.id = 'modal';
				this.iframeElement.src = this.url;
				document.body.appendChild(this.iframeElement);
				this.iframeWindow = this.iframeElement.contentWindow;
				if(document.getElementById('menu'))
					document.getElementById('menu').style.position='absolute';
				
				var self=this;
				var listener = function(){ // al caricamento dell'iframe definisce l'altezza dell'elemento iframe in base a contenuto e genera overlay
					if(self.iframeWindow.document.getElementById('modal-box')){
						self.iframeElement.style.height=self.iframeWindow.document.getElementById('modal-box').offsetHeight+'px';
					}
					if(self.iframeElement.offsetHeight+self.posY+self.iframeMarginTop>self.pageHeight) 
						self.pageHeight=self.iframeElement.offsetHeight+self.posY+self.iframeMarginTop+self.iframeMarginBottom;
					fadeIn(self.iframeElement, 1);
					self._createOverlay();
				};
				if(window.addEventListener) this.iframeElement.addEventListener('load', listener);
				else if(window.attachEvent) this.iframeElement.attachEvent('onload', listener);
	
				this.pageHeight=getWindowHeight();
				this.pageHeight = (document.getElementById('content').offsetHeight+document.getElementById('footer').offsetHeight > this.pageHeight)?document.getElementById('content').offsetHeight+document.getElementById('footer').offsetHeight : this.pageHeight; // calcola altezza pagina 
				this.posY=(window.pageYOffset!==undefined)?window.pageYOffset:document.documentElement.scrollTop; // for IE
					
				this.pageWidth = getWindowWidth();
				
				this.iframeElement.style.top=this.posY+this.iframeMarginTop+'px';
				this.iframeElement.style.left=(this.pageWidth-this.iframeWidth)/2+'px';
			}
			else{
				fadeOut(this.iframeElement, 1);
				var self=this;
				setTimeout(function(){self.iframeElement.src = self.url;}, 300);
			}
	
    };
	
	Modal.prototype.deleteIframe = function(){
		if(this.iframeElement){
			this.iframeElement.parentNode.removeChild(this.iframeElement);
			this.overlayElement.parentNode.removeChild(this.overlayElement);
			if(document.getElementById('menu'))
				document.getElementById('menu').style.position='fixed';
		}
    };
	
	Modal.prototype._createOverlay = function(){
		if(!this.overlayElement){
			this.overlayElement = document.createElement('div');
			this.overlayElement.setAttribute('id', 'overlay');
			this.overlayElement.style.width = this.pageWidth+'px';
			this.overlayElement.style.height = this.pageHeight+'px';
			this.overlayElement.style.display = 'block';
			document.body.appendChild(this.overlayElement);
		}
		else{
			this.overlayElement.style.height = this.pageHeight+'px'; // nel caso la modal sia più alta, allunga l'overlay
		}
    };
	
	
	Modal.prototype._elaborateParams = function(){
		var query='';
		for(var key in this.params){
			query+='&'+key+'='+this.params[key];
		}
		var path=window.location.pathname;
		this.file=path.slice(path.lastIndexOf('/')+1,path.length);
		if(this.file=='index.php' || this.file=='')
			this.url='php/iframe.php?type='+this.type+query;
		else 
			this.url='iframe.php?type='+this.type+query;
    };
	
	Modal.prototype.success = function(){
		this.iframeElement.style.visibility='hidden';
		
		var img=document.createElement('img');
		if(this.file=='index.php' || this.file=='')
			img.src='images/icons/loader.gif';
		else
			img.src='../images/icons/loader.gif'; // dimensioni 96 x 48 px
		img.style.zIndex='502';
		img.style.position='absolute';
		var y = (window.pageYOffset!==undefined)?window.pageYOffset:document.documentElement.scrollTop;
		var h = getWindowHeight();
		img.style.top=y+(h-24)/2+'px';
		img.style.left=(this.pageWidth-48)/2+'px';	
		document.body.appendChild(img);
		
		var self=this;
		var listener = function(){
			setTimeout(function(){window.location.assign(self.iframeWindow.location.href);}, 2000);
		};
		
		if(window.addEventListener) this.iframeElement.addEventListener('load', listener);
		else if(window.attachEvent) this.iframeElement.attachEvent('onload', listener);
    };
	
	Modal.prototype.change = function(type){
		this.type=type;
		this._createIframe();
    };
	
	
	window.Modal=Modal;
	
}(window,document));