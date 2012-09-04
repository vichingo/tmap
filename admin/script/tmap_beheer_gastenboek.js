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
	
	var 	e_id			= $("#e_id"),
			e_naam 			= $("#e_naam"),
			e_email			= $("#e_email"),
			e_bericht 		= $("#e_bericht"),
			e_post_tijd 	= $("#e_post_tijd"),
			e_ip			= $("#e_ip"),
			e_allFields = $([])
							.add(e_id)
							.add(e_naam)
							.add(e_email)
							.add(e_bericht)
							.add(e_post_tijd)
							.add(e_ip),
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
	
	
	$('#verwijder').button({
        icons: {
			primary: 'ui-icon-minus'
		}
	}).click(function() {
		$.post("logic/delete.php", {
			tabel	: 'gastenboek',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'gastenboek', id:lijnId},
                function(data){
					$("#e_id").val(data.records[0].id);
					$("#e_naam").val(data.records[0].naam);
					$("#e_email").val(data.records[0].email);
					$("#e_bericht").val(data.records[0].bericht);
					$("#e_post_tijd").val(data.records[0].post_tijd);
					$("#e_ip").val(data.records[0].ip);
                });
		$('#edit-form').dialog('open');
	});


	$("#showDelete").click(function(){
		$(".choice").toggleClass("hidden");
	});


	//ui forms
	

	$("#edit-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			'Wijzig'	: function() {
							var bValid = true;
							$.post("logic/update.php", {
								tabel				: 'gastenboek',
								id			: e_id.val(),
								naam		: e_naam.val(),
								email		: e_email.val(),
								bericht		: e_bericht.val(),
								post_tijd	: e_post_tijd.val(),
								ip			: e_ip.val()
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