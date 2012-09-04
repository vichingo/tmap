/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer FAQ
 */

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

$(function() {
	$('.keuze').attr("checked", false);
	
	//wijzigknop wegtoveren
	var wijzigKnop = $("#wijzig");
	wijzigKnop.hide();
	
	var volgorde;
		
	var laatste_vraag = $("div.item:last div.kop").attr('id');
	if(laatste_vraag){
		var laatste_vraag_stukjes = laatste_vraag.split("_");
		volgorde = parseInt(laatste_vraag_stukjes[1]);
	} else {
		volgorde = 0;
	}

	var lijnId;
	var ids = new Array();
	
	var 	a_vraag						= $("#a_vraag"),
			a_antwoord					= $("#a_antwoord"),
			a_allFields = $([])
							.add(a_vraag)
							.add(a_antwoord),
			a_tips = $(".a_validateTips");

	var 	e_id						= $("#e_id"),
			e_vraag						= $("#e_vraag"),
			e_antwoord					= $("#e_antwoord"),
			e_volgorde					= $("#e_volgorde"),
			e_allFields = $([])
							.add(e_vraag)
							.add(e_antwoord),
			e_tips = $(".e_validateTips");

	// tabellen gelijk houden
	
//	var lijstBreedte = $("#lijst").width();
//	if (lijstBreedte < 300){
//		$("#lijst").width(300);
//	}
//	$("#knoppen").width($("#lijst").width() + 2);

	$('div.item').click(function(e){
		$(this).toggleClass('blauw selected');
		ids = new Array();
		
		$('div.selected').each(function(){
			lijn_ids = $(this).attr('id');
			var lijnsplit = lijn_ids.split('_');
			var lijn_id = lijnsplit[1];
			lijnId = lijn_id;
			ids.push(lijn_id);			
		});
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
			tabel	: 'faq',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'faqs', id:lijnId},
                function(data){
					$("#e_id").val(data.records[0].id);
					$("#e_vraag").val(data.records[0].vraag);
					$("#e_antwoord").val(data.records[0].antwoord);
					$("#e_volgorde").val(data.records[0].volgorde);
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
								tabel				: 'faqs',
								vraag						: a_vraag.val(),
								antwoord					: a_antwoord.val(),
								volgorde					: volgorde+1,
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
								tabel				: 'faqs',
								id							: e_id.val(),
								vraag						: e_vraag.val(),
								antwoord					: e_antwoord.val(),
								volgorde					: e_volgorde.val()
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

	$("#sorteer_lijst").sortable({
		//containment: 'parent',
		placeholder: 'ui-state-highlight',
		distance: 15,
		revert: true,
		cursor: 'move',
		update : function () {
			$(this).children('div.item').removeClass('blauw selected');
			serial = $('#sorteer_lijst').sortable('serialize');
			$.ajax({
				url: "logic/update.php?act=sorteren",
				type: "post",
				data: serial,
				error: function(){
					alert("theres an error with AJAX");
				}
			});
		}
	});
	$("#sorteer_lijst").disableSelection();

});