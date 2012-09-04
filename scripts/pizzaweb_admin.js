	
	
	var Pizzaweb = {};
	
	// Renderers
	/// Klanten
		
	Pizzaweb.Renderers = {
		naam: function(value, p, record){
			return String.format(
				'{0} {1}',
				value, record.data.achternaam
			);
		},
		// hier kunnen alle andere renderers ook bij.
		adres: function(value, p, r){
			if (r.data['nummer_bus'] != ""){
				var bus = ' Bus ' . r.data['nummer_bus'];
			} else {
				var bus = '';
			}
			return String.format(
				'{0} {1} {2}, {3} {4}', // straat nummer bus {bus}, postcode woonplaats
				value, r.data['straat_nummer'], bus, r.data['postcode'], r.data['woonplaats']
			);
		}
	};
	
	
	// Datastore voor klanten 
	Pizzaweb.klantenStore = function() {
		Pizzaweb.klantenStore.superclass.constructor.call(this, {
			remoteSort: true,
			
			url: 'database_class.php?actie=alleKlanten',
			
			reader: new Ext.data.JsonReader({
				root: 'klanten',
				id: 'id'
			}, [
				'id',
				'voornaam',
				'achternaam',
				'straat',
				'straat_nummer',
				'nummer_bus',
				'postcode',
				'woonplaats'
			]) 
		});
		this.setDefaultSort('achternaam', 'desc');
	};
	Ext.extend(Pizzaweb.klantenStore, Ext.data.Store, {
		laadKlant: function(klantId){
			this.baseParams = {
				klantId: klantId
			};
			this.load({
				params: {
					start: 0,
					limit: 10
				}
			});
		}
	});
	
	
	Ext.apply(Ext.form.VTypes, {
	    number:  function(v) {
	        return /[0-9]/.test(v);
	    },
	    numberText: 'Mag alleen uit nummers bestaan!'
	});
	
		

	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'lib/ext-2.3.0/resources/images/default/s.gif';
		Ext.QuickTips.init();
		
		//function
		
		//store
		
		//views
		var main = Ext.getCmp('wrapper').findById('main');
		if (!main.isVisible()){
			main.expand();
		} 
		
		
		var wrapper = new Ext.Viewport({
			layout: 'border',
			id: 'wrapper',
			renderTo: document.body,
			items: [{
				region: 'north',
				xtype: 'toolbar',
				items: [{
					xtype: 'tbbutton',
					text: 'Klanten',
					menu: [{
						text: 'Beheer klanten'
					},{
						text: 'Nieuwe klanten'
					},{
						text: 'Statistieken'
					}]
				},{
					xtype: 'tbseparator'
				},{
					xtype: 'tbbutton',
					text: 'Pizza\'s',
					menu: [{
						text: 'Beheer pizza\'s'
					},{
						text: 'Nieuwe pizza'
					},{
						text: 'Beheer toppings'
					},{
						text: 'Nieuwe topping'
					}]
				},{
					xtype: 'tbseparator'
				},{
					xtype: 'tbbutton',
					text: 'Bestellingen',
					menu: [{
						text: 'Beheer bestellingen'
					},{
						text: 'Openstaande bestellingen'
					},{
						text: 'Archiveren'
					}]
				},{
					xtype: 'tbfill'
				},{
					xtype: 'tbbutton',
					text: 'Help',
					menu: [{
						text: 'Help'
					},{
						text: 'About'
					}]
				}]
			},{
				region: 'center',
				xtype: 'panel',
				id: 'main',
				//title: 'Main'
			}]
		});
	});