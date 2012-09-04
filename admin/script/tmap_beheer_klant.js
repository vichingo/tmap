/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer klant
 */
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);", timeoutPeriod);
}

$(function() {
	$('.keuze').attr("checked", false);
	//wijzigknop wegtoveren
	var wijzigKnop = $("#wijzig");
	//wijzigKnop.hide();
	
	
	var checkbox;
	var lijnId;
	var ids = new Array();
	
	var 	a_achternaam 	= $("#a_achternaam"), 
			a_voornaam 		= $("#a_voornaam"), 
			a_straat 		= $("#a_straat"), 
			a_straat_nummer = $("#a_straat_nummer"), 
			a_nummer_bus 	= $("#a_nummer_bus"), 
			a_lokatie_id 	= $("#a_lokatie_id"), 
			a_tel_vast 		= $("#a_tel_vast"), 
			a_tel_gsm 		= $("#a_tel_gsm"), 
			a_email 		= $("#a_email"), 
			a_wachtwoord 	= $("#a_wachtwoord"), 
			a_aanmaakdatum 	= $("#a_aanmaakdatum"), 
			a_geblokkeerd 	= $("#a_geblokkeerd"), 
			a_promotie 		= $("#a_promotie"), 
			a_allFields = $([])
				.add(a_achternaam)
				.add(a_voornaam)
				.add(a_straat)
				.add(a_straat_nummer)
				.add(a_nummer_bus)
				.add(a_lokatie_id)
				.add(a_tel_vast)
				.add(a_tel_gsm)
				.add(a_email)
				.add(a_wachtwoord)
				.add(a_aanmaakdatum)
				.add(a_geblokkeerd)
				.add(a_promotie), 
			a_tips = $(".a_validateTips");
	
	var 	e_id		 	= $("#e_id"),
			e_achternaam 	= $("#e_achternaam"), 
			e_voornaam 		= $("#e_voornaam"), 
			e_straat 		= $("#e_straat"), 
			e_straat_nummer = $("#e_straat_nummer"), 
			e_nummer_bus 	= $("#e_nummer_bus"), 
			e_lokatie_id 	= $("#e_lokatie_id"), 
			e_tel_vast 		= $("#e_tel_vast"), 
			e_tel_gsm 		= $("#e_tel_gsm"), 
			e_email 		= $("#e_email"), 
			e_wachtwoord 	= $("#e_wachtwoord"), 
			e_aanmaakdatum 	= $("#e_aanmaakdatum"), 
			e_geblokkeerd 	= $("#e_geblokkeerd"), 
			e_promotie 		= $("#e_promotie"), 
			e_allFields = $([])
				.add(e_id)
				.add(e_achternaam)
				.add(e_voornaam)
				.add(e_straat)
				.add(e_straat_nummer)
				.add(e_nummer_bus)
				.add(e_lokatie_id)
				.add(e_tel_vast)
				.add(e_tel_gsm)
				.add(e_email)
				.add(e_wachtwoord)
				.add(e_aanmaakdatum)
				.add(e_geblokkeerd)
				.add(e_promotie), 
			e_tips = $(".e_validateTips");
	// tabellen gelijk houden
	
	var lijstBreedte = $("#lijst").width();
	if (lijstBreedte < 300) {
		$("#lijst").width(300);
	}
	$("#knoppen").width($("#lijst").width() + 2);
	
	$('td').click(function(e) {
		var target = $(e.target);
		target.parent(".item_rij").toggleClass('blauw');
		lijnId = target.parent().attr('id');
		checkbox = target.siblings().find("input");
		if (checkbox.attr("checked") == true) {
			wijzigKnop.button({ disabled: true });
			ids.pop(lijnId);
			lijnId = '';
			checkbox.attr("checked", false);
		} else {
			wijzigKnop.button({ disabled: false });
			ids.push(lijnId);
			checkbox.attr("checked", true);
		}
	});
	
	//buttons
	
	$('#maak').button({
		disabled: false,
		icons: {
			primary: 'ui-icon-plus'
		}
	}).click(function() {
		$('#add-form').dialog('open');
	});
	
	
	$('#verwijder').button({
		icons: {
			primary: 'ui-icon-minus'
		}
	}).click(function() {
		$.post("logic/delete.php", {
			tabel: 'klant',
			id: ids
		});
		timedRefresh(300);
	});
	
	wijzigKnop.button({
		disabled: true,
		icons: {
			primary: 'ui-icon-wrench'
		}
	}).click(function() {
		$.getJSON('logic/readLine.php', {
			tabel: 'klant',
			id: lijnId
		}, function(data) {    
			$("#e_id").val(data.records[0].id);    
			$("#e_achternaam").val(data.records[0].achternaam);  
			$("#e_voornaam").val(data.records[0].voornaam);    
			$("#e_straat").val(data.records[0].straat);      
			$("#e_straat_nummer").val(data.records[0].straat_nummer);
			$("#e_nummer_bus").val(data.records[0].nummer_bus);  
			$("#e_lokatie_id").val(data.records[0].lokatie_id);  
			$("#e_tel_vast").val(data.records[0].tel_vast);    
			$("#e_tel_gsm").val(data.records[0].tel_gsm);     
			$("#e_email").val(data.records[0].email);       
			$("#e_wachtwoord").val(data.records[0].wachtwoord);  
			$("#e_aanmaakdatum").val(data.records[0].aanmaakdatum);
			if(data.records[0].geblokkeerd != 0){
				$("#e_geblokkeerd").attr('checked', true);
			} else {
				$("#e_geblokkeerd").attr('checked', false);
			}
			if(data.records[0].promotie != 0){
				$("#e_promotie").attr('checked', true);
			} else {
				$("#e_promotie").attr('checked', false);
			}
		});
		$('#edit-form').dialog('open');
	});
	
	
	$("#showDelete").click(function() {
		$(".choice").toggleClass("hidden");
	});
	
	
	//ui forms
	
	$("#add-form").dialog({
		autoOpen: false,
		height: 700,
		width: 400,
		modal: true,
		buttons: {
			'Voeg toe': function() {
				var bValid = true;
				if (a_geblokkeerd.is(':checked')){
					a_geblokkeerd.val(1);
				} else {
					a_geblokkeerd.val(0);
				}
				
				if (a_promotie.is(':checked')){
					a_promotie.val(1);
				} else {
					a_promotie.val(0);
				}
				
				$.post("logic/create.php", {
					tabel: 'klant',
					achternaam		: a_achternaam.val(), 	
					voornaam		: a_voornaam.val(), 		
					straat			: a_straat.val(), 		
					straat_nummer 	: a_straat_nummer.val(), 
					nummer_bus 	  	: a_nummer_bus.val(), 	
					lokatie_id 	 	: a_lokatie_id.val(), 	
					tel_vast 		: a_tel_vast.val(),		
					tel_gsm 		: a_tel_gsm.val(), 		
					email 		 	: a_email.val(), 		
					wachtwoord 	  	: a_wachtwoord.val(), 	
					aanmaakdatum 	: a_aanmaakdatum.val(), 	
					geblokkeerd 	: a_geblokkeerd.val(), 	
					promotie 		: a_promotie.val()
				});
				if (bValid) {
					$(this).dialog('close');
					timedRefresh(300);
				}
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {
			a_allFields.val('').removeClass('ui-state-error');
		}
	});
	
	$("#edit-form").dialog({
		autoOpen: false,
		height: 700,
		width: 400,
		modal: true,
		buttons: {
			'Wijzig': function() {
				var bValid = true;
				
				if (e_geblokkeerd.is(':checked')){
					e_geblokkeerd.val(1);
				} else {
					e_geblokkeerd.val(0);
				}
				
				if (e_promotie.is(':checked')){
					e_promotie.val(1);
				} else {
					e_promotie.val(0);
				}
				
				$.post("logic/update.php", {
					tabel: 'klant',
					id				: e_id.val(),
					achternaam		: e_achternaam.val(), 	
					voornaam		: e_voornaam.val(), 	
					straat			: e_straat.val(), 		
					straat_nummer 	: e_straat_nummer.val(),
					nummer_bus 	  	: e_nummer_bus.val(), 	
					lokatie_id 	 	: e_lokatie_id.val(), 	
					tel_vast 		: e_tel_vast.val(),		
					tel_gsm 		: e_tel_gsm.val(), 		
					email 		 	: e_email.val(), 		
					wachtwoord 	  	: e_wachtwoord.val(), 	
					aanmaakdatum 	: e_aanmaakdatum.val(), 
					geblokkeerd 	: e_geblokkeerd.val(), 	
					promotie 		: e_promotie.val()
				});
				if (bValid) {
					$(this).dialog('close');
					timedRefresh(300);
					
				}
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {
			e_allFields.val('').removeClass('ui-state-error');
		}
	});
});
