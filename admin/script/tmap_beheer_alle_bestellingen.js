/**
 * @author Milo van Loon
 * @projectDescription VDAB Eindwerk Take me @way Pizza 24x7 beheer beheer alle bestellingen
 */

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

$(function() {
	
	// tabellen gelijk houden
	
	var lijstBreedte = $("#lijst").width();
	if (lijstBreedte < 300){
		$("#lijst").width(300);
	}
	
	$('.route_data').width(lijstBreedte);


	$('.itemLijst').click(function(e){
		$(e.target).parent(".item_rij").toggleClass('blauw');
		var idfull = $(this).attr('id');
		var split = idfull.split("_");
		var id = split[1];
		var klant_adres = $('#klant_adres_' + id).html();		
	});
	
	
	/*
	 * Verander het invoegmasker gebaseert op de gestelde "zoek_op_veld" waarde.
	 */
	$("select#zoek_op_veld").change(function(){
		var option = $("select#zoek_op_veld option:selected").val();
		switch(option) {
			case '2':
			    $("#zoek_veld_trefwoord").mask("99/99/99 99:99", {placeholder:" "}).focus();
			break;
			case '3':
			    $("#zoek_veld_trefwoord").mask("99/99/99 99:99", {placeholder:" "}).focus();
			break;
		}
	});
});