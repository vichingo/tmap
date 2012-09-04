/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer variant
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
	a_matrix = $("#a_matrix"),
	a_optie_id = $("#a_optie_id"),
	a_allFields = $([]).add(a_naam).add(a_matrix).add(a_optie_id),
	a_tips = $(".a_validateTips");

	var e_id = $("#e_id"),
	e_naam = $("#e_naam"),
	e_matrix = $("#e_matrix"),
	e_optie_id = $("#e_optie_id"),
	e_allFields = $([]).add(e_id).add(e_matrix).add(e_optie_id),
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
			tabel	: 'ov',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'ov', id:lijnId},
                function(data){
    				$("#e_id").val(data.records[0].id);
            		$("#e_naam").val(data.records[0].variatie);
            		$("#e_matrix").val(data.records[0].matrix);
            		$("#e_optie_id").val(data.records[0].optie_id);
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
		width: 350,
		modal: true,
		buttons: {
			'Voeg toe'	: function() {
							var bValid = true;
							$.post("logic/create.php", {
								tabel				: 'ov',
								variatie			: a_naam.val(),
								matrix				: a_matrix.val(),
								optie_id			: a_optie_id.val()
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
		width: 350,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'ov',
								id					: e_id.val(),
								variatie			: e_naam.val(),
								matrix				: e_matrix.val(),
								optie_id			: e_optie_id.val()
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