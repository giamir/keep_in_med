/*
 * menu.js
 */


/*
 * Javascript non definisce alcun metodo per dichiarare le variabili nascoste in un blocco di codice singolo
 * perciò definisco una funzione affinché agisca come SPAZIO DEI NOMI temporaneo in cui definire le variabili
 * senza inquinare lo spazio dei nomi globale.
 */
 
(function(window,document,undefined){
	
	var Menu=function(){
		if(document.getElementById('menu')){
			var menu = document.getElementById('menu'),
			id_body = document.body.id,
			lis = menu.getElementsByTagName('li');
			
			for (var i = 0, lisLength = lis.length; i < lisLength; i++) {
				li=lis[i];
				if(li.getAttribute('class')) liClass=li.getAttribute('class');
				if(liClass==id_body && id_body!='dashboard' && id_body!='profile') li.setAttribute('class', liClass+' active');
				liClass=li.getAttribute('class'); //aggiorna contenuto di liClass in caso di active
				pattern=/\bactive\b|\bdashboard\b|\blogout\b/;
				if(!pattern.test(liClass)){
					li.firstChild.onmouseover= function(){
						this.style.borderBottom='2px solid #2185c5';
					}
					li.firstChild.onmouseout= function(){
						this.style.borderBottom='none';
					}
				}
			}
		}
	};
	
	window.Menu=Menu;
	
}(window,document));