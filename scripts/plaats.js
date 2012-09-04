Ext.BLANK_IMAGE_URL = 'lib/ext-3.1.0/resources/images/default/s.gif';

var lokatieTpl = new Ext.XTemplate(
	'<tpl for="."><div class="combo-result-item">',
		'<div class="combo-postcode">{stad}</div>',
		'<div class="combo-stad">{postcode}</div>',
		'<div class="combo-provincie">{provincie}</div>',
	'</div></tpl>'
);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var lokatieStore = new Ext.data.JsonStore({
		root: 'lokaties',
		totalProperty: 'results',
		baseParams: {
			actie: 'alleLokaties',
			tabel: 'lokaties',
			column: 'name',
			orderby: 'name'
		},
		fields: [
			{
				name: 'plaatsid',
				mapping: 'id'
			},
			{
				name:'postcode',
				mapping:'code' 
			},
			{
				name:'stad',
				mapping:'stad' 
			},
			{
				name:'provincie',
				mapping:'provincie'
			}
		],
		proxy: new Ext.data.ScriptTagProxy({
		//proxy: new Ext.data.HttpProxy({
			url: 'update.php'
		})
		
	});
	
	var plaats_combo = new Ext.form.ComboBox({
		forceSelection: true,
		emptyText: 'Geef een plaatsnaam',
		displayField: 'stad',
		valueField : 'plaatsid',
		hiddenName : 'unitId',
		tpl: lokatieTpl,
		itemSelector: 'div.combo-result-item',
		//pageSize: 20,
		loadingText: 'Ophalen...',
		minChars: 2,
		triggerAction: 'all',
		store: lokatieStore,
		applyTo: 'plaats'
	});
	
});