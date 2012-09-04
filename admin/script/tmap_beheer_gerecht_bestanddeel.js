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
	
	var a_bestanddeel_id = $("#a_bestanddeel_id"),
	a_gerecht_id = $("#a_gerecht_id"),
	a_op_basis = $("#a_op_basis"),
	a_allFields = $([]).add(a_bestanddeel_id).add(a_gerecht_id).add(a_op_basis),
	a_tips = $(".a_validateTips");

	var e_gerecht_bestanddeel_id = $("#e_gerecht_bestanddeel_id"),
	e_bestanddeel_id = $("#e_bestanddeel_id"),
	e_gerecht_id = $("#e_gerecht_id"),
	e_op_basis = $("#e_op_basis"),
	e_allFields = $([]).add(e_gerecht_bestanddeel_id).add(e_bestanddeel_id).add(e_gerecht_id).add(e_op_basis),
	e_tips = $(".e_validateTips");

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
			tabel	: 'gb',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'gb', id:lijnId},
                function(data){
    				$("#e_gerecht_bestanddeel_id").val(data.records[0].gerechtBestanddeelId);
            		$("#e_bestanddeel_id").val(data.records[0].bestanddeelId);
            		$("#e_gerecht_id").val(data.records[0].gerechtId);
					$("#e_op_basis").val(data.records[0].op_basis);
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
							if ($("#a_op_basis").attr('checked')){
								$("#a_op_basis").val(1);
							} else {
								$("#a_op_basis").val(0);
							}
							$.post("logic/create.php", {
								tabel				: 'gb',
								bestanddeel_id		: a_bestanddeel_id.val(),
								gerecht_id			: a_gerecht_id.val(),
								op_basis			: a_op_basis.val()
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
							if ($("#e_op_basis").attr('checked')){
								$("#e_op_basis").val(1);
							} else {
								$("#e_op_basis").val(0);
							}
							$.post("logic/update.php", {
								tabel					: 'gb',
								id						: e_gerecht_bestanddeel_id.val(),
								bestanddeel_id			: e_bestanddeel_id.val(),
								gerecht_id				: e_gerecht_id.val(),
								op_basis				: e_op_basis.val()
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