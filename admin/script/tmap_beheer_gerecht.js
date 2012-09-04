/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer gerecht_opties
 */

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

$(function() {
	$('.keuze').attr("checked", false);

	var checkbox;
	var lijnId;
	var ids = new Array();
	
	var a_image = $("#a_image"),
	a_naam = $("#a_naam"),
	a_omschrijving = $("#a_omschrijving"),
	a_code = $("#a_code"),
	a_basisprijs = $("#a_basisprijs"),
	a_menu_id 	= $("#a_menu_id"),
	a_allFields = $([]).add(a_image).add(a_naam).add(a_code).add(a_basisprijs).add(a_menu_id),
	a_tips = $(".a_validateTips");

	var e_id = $("#e_id"),
	e_image = $("#e_image"),
	e_naam = $("#e_naam"),
	e_omschrijving = $("#e_omschrijving"),
	e_code = $("#e_code"),
	e_basisprijs = $("#e_basisprijs"),
	e_menu_id 	= $("#e_menu_id"),
	e_allFields = $([]).add(e_id).add(e_image).add(e_naam).add(e_code).add(e_basisprijs).add(e_menu_id),
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
			ids.pop(lijnId);
			lijnId = '';
			checkbox.attr("checked", false);
		} else {
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
			tabel	: 'g',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'g', id:lijnId},
                function(data){
    				$("#e_id").val(data.records[0].id);
            		$("#e_image").val(data.records[0].image);
            		$("#e_naam").val(data.records[0].naam);
					$("#e_omschrijving").val(data.records[0].omschrijving);
            		$("#e_code").val(data.records[0].code);
            		$("#e_basisprijs").val(data.records[0].basisprijs);
            		$("#e_menu_id").val(data.records[0].menu_id);
                });
		$('#edit-form').dialog('open');
	});


	$("#showDelete").click(function(){
		$(".choice").toggleClass("hidden");
	});


	//ui forms
	
	$("#add-form").dialog({
		autoOpen: false,
		height: 500,
		width: 350,
		modal: true,
		buttons: {
			'Voeg toe'	: function() {
							var bValid = true;
							$.post("logic/create.php", {
								tabel				: 'g',
								image				: a_image.val(),
								naam				: a_naam.val(),
								omschrijving		: a_omschrijving.val(),
								code				: a_code.val(),
								basisprijs			: a_basisprijs.val(),
								menu_id				: a_menu_id.val()
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
		height: 500,
		width: 350,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'g',
								id					: e_id.val(),
								image				: e_image.val(),
								naam				: e_naam.val(),
								omschrijving		: e_omschrijving.val(),
								code				: e_code.val(),
								basisprijs			: e_basisprijs.val(),
								menu_id				: e_menu_id.val()
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