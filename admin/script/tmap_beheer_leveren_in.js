/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer resto
 */

function refresh(){
	timedRefresh(300);
}

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
	
	var 	a_resto_id 					= $("#a_resto_id"),
			a_lokatie_id 				= $("#a_lokatie_id"),
			a_leveringkost 				= $("#a_leveringkost"),
			a_allFields = $([])
							.add(a_resto_id)
							.add(a_lokatie_id)
							.add(a_leveringkost),
			a_tips = $(".a_validateTips");

	var 	e_id						= $("#e_id"),
			e_resto_id 					= $("#e_resto_id"),
			e_lokatie_id 				= $("#e_lokatie_id"),
			e_leveringkost 				= $("#e_leveringkost"),
			e_allFields = $([])
							.add(e_id)
							.add(e_resto_id)
							.add(e_lokatie_id)
							.add(e_leveringkost),
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
		refresh();
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'li', id:lijnId},
                function(data){
					$("#e_id").val(data.records[0].id);
					$("#e_resto_id").val(data.records[0].resto_id);
					$("#e_lokatie_id").val(data.records[0].lokatie_id);
					$("#e_leveringkost").val(data.records[0].leveringkost);
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
								tabel				: 'li',
								resto_id			: a_resto_id.val(),
								lokatie_id			: a_lokatie_id.val(),
								leveringkost		: a_leveringkost.val()
							});
							if (bValid){
								$(this).dialog('close');
								refresh();
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
								tabel				: 'li',
								id					: e_id.val(),
								resto_id			: e_resto_id.val(),
								lokatie_id			: e_lokatie_id.val(),
								leveringkost		: e_leveringkost.val()
							});
							if (bValid){
								$(this).dialog('close');
								refresh();
								
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