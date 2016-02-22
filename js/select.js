/*
 * select.js
 */

/*
 * Javascript non definisce alcun metodo per dichiarare le variabili nascoste in un blocco di codice singolo
 * perciò definisco una funzione affinché agisca come SPAZIO DEI NOMI temporaneo in cui definire le variabili
 * senza inquinare lo spazio dei nomi globale.
 */
 
(function(window,document,undefined){
	
	var Select=function(selectForm,selectName,selectType){
		if(document.forms[selectForm][selectName]){
			
			this.selectNode=document.forms[selectForm][selectName];
			this.selectType=selectType || null;
			this.currentNode=document.createElement('div');
			this.currentNode.setAttribute('id',this.selectNode.name);
			this.currentNode.setAttribute('class','select '+this.selectType);
			this.selectNode.parentNode.appendChild(this.currentNode);

			this._createCurrent();
			
			var self= this;
			
			var listener = function(){
					document.body.removeChild(document.body.lastChild);
					if(window.removeEventListener) window.removeEventListener('click',listener); 
					else if(window.detachEvent) window.document.detachEvent('onclick', listener);
			}
			
			this.currentNode.onclick = function(){self._behaviorOptions(listener);}
			
		}
	};
	
	Select.prototype._createCurrent = function(){

			var val=document.createElement('span');
			val.setAttribute('class','value');
			val.appendChild(document.createTextNode(this.selectNode.options[this.selectNode.selectedIndex].text));
			
			var btn=document.createElement('span');
			btn.setAttribute('class','select-button');
			
			this.currentNode.appendChild(val); this.currentNode.appendChild(btn);
			
    };
	
	
	Select.prototype._changeCurrentDay = function(){

			for(;this.currentDayNode.firstChild;)this.currentDayNode.removeChild(this.currentDayNode.firstChild);
			var val=document.createElement('span');
			val.setAttribute('class','value');
			val.appendChild(document.createTextNode(this.selectDayNode.options[this.selectDayNode.selectedIndex].text));
			
			var btn=document.createElement('span');
			btn.setAttribute('class','select-button');
			
			this.currentDayNode.appendChild(val); this.currentDayNode.appendChild(btn);
			
    };
	
	
	
	Select.prototype._createOptions = function(listener){
		
		if(this.selectType=='day'){
				var el=this.currentNode;
				do{el=el.nextSibling;} while(el && el.nodeName!=='SELECT')
				if(el) this.selectMonthNode=el; 
			}
			
		if(this.selectType=='month'){
				var el=this.selectNode;
				do{el=el.previousSibling;} while(el && el.nodeName!=='DIV')
				if(el) this.currentDayNode=el;
				do{el=el.previousSibling;} while(el && el.nodeName!=='SELECT')
				if(el) this.selectDayNode=el;
			}
		
		var ul=document.createElement('ul');
		ul.setAttribute('class','options');
		var pos=getPosition(this.currentNode);
		ul.style.top=pos.y+this.currentNode.offsetHeight+'px';
		ul.style.left=pos.x+'px';
		
		var selectLength=this.selectNode.length;
		if(this.selectMonthNode){
			switch(this.selectMonthNode.selectedIndex){
				case 1: selectLength=29; break; // febbraio
				case 3: case 5: case 8: case 10: selectLength=30; //apr, giu, set, nov
			}
		}
		
		

		for (var i=0; i<selectLength; i++){
			var li=document.createElement('li');
			li.setAttribute('rel', i);
			li.appendChild(document.createTextNode(this.selectNode.options[i].text));
			var self=this;
			li.onclick= function(){
				self.selectNode.selectedIndex=this.getAttribute('rel');
				listener();
				if(self.selectDayNode){
					switch(self.selectDayNode.selectedIndex){
					  case 30: switch(self.selectNode.selectedIndex){
															  case 1: self.selectDayNode.selectedIndex=28; 
															  		  self._changeCurrentDay();
																  	  break;
															  case 3: case 5: case 8: case 10: self.selectDayNode.selectedIndex=29;
															  								   self._changeCurrentDay();
															  } break; 
					  case 29: if(self.selectNode.selectedIndex==1){
						  			self.selectDayNode.selectedIndex=28;
									self._changeCurrentDay(); 
					  				} 
				  	}
				}
				for(;self.currentNode.firstChild;)self.currentNode.removeChild(self.currentNode.firstChild);
				self._createCurrent();
			}
			ul.appendChild(li);
		}

		document.body.appendChild(ul);
		
		if(ul.offsetHeight > 200){
			ul.style.height='200px';
			ul.style.top=pos.y-100+this.currentNode.offsetHeight/2+'px';
			ul.style.overflowY='scroll';
		}
		
    };
	
	Select.prototype._behaviorOptions = function(listener){
				if(document.body.lastChild.nodeName!=='UL') {
					this._createOptions(listener);
					setTimeout(function(){
								if(window.addEventListener) window.addEventListener('click',listener);
								else if(window.attachEvent) window.document.attachEvent('onclick', listener);
								}, 10);
				}
    };

	
	window.Select=Select;
	
}(window,document));



/*
 * getPosition (funzione che ritorna le coordinate assolute in px di un elemento presente all'interno della pagina)
 */

function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
}
