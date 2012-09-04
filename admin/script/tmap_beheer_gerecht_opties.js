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
	
	var a_naam = $("#a_naam"),
	a_allFields = $([]).add(a_naam),
	a_tips = $(".a_validateTips");

	var e_id = $("#e_id"),
	e_naam = $("#e_naam"),
	e_allFields = $([]).add(e_naam),
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
			tabel	: 'go',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'go', id:lijnId},
                function(data){
    				$("#e_id").val(data.records[0].id);
            		$("#e_naam").val(data.records[0].naam);
                });
		$('#edit-form').dialog('open');
	});


	$("#showDelete").click(function(){
		$(".choice").toggleClass("hidden");
	});


	//ui forms
	
	$("#add-form").dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		buttons: {
			'Voeg toe'	: function() {
							var bValid = true;
							$.post("logic/create.php", {
								tabel				: 'go',
								naam				: a_naam.val()
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
		height: 250,
		width: 350,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'go',
								id					: e_id.val(),
								naam				: e_naam.val()
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