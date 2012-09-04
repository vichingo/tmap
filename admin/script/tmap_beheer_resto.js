/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer resto
 */

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

$(function() {
	$('.keuze').attr("checked", false);
	
	//wijzigknop wegtoveren
	var wijzigKnop = $("#wijzig");
	wijzigKnop.hide();

	var checkbox;
	var lijnId;
	var ids = new Array();
	
	var 	a_naam 						= $("#a_naam"),
			a_taal 						= $("#a_taal"),
			a_lokatie_adres 			= $("#a_lokatie_adres"),
			a_lokatie_id 				= $("#a_lokatie_id"),
			a_leveringkosten_minimaal 	= $("#a_leveringkosten_minimaal"),
			a_allFields = $([])
							.add(a_naam)
							.add(a_taal)
							.add(a_lokatie_adres)
							.add(a_lokatie_id)
							.add(a_leveringkosten_minimaal),
			a_tips = $(".a_validateTips");

	var 	e_id						= $("#e_id"),
			e_naam 						= $("#e_naam"),
			e_taal 						= $("#e_taal"),
			e_lokatie_adres 			= $("#e_lokatie_adres"),
			e_lokatie_id 				= $("#e_lokatie_id"),
			e_leveringkosten_minimaal 	= $("#e_leveringkosten_minimaal"),
			e_allFields = $([])
							.add(e_id)
							.add(e_naam)
							.add(e_taal)
							.add(e_lokatie_adres)
							.add(e_lokatie_id)
							.add(e_leveringkosten_minimaal),
			e_tips = $(".e_validateTips");

	// tabellen gelijk houden
	
	var lijstBreedte = $("#lijst").width();
	if (lijstBreedte < 300){
		$("#lijst").width(300);
	}
	$("#knoppen").width($("#lijst").width() + 2);

	$('td').click(function(){
		$(this).parent(".item_rij").toggleClass('blauw');
		checkbox = $(this).siblings().find("input");
		if(checkbox.attr("checked") == true){
			wijzigKnop.button({ disabled: true });
			ids.pop(lijnId);
			lijnId = '';
			checkbox.attr("checked", false);
		} else {
			wijzigKnop.button({ disabled: false });
			lijnId = checkbox.val();
			ids.push(lijnId);
			checkbox.attr("checked", true);
		}
	});

	//buttons
	
	$('#maak').button({
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
			tabel	: 'resto',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'resto', id:lijnId},
                function(data){
					$("#e_id").val(data.records[0].id);
					$("#e_naam").val(data.records[0].naam);
					$("#e_taal").val(data.records[0].taal);
					$("#e_lokatie_adres").val(data.records[0].lokatie_adres);
					$("#e_lokatie_id").val(data.records[0].lokatie_id);
					$("#e_leveringkosten_minimaal").val(data.records[0].leveringkosten_minimaal);
                });
		$('#edit-form').dialog('open');
	});


	$("#showDelete").click(function(){
		$(".choice").toggleClass("hidden");
	});


	//ui forms
	
	$("#add-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			'Voeg toe'	: function() {
							var bValid = true;
							$.post("logic/create.php", {
								tabel				: 'resto',
								naam						: a_naam.val(),
								taal						: a_taal.val(),
								lokatie_adres				: a_lokatie_adres.val(),
								lokatie_id					: a_lokatie_id.val(),
								leveringkosten_minimaal		: a_leveringkosten_minimaal.val()
							});
							if (bValid){
								$(this).dialog('close');
								timedRefresh(300);
							}
						},
			Cancel		: function() {
							$(this).dialog('close');
						}
		},
		close: function() {
			a_allFields.val('').removeClass('ui-state-error');
		}
	});

	$("#edit-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'resto',
								id							: e_id.val(),
								naam						: e_naam.val(),
								taal						: e_taal.val(),
								lokatie_adres				: e_lokatie_adres.val(),
								lokatie_id					: e_lokatie_id.val(),
								leveringkosten_minimaal		: e_leveringkosten_minimaal.val()
							});
							if (bValid){
								$(this).dialog('close');
								timedRefresh(300);
								
							}
						},
			Cancel		: function() {
							$(this).dialog('close');
						}
		},
		close: function() {
			e_allFields.val('').removeClass('ui-state-error');
		}
	});
});