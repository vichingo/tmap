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
	a_login_naam = $("#a_login_naam"),
	a_login_wachtwoord = $("#a_login_wachtwoord"),
	a_allFields = $([]).add(a_naam).add(a_login_naam).add(a_login_wachtwoord),
	a_tips = $(".a_validateTips");

	var e_id = $("#e_id"),
	e_naam = $("#e_naam"),
	e_login_naam = $("#e_login_naam"),
	e_login_wachtwoord = $("#e_login_wachtwoord"),
	e_allFields = $([]).add(e_id).add(e_naam).add(e_login_naam).add(e_login_wachtwoord),
	e_tips = $(".e_validateTips");
	
	function updateTips(t) {
		a_tips
			.text(t)
			.addClass('ui-state-highlight');
		setTimeout(function() {
			a_tips.removeClass('ui-state-highlight', 1500);
		}, 500);
		e_tips
			.text(t)
			.addClass('ui-state-highlight');
		setTimeout(function() {
			e_tips.removeClass('ui-state-highlight', 1500);
		}, 500);
	}

	function checkLength(o,n,min,max) {

		if ( o.val().length > max || o.val().length < min ) {
			o.addClass('ui-state-error');
			updateTips("Lengte van " + n + " moet tussen de "+min+" en "+max+" liggen.");
			return false;
		} else {
			return true;
		}

	}
	

	function checkRegexp(o,regexp,n) {

		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass('ui-state-error');
			updateTips(n);
			return false;
		} else {
			return true;
		}

	}

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
			tabel	: 'gebruikers',
			id		: ids
		});
		timedRefresh(300);
	});

	$('#wijzig').button({
        icons: {
        	primary: 'ui-icon-wrench'
		}
    }).click(function() {
    	$.getJSON('logic/readLine.php', {tabel:'gebruikers', id:lijnId},
                function(data){
    				$("#e_id").val(data.records[0].id);
            		$("#e_naam").val(data.records[0].naam);
            		$("#e_login_naam").val(data.records[0].login_naam);
            		$("#e_login_wachtwoord").val(data.records[0].sesam);
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
							a_allFields.removeClass('ui-state-error');

							bValid = bValid && checkLength(a_login_naam,"de gebruikersnaam",3,16);
							//bValid = bValid && checkLength(email,"email",6,80);
							bValid = bValid && checkLength(a_login_wachtwoord,"het wachtwoord",5,16);
		
							bValid = bValid && checkRegexp(a_login_naam,/^[a-z]([0-9a-z_])+$/i,"Gebruikersnaam moet bestaan uit a-z, 0-9, underscores, en beginnen met een letter.");
							// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
							//bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
							bValid = bValid && checkRegexp(a_login_wachtwoord,/^([0-9a-zA-Z])+$/,"Wachtwoord veld alleen : a-z 0-9");
							
							if (bValid) {
							$.post("logic/create.php", {
								tabel				: 'gebruikers',
								naam				: a_naam.val(),
								login_naam			: a_login_naam.val(),
								login_wachtwoord	: a_login_wachtwoord.val()
							});
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
							bValid = bValid && checkLength(e_login_naam,"de gebruikersnaam",3,16);
							
							bValid = bValid && checkLength(e_login_wachtwoord,"het nieuwe wachtwoord",5,16);
							
		
							bValid = bValid && checkRegexp(e_login_naam,/^[a-z]([0-9a-z_])+$/i,"Gebruikersnaam moet bestaan uit a-z, 0-9, underscores, en beginnen met een letter.");
							// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
							//bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
							bValid = bValid && checkRegexp(e_login_wachtwoord,/^([0-9a-zA-Z])+$/,"Wachtwoord veld alleen : a-z 0-9");
							
							$.post("logic/update.php", {
								tabel					: 'gebruikers',
								id						: e_id.val(),
								naam					: e_naam.val(),
								login_naam				: e_login_naam.val(),
								login_wachtwoord		: e_login_wachtwoord.val()
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