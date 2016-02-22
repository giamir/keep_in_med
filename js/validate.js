/*
 * validate.js (definizione classe(oggetto))
 * Parte del codice presente in validate.js si ispira a validate.js di Rick Harrison.
 * http://rickharrison.github.com/validate.js
 */

/*
 * Javascript non definisce alcun metodo per dichiarare le variabili nascoste in un blocco di codice singolo
 * perciò definisco una funzione affinché agisca come SPAZIO DEI NOMI temporaneo in cui definire le variabili
 * senza inquinare lo spazio dei nomi globale.
 */
 
(function(window, document, undefined) {
	
    /*
     * Messaggi di errore, attributi valore default e funzione di callback default
     */

    var defaults = {
        messages: {
            required: '%s è obbligatorio.',
            matches: 'Il campo %s non coincide con il campo %s.',
            "default": '%s ha ancora il suo valore di default.',
            email: '%s deve contenere un indirizzo email valido.',
            exact_length: 'Il campo %s deve essere composto esattamente da %s numeri.',
            numeric: '%s può contenere solo numeri.',
			codfiscale: '%s non ha una sintassi corretta.',
			name: '%s non accetta né numeri né caratteri speciali.',
			cap: '%s deve essere composto esclusivamente da 5 cifre.',
			password: '%s non può contenere spazi bianchi e non deve essere inferiore a 6 caratteri.'
        },
		values: {
            codfiscale: 'Codice Fiscale',
			newcodfiscale: 'Codice Fiscale',
			name: 'Nome',
			surname: 'Cognome',
			birthday: 'Giorno di nascita',
			birthmonth: 'Mese di nascita',
			birthyear: 'Anno di nascita',
			visitday: 'Giorno',
			visitmonth: 'Mese',
			visityear: 'Anno',
			visithour: 'Ora',
			visitminute: 'Minuti',
			appointmentday: 'Giorno',
			appointmentmonth: 'Mese',
			appointmentyear: 'Anno',
			appointmenthour: 'Ora',
			appointmentminute: 'Minuti',
			gender: 'Sesso',
			specialization: 'Specializzazione',
            password: 'Password',
			old_password: 'Vecchia Password',
			new_password: 'Nuova Password',
			password_confirmation: 'Ripeti Password',
			phone: 'Telefono',
			email: 'Email',
			address: 'Indirizzo',
			city: 'Città',
			region: 'Regione',
			province: 'Provincia',
			cap: 'CAP'
        },
        callback: function(errors) {
			for(var i=0, errorsLength=errors.length; i<errorsLength; i++){
				txt=document.createTextNode(errors[i].message);
				errors[i].console.appendChild(txt);
				errors[i].console.setAttribute('class', 'message error');
			}
        }
    };

    /*
     * Espressioni regolari utilizzate per controlli
     */

    var ruleRegex = /^(.+?)\[(.+)\]$/,
        numericRegex = /^[0-9]+$/,
        emailRegex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/,
        alphaRegex = /^[a-z]+$/i,
        alphaNumericRegex = /^[a-z0-9]+$/i,
		codfiscaleRegex = /[a-zA-Z]{6}\d{2}[a-zA-Z]\d{2}[a-zA-Z]\d{3}[a-zA-Z]/,
		nameRegex = /^[a-zA-ZàáâäãåąćęèéêëìíîïłńòóôöõøùúûüÿýżźñçčšžÀÁÂÄÃÅĄĆĘÈÉÊËÌÍÎÏŁŃÒÓÔÖÕØÙÚÛÜŸÝŻŹÑßÇŒÆČŠŽ∂ð ']+$/,
		blankRegex = /^\s+$/,
		capRegex = /^\d{5}$/,
		passwordRegex = /^[^\s]{6,}$/;

	 
	/*
     * Realizzazione di una classe FormValidator le cui istanze validano form:
     *
     * @parametro: formName - String - l'attributo name del form che si vuole validare (ad esempio <form name="myForm"></form>)
     * @parametro: callback - Function - funzione che viene lanciata una volta che la validazione è terminata.
     *     @argomento errors - un array contenente gli errori di validazione
     */

    var FormValidator = function(formName) {
		this.form = document.forms[formName] || {};
        this.callback = defaults.callback; 		// se non viene passata una funzione di callback utilizza quella di default
        this.errors = [];
        this.fields = {};
        this.messages = {};
		this.query = null;

        for (var i = 0, fieldLength = this.form.elements.length; i < fieldLength; i++) {
            var field = this.form.elements[i];
			
			

            // Se l'elemento del form non ha l'attributo name oppure non ha l'attributo class passa ad analizzare il prossimo elemento
            if (!field.name) {
                continue;
            }

            /*
             * Costruzione dell'array dei campi con tutte le informazioni necessarie alla validazione
             */
			 
                this._addField(field, field.name);
				
        }

        /*
         * Associa all'evento onsubmit del form (document.forms[this.form].onsubmit) ciò che ritorna la funzione chiamata immediatamente
		 * con argomento (this). -> Al parametro that è attribuito quindi il valore this
		 * la funzione function(that) ritorna un OGGETTO FUNZIONE che può essere vuoto nel caso in cui venga sollevata
		 * un'eccezione all'interno del blocco try.
		 * 
         */

        this.form.onsubmit = (function(that) {
            return function(evt) {
                try {
					that._initQuery();
                    return (evt)?that._validateForm(evt):that._validateForm(event);
                } catch(e) {} // se il metodo _validateForm solleva un'eccezione di runtime (evita di vedere a display eventuali errori dell'interprete)
            };
        })(this);
		
		
		for (var key in this.fields) {						// per ogni campo presente nell'array fields
                var field = this.fields[key] || {},			// metto in field l'oggetto associato a key
                    element = this.form[field.name],
					self=this;
	
					element.onfocus= function(e) {
						if(e) self._validateForm(e); else self._validateForm(event);	
					}
					
					element.onblur= function(e) {
							if(e) self._validateForm(e); else self._validateForm(event);
					}
		}

		
		
    };


    /*
     * Definizione dei metodi per la classe FormValidator mediante uso di prototype.
     */


    /*
     * _addField
     * Aggiunge un campo del form all'array principale fields dell'oggetto indicizzandolo con chiave 'nameValue'
	 * Un field possiede le seguenti proprietà: name, display, rules, id, type, value
     */

    FormValidator.prototype._addField = function(field, nameValue)  {
        this.fields[nameValue] = {
            name: nameValue,
            display: defaults.values[field.name] || nameValue,
            rules: null,
            type: null,
            value: null,
			console: null,
        };
    };

    /*
     * _validateForm
     * Lancia la validazione quando il form è sottomesso.
     */

    FormValidator.prototype._validateForm = function(evt) {
		this.errors = [];							// inizialmente non sono presenti errori
		
		for (var key in this.fields){
			var field = this.fields[key] || {},			// metto in field l'oggetto associato a key
            element = this.form[field.name],		// metto in element document.forms[formName][field.name]
			el=element.parentNode;
			do{el=el.nextSibling} while(el && el.nodeName!=='TD')
			
			if (element && element !== undefined) {					// se element è definito
						field.type = element.type;
						field.value = element['value'];						
						if(element.getAttribute('class')) field.rules = element.getAttribute('class');		//  field class undefined
						field.console= el;
			}
		}
				
		
		if(evt.type=='submit'){
			for (var key in this.fields) {						// per ogni campo presente nell'array fields
					var field = this.fields[key] || {};
						
					if(field.rules!=null){	
						field.console.setAttribute('class', 'message');	
						if(field.console.firstChild) field.console.removeChild(field.console.firstChild);
					}
		
					/*
					 * Per ogni campo (field) con regole lancia i controlli sulle singole regole
					 */
					if(field.rules!=null) this._validateField(field);
					this._createQuery(field);
			}
		}
		else{
			var field=(evt.target)?this.fields[evt.target.name]:this.fields[evt.srcElement.name];			
				if(evt.type=='blur') this._validateField(field);
				else {
					if(field.rules!=null){
						field.console.setAttribute('class', 'message')
						if(field.console.firstChild) field.console.removeChild(field.console.firstChild);
					}
				}
		}
		
		
			
		if(evt.type=='submit' && this.errors.length == 0) this._validateAJAX();
		
		
		/*
		 * Se è presente la funzione di callback viene lanciata passandogli come argomenti l'array degli errori
		 */

        if (typeof this.callback === 'function') {
            this.callback(this.errors);
        }
		
		/*
		 * Se sono presenti errori blocca l'evento di sottomissione del form
		 */

        if (this.errors.length > 0) {
            if (evt && evt.preventDefault) {
                evt.preventDefault();
            } else if (event) {
                // IE utilizza la variabile globale event e non supporta prevenDefault
                event.returnValue = false;
            }
        }
		
		if(evt.type=='submit' && this.errors.length == 0) {
			parent.window.modalWindow.success();
		}
        return true;			// validazione del form terminata con successo
    };

    /*
     * _validateField
     * Confronta i singoli valori dei campi con le regole che devono rispettare
     */

    FormValidator.prototype._validateField = function(field) {
        var rules = field.rules.split(' '),
            indexOfRequired = field.rules.indexOf('required'),			// se è uguale a -1 il campo non è required
            isEmpty = (!field.value || field.value === '' || field.value === undefined);		// se è uguale a 1 il campo è vuoto

        /*
         * Esegui i controlli uno ad uno estrapolandoli dall'array rules
         */

        for (var i = 0, ruleLength = rules.length; i < ruleLength; i++) {
            var method = rules[i], 
                param = null,
                failed = false,
                parts = ruleRegex.exec(method);		// se la regola contiene un'espressione con parametro finisce dentro parts (altrimenti parts=null)
	

            /*
             * Se il campo non è obbligatorio ed è vuoto, interrompi i controlli.
             * This ensures that a callback will always be called but other rules will be skipped.
             */

            if (indexOfRequired === -1 && isEmpty) {
                break;
            }

            /*
             * If the rule has a parameter (ad esempio matches[param]) split it out
             */

            if (parts) {
                method = parts[1];
                param = parts[2];
            }
            

            /*
             * Se la regola è definita, esegui il controllo per trovare eventuali errori
             */

            if (typeof this._checks[method] === 'function') {
                if (!this._checks[method].apply(this, [field, param])) {
                    failed = true;
                }
            } 

            /*
             * Se la regola fallisce(è stato trovato un errore), aggiungi un messaggio all'array degli errori
             */

            if (failed) {
                var source = this.messages[method] || defaults.messages[method],
                    message = 'Controllare il campo ' + field.display;

                if (source) {
                    message = source.replace('%s', field.display);

                    if (param) {
                        message = message.replace('%s', (this.fields[param]) ? this.fields[param].display : param);
                    }
                }
			

                this.errors.push({
                    form: this.form,
                    name: field.name,
                    message: message,
                    rule: method,
					console: field.console
                });
				
                // Interrompi i controlli sul campo field dato che è già stato trovato un errore (esempio required and codfiscale)
                break;
            }
        }
    };
	
	/*
     * _initQuery
     * inizializza la query per il controllo tramite AJAX
     */
	FormValidator.prototype._initQuery = function()  {
		var query=window.location.search;
		if (query.indexOf('=') != -1){
			var end = (query.indexOf('&') != -1) ? query.indexOf('&') : query.length;
			var type = query.slice(query.indexOf('=')+1, end);
			this.query='?check='+type;
		}
    };
	
	/*
     * _createQuery
     * crea la query per il controllo tramite AJAX
     */
	FormValidator.prototype._createQuery = function(field)  {
		this.query+='&'+field.name+'='+field.value;
    };
	
	/*
     * _validateAJAX
     * effettua il controllo AJAX prima della sottomissione della form
     */
	FormValidator.prototype._validateAJAX = function() {
		try { xmlHttp=new XMLHttpRequest(); } 
		catch (e) {
			try { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); } //IE (recent versions)
			catch (e) {
				try { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); } //IE (older versions)
				catch (e) {
					window.alert("Your browser does not support AJAX!");
					return false;
				}
			} 
		} 
		xmlHttp.open("GET", 'check.php'+this.query, false);
		var self=this;
		xmlHttp.onreadystatechange = function() {		//chiama questa funzione quando lo stato della richiesta cambia
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				if(xmlHttp.responseText!=true){
					var ajaxErr = document.getElementById('ajax_error');
					if(ajaxErr.firstChild) ajaxErr.removeChild(ajaxErr.firstChild);
					self.errors.push({
						form: self.form,
						message: xmlHttp.responseText,
						console: ajaxErr
					});
				}
			}
		}
		xmlHttp.send();
    };
	

    /*
     * _checks
     * Questo oggetto(metodo di FormValidator) contiene al suo interno tutte le funzioni di controllo
     */

    FormValidator.prototype._checks = {
        required: function(field) {
            var value = field.value;
            return (value !== null && value !== '' && !blankRegex.test(value));
        },
        
        "default": function(field){
            return field.value !== defaults.values[field.name];
        },
		
		codfiscale: function(field) {
            return codfiscaleRegex.test(field.value);
        },
		
		name: function(field) {
            return nameRegex.test(field.value);
        },

        matches: function(field, matchName) {
            var el = this.form[matchName];

            if (el) {
                return field.value === el.value;
            }

            return false;
        },

        email: function(field) {
            return emailRegex.test(field.value);
        },
		
		cap: function(field) {
            return capRegex.test(field.value);
        },
		
		password: function(field) {
            return passwordRegex.test(field.value);
        },
		
		exact_length: function(field, length) {
            if (!numericRegex.test(length)) {
                return false;
            }

            return (field.value.length === parseInt(length, 10));
        },

    };

    window.FormValidator = FormValidator;

})(window, document);
