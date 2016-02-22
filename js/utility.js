/*
 * utility.js
 */
 
// funzioni da chiamare al termine del caricamento della pagina
window.onload = function(){
	document.body.style.visibility='visible'; // rendi il corpo della pagina visibile solo dopo la fine del caricamento (evita scatti sgradevoli)
	var modalWindow; // variabile che conterrà l'istanza della classe Modal se creata a runtime
	setFooter();
	centerLoginBox();
	if(document.getElementById('notice')) { // gestisce l'apparizione di una notifica se è presente
		var notice=document.getElementById('notice');
		setTimeout(function(){fadeIn(notice, 8)}, 200);
		setTimeout(function(){fadeOut(notice, 24)}, 6000);
	}
}

// funzioni da chiamare al ridimensionamento della pagina
window.onresize = function(){
	setFooter(); 
	centerLoginBox();
}



// getWindowHeight
// Ritorna l'altezza in pixel della finestra (viewport) del browser

function getWindowHeight() {
	var windowHeight = 0;
	if (typeof(window.innerHeight) == 'number') { // codice per ottenere altezza viewport nei browser moderni
		windowHeight = window.innerHeight;
	}
	else {
		if (document.documentElement && document.documentElement.clientHeight) { // codice per ottenere altezza viewport in IE6
			windowHeight = document.documentElement.clientHeight;
		}
		else {
			if (document.body && document.body.clientHeight) { // codice per ottenere altezza viewport in IE4+
				windowHeight = document.body.clientHeight;
			}
		}
	}
	return windowHeight;
}

// getWindowWidth
// Ritorna la larghezza in pixel della finestra (viewport) del browser

function getWindowWidth() {
	var windowWidth = 0;
	if (typeof(window.innerWidth) == 'number') { // codice per ottenere larghezza viewport nei browser moderni
		windowWidth = window.innerWidth;
	}
	else {
		if (document.documentElement && document.documentElement.clientWidth) { // codice per ottenere larghezza viewport in IE6
			windowWidth = document.documentElement.clientWidth;
		}
		else {
			if (document.body && document.body.clientWidth) { // codice per ottenere larghezza viewport in IE4+
				windowWidth = document.body.clientWidth;
			}
		}
	}
	return windowWidth;
}



// ------------------------------------------------------------------------------------------------------------------------------------------
// Il codice che segue è una personalizzazione di quello discusso nell'interessante articolo Exploring Footers di Bobby Van Der Luis
// A List Apart (http://alistapart.com/article/footers)
// ------------------------------------------------------------------------------------------------------------------------------------------

// setFooter
// Funzione che permette di visualizzare l'elemento <div id='footer'> sempre ai piedi della viewport
// anche quando l'altezza (in px) dell'elemento <div id='content'> non è sufficiente a coprire l'intera altezza della viewport.

function setFooter() {
	if (document.getElementById) {
		var windowHeight=getWindowHeight(); // ottieni l'altezza della viewport
		if (windowHeight>0) {
			document.body.style.minHeight=windowHeight + "px"; // important for IE9+
			var contentElement=document.getElementById('content');
			var contentHeight=contentElement.offsetHeight; // ottieni l'altezza del <div id='content'>
			var footerElement=document.getElementById('footer');
			var footerHeight=footerElement.offsetHeight; // ottieni l'altezza del <div id='footer'>
			if(document.getElementById('menu')) var menuElement = document.getElementById('menu');
			var menuHeight=0;
			if(menuElement){
				menuHeight=menuElement.offsetHeight; // ottieni l'altezza del <div id='menu'>
				contentElement.style.paddingTop=menuHeight+'px'; // se è presente menu abbassa il content
				contentHeight=contentElement.offsetHeight;
			}
			if (windowHeight-(contentHeight+footerHeight)>=0) { //forza l'elemento footer a rimanere ai piedi della viewport
				footerElement.style.position='relative';
				footerElement.style.top=(windowHeight-(contentHeight+footerHeight))+'px';
			}
			else {
				footerElement.style.position='static';
				footerElement.style.top='0px';
			}
		}
	}
}

// ------------------------------------------------------------------------------------------------------------------------------------------
// FINE
// ------------------------------------------------------------------------------------------------------------------------------------------


// centerLoginBox
// funzione che centra il login_box se è presente all'interno della pagina

function centerLoginBox() {
	if (document.getElementById('login_box')) {
		var windowHeight=getWindowHeight();
		var windowWidth=getWindowWidth();
		var footerHeight=document.getElementById('footer').offsetHeight;
		var loginBoxElement=document.getElementById('login_box');
		var loginBoxHeight=loginBoxElement.offsetHeight; 
		var loginBoxWidth=loginBoxElement.offsetWidth; 
		loginBoxElement.style.left=(windowWidth-loginBoxWidth)/2+'px';
		loginBoxElement.style.top=(windowHeight-loginBoxHeight-footerHeight)/2+'px';
	}
}

// fadeIn
// funzione che rende visibile un elemento della pagina in modo graduale

function fadeIn(element,speed){
	var i=0;
	function increase(){
		element.style.opacity=i/25;
		element.style.filter = "alpha(opacity:" +  i*4 + ")";
		i++;
		if((i/25) > 1) clearInterval(time);
	}
	var time=setInterval(increase, speed);
}

// fadeOut
// funzione che rende invisibile un elemento della pagina in modo graduale

function fadeOut(element,speed){
	var i=0;
	function decrease(){
		element.style.opacity=1-i/25;
		element.style.filter = "alpha(opacity:" + (1-i/25) * 100 + ")";
		i++;
		if((1-i/25) < 0) clearInterval(time);
	}
	var time=setInterval(decrease, speed);
}