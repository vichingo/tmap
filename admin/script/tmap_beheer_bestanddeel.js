/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer bestanddeel
 */



function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

$(function() {
	$('.keuze').attr("checked", false);

	var checkbox;
	var lijnId;
	var ids = new Array();
	
	var a_naam = $("#a_naam"),
	a_code = $("#a_code"),
	a_prijs = $("#a_prijs"),
	a_voedsel_categorie_id = $("#a_voedsel_categorie_id"),
	a_allFields = $([]).add(a_naam).add(a_code).add(a_voedsel_categorie_id),
	a_tips = $(".a_validateTips");

	var e_id = $("#e_id"),
	e_naam = $("#e_naam"),
	e_code = $("#e_code"),
	e_prijs = $("#e_prijs"),
	e_voedsel_categorie_id = $("#e_voedsel_categorie_id"),
	e_allFields = $([]).add(e_naam).add(e_code).add(e_voedsel_categorie_id),
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
			tabel	: 'bd',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'bd', id:lijnId},
                function(data){
    				$("#e_id").val(data.records[0].id);
            		$("#e_naam").val(data.records[0].bestanddeel);
            		$("#e_code").val(data.records[0].code);
            		$("#e_prijs").val(data.records[0].prijs);
            		$("#e_voedsel_categorie_id").val(data.records[0].voedsel_categorie_id);
                });
		$('#edit-form').dialog('open');
	});


	$("#showDelete").click(function(){
		$(".choice").toggleClass("hidden");
	});


	//ui forms
	
	$("#add-form").dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		buttons: {
			'Voeg toe'	: function() {
							var bValid = true;
							$.post("logic/create.php", {
								tabel				: 'bd',
								naam				: a_naam.val(),
								code				: a_code.val(),
								prijs				: a_prijs.val(),
								voedsel_categorie_id: a_voedsel_categorie_id.val()
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
		height: 350,
		width: 400,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'bd',
								id					: e_id.val(),
								naam				: e_naam.val(),
								code				: e_code.val(),
								prijs				: e_prijs.val(),
								voedsel_categorie_id: e_voedsel_categorie_id.val()
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