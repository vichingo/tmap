	Ext.apply(Ext.form.VTypes, {
	    number:  function(v) {
	        return /[0-9]/.test(v);
	    },
	    numberText: 'Moet een nummer zijn!'
	});
		

	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'lib/ext-2.3.0/resources/images/default/s.gif';
		Ext.QuickTips.init();
		
		//store(s)
		var ds = new Ext.data.GroupingStore({
			url: 'klanten.php?actie=alleKlanten',
			sortInfo: {
				field: 'woonplaats',
				direction: "ASC"
			},
			groupField: 'woonplaats',
			reader: new Ext.data.JsonReader({
				root: 'rows',
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
		
		ds.load();
		
		//functions
		function voornaam_achternaam(val, x, ds){
			return val + ' '+ ds.data.achternaam;
		}
		
		// Viewport
		var klantenView = new Ext.Viewport({
			layout: 'border',
			id: 'klantenView',
			renderTo: Ext.getBody(),
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
				region: 'west',
				xtype: 'form',
				method: 'POST',
				name: 'klanten_form',
				id: 'klanten_form',
				//url: 'database_class.php?actie=nieuweKlant',
				//split: true,
				//collapsible: true,
				//collapseMode: 'mini',
				title: 'Maak een nieuwe klant aan',
				bodyStyle: 'padding:5px;',
				width: 300,
				//minSize: 300,
				//html: 'West'
				items: [{
				xtype: 'textfield',
				fieldLabel: 'Voornaam',
				name: 'voornaam',
				vtype: 'alpha'
			},{
				xtype: 'textfield',
				fieldLabel: 'Achternaam',
				name: 'achternaam',
				allowBlank: false
			},{
				xtype: 'textfield',
				fieldLabel: 'Straat',
				name: 'straat',
				allowBlank: false
			},{
				xtype: 'textfield',
				fieldLabel: 'Huisnummer',
				name: 'straat_nummer',
				vtype: 'number'
			},{
				xtype: 'textfield',
				fieldLabel: 'Bus',
				name: 'nummer_bus'
			},{
				xtype: 'textfield',
				fieldLabel: 'Postcode',
				name: 'postcode',
				vtype: 'number'
			},{
				xtype: 'textfield',
				fieldLabel: 'Woonplaats',
				name: 'woonplaats',
				allowBlank: false
			}],
			buttons:[{
				text: 'Opslaan',
				waitMsg: 'Saving Data',
				handler: function() 
				{
					Ext.getCmp('klanten_form').getForm().submit({
	                    url: 'database_class.php?actie=nieuweKlant',
						success: function (f,a)
						{
							ds.reload();
							Ext.Msg.alert('Success', 'Het heeft gewerkt');
							
						},
						failure: function(f,a)
						{
							Ext.Msg.alert('Waarschuwing', 'Het ging fout!');
						}
	                });
				}
			},{
				text: 'Reset',
				handler: function() {
					klanten_form.getForm().reset();
				}
			}]
			},{
				region: 'center',
				xtype: 'grid',
				title: 'Klant detail',
				store: ds,
				stripeRows: true,
				//autoExpandColumn: 'voornaam',
				columns: [
					{header: 'Naam', dataIndex: 'voornaam', renderer: voornaam_achternaam},
					{header: 'Achternaam', dataIndex: 'achternaam', hidden: true},
					{header: 'Straat', dataIndex: 'straat'},
					{header: 'Huisnummer', dataIndex: 'straat_nummer'},
					{header: 'Bus', dataIndex: 'nummer_bus'},
					{header: 'Postcode', dataIndex: 'postcode'},
					{header: 'Woonplaats', dataIndex: 'woonplaats'},
				],
				view: new Ext.grid.GroupingView()
			}]
		});
	});