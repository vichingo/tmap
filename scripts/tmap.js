/**
 * @author Milo van Loon
 */

/*
 * algemene functions 
 * @note to self: misschien beter in een apart tardis.js bestand..
 */

function randomString(str_len) {
	var chars = "0123456789";
	var string_length = str_len;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

var geocoder;
var map;
//  function googleInit() {
//    geocoder = new google.maps.Geocoder();
//    var latlng = new google.maps.LatLng(51.1578438, 4.1610526);
//    var myOptions = {
//      zoom: 15,
//      center: latlng,
//      mapTypeId: google.maps.MapTypeId.ROADMAP
//    }
//    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
//  }
//
//  function codeAddress() {
//    var address = document.getElementById("resto_adres").firstChild.data;
//    geocoder.geocode( { 'address': address}, function(results, status) {
//      if (status == google.maps.GeocoderStatus.OK) {
//        map.setCenter(results[0].geometry.location);
//        var marker = new google.maps.Marker({
//            map: map, 
//            position: results[0].geometry.location
//        });
//      } else {
//        alert("Geocode was not successful for the following reason: " + status);
//      }
//    });
//  }


$(function() {
//	$('#map_canvas').width(500);
//	$('#map_canvas').height(500);

var temp_veld_waarde;
var temp_select_waarde;

var promo_width 		= $("#promotie_1").css('width');
var promoties 			= $(".promotie");
var aantal_promoties 	= promoties.length;
promo_width 			= parseInt(promo_width);
var promos_width 		= aantal_promoties * (promo_width + 20);
var screen_width 		= $(document).width();
if (promos_width >= screen_width){
	promos_width 		= screen_width;
}
$("#promoblok").css('width', promos_width);
	

	
	var ids = new Array();
	
	$('.gerecht_keuze').attr("checked", false);
	
	var pdk = $("#product_detailkolom");
	var pdr = $(".lijn_data");
	var rk 	= $("#reservatie_keuze_box");
	var vbk = $("#verwerk_bestelling_knop");
	var lwk = $("#leverwijze_keuze");
	var ri	= $("#reservatie_input"); // reservatie blok om te tonen
	var rbk	= $("#reservatie_knop"); // knop om rb te tonen en te verbergen
	
	/*
	 * Verberg sommige velden(divs)
	 * en toon die later als aan de condities voldaan is.
	 * 
	 */
	pdr.each(function(){
		$(this).hide();
	});
	rk.hide();
	vbk.hide();
	lwk.hide();
	ri.hide();
	
	var mandjelijnen = $("#mandjelijnen").children();
	var aantal_mlijnen = mandjelijnen.length;
	if (aantal_mlijnen > 0){
		rk.show();
		vbk.show();
		lwk.show();
	}
	
	
	/*
	 * wijzig de details prijs gebaseert op welke 
	 * matrix waarde er in de dropdown menu's 
	 * gebruikt wordt
	 */
	
	var current_id;
	var product_opties = $(".product_optie");
	
	
	function getMatrix(id){
		var matrix = 1;
		$optie = $("#gerecht_"+id).children().contents().find(".product_optie");
		$optie.each(function(){
			var idmatrix = $(this).val();
			var split = idmatrix.split('_');
			matrix *= split[1];
		});
		return matrix;
	}
	
	
	product_opties.change(function(){
		var matrix = getMatrix(current_id);
		var prijs = $("#gerecht_basisprijs_"+current_id).html();
		var result = prijs * matrix;
		var totaalprijs = result.toFixed(2);
		$("#matrix_prijs_"+current_id).html(" x " + matrix.toFixed(2) + " = &#8364; " + result.toFixed(2));
		$("#gerecht_prijs_"+current_id).val(totaalprijs);
	});
	
	/*
	 * Bouw een datepicker voor de reservaties
	 * 
	 */
	
	
	var huidigeTijd = new Date()
  	var uur = huidigeTijd.getHours()
  	var minuten = huidigeTijd.getMinutes();
	if (minuten <= 20){
		minuten += 40;
	} else {
		uur++;
		minuten = (minuten + 40) - 60;
	}
	
	$("#reservatie_datum_tijd").datetimepicker({
		timeFormat: 'hh:mm',
		hour: uur,
		minute: minuten,
		stepMinute: 10,
		minDate: -0,
		showAnim: 'fadeIn',
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: 'both',
		buttonImage: 'images/fugue/icons/_overlay/calendar--pencil.png',
		buttonImageOnly: true,
		buttonText: 'Klik om lever datum en tijd te selecteren',
		dateFormat: 'dd/mm/yy',
		altField: '#unixTijd',
		altFormat: '@'
	});
	
//	$('#reservatietijd').clockpick({
//		starthour 	: 0,
//		endhour 	: 23,
//		military	: true,
//		showminutes : true
//		}
//	);
	
	/*
	 * Wat moet er gebeuren als we een gerecht kiezen?
	 * 
	 */
	
	$('td.gerecht_lijn').mouseover().css('cursor', 'pointer');
	$('td.gerecht_lijn').click(function(e){
		var target = $(e.target);
		var gerecht_rij = $(this).parent(".gerecht_rij");
		var lijn_ids = $(this).attr('id');//e.target.id;
		var lijnsplit = lijn_ids.split('_');
		var lijn_id = lijnsplit[1];
		var prijs = $(".gerecht_prijs_"+lijn_id).html();
		current_id = lijn_id;
		gerecht_rij.toggleClass('blauw kantje_rechts');
		var afwijking			= 170;
		var screen_height		= $(document).height();
		var container_position 	= $(this).position();//target.position();
		var container_height	= $(this).height();
		var datablok_height		= $("#gerecht_"+lijn_id).height();
		var marge				= datablok_height;
		if (container_position.top + container_height > screen_height - marge){
			//console.log('te_ver');
			$("#gerecht_"+lijn_id).css({
				'position': 'relative',
				'top': container_position.top - 310
			});
		} else {
			//console.log('ruimte te over');
			$("#gerecht_"+lijn_id).css({
				'position': 'relative',
				'top': container_position.top - afwijking
			});
		}
		
		//console.log("cpt + ch: " + (container_position.top + container_height) + "  sh - dbh: " + (screen_height - datablok_height) + "  sh " +screen_height + "  cpt: " + container_position.top + "  ch: " + container_height + "  dbh: " + datablok_height);
		
		gerecht_rij.siblings().removeClass('blauw').removeClass('kantje_rechts');
		var option = $(".optionbar").contents().find("option");
		option.each(function() {
			var needle = /normaal/i;
			var haystack = $(this).html();
			if (haystack.search(needle) != -1){
				$(this).attr('selected', 'selected')
			}
        });
		
		// verberg of toon mogelijke gerecht opties
			var result = parseFloat(prijs);
			result = result.toFixed(2);
			var firstMatrix = getMatrix(lijn_id);
			firstMatrix = firstMatrix.toFixed(2);
			var total = result * firstMatrix;
			total = total.toFixed(2);
			$("#matrix_prijs_"+lijn_id).html(" x " + firstMatrix + " = &#8364; " + total);
			$("#gerecht_"+lijn_id).show();
			$("#gerecht_"+lijn_id).siblings().hide();
	});
	
	rbk.click(function(e){
		ri.toggle("fast");
		$("#reservatie_datum_tijd").val('');
	});
	
	//kleur de verschillende tabellen en lijstjes om en om
	$("#bestel_lijst tbody tr:odd").css("background-color", "#BBBBFF");
	$("#bestel_lijst tbody tr:even").css("background-color", "#FFEDBB");
	$(".mandjelijn:odd").css("background-color", "#BBBBFF");
	$(".mandjelijn:even").css("background-color", "#FFEDBB");
	
	$("#kd_bestel_lijst  tbody tr:odd").css("background-color", "#FFEDBB");
	$("#kd_bestel_lijst  tbody tr:even").css("background-color", "#81D0FF");

	//promoties aansturen
	
	$("#open").click(function(){
		$("div#promoties").slideDown("slow");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#promoties").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$(".promo_tab div").click(function () {
		$(".promo_tab div").toggle();
	});	
	
	
	// gastenboek bericht karakter teller
	var karakters_toegestaan	= $('.karakters_toegestaan>span');
	var karakters_tegoed		= $('.karakters_tegoed>span');
	karakters_toegestaan.text('250');
	karakters_tegoed.text('250');
	$('p.karakters_erover').hide();
	
	$('#gb_bericht').keypress(function(event) {
        var len = $(this).val().length;				
        $('.karakters_tegoed>span').text(250 - len);
		var teveel= false;
        if (len >= 250) {
			$(this).val($(this).val().substring(0, 249));
			teveel = true;
        }
		if (teveel == true){
				$('p.karakters_erover').text('U mag maar max 250 karakters ingeven!').show();
		} else {
			$('p.karakters_erover').text('').hide();
		}
		
    });
	
	// extra functionaliteit voor de velden die al ingevuld zijn meer aanpasbaar moeten zijn.
	
	$('input.alleen_lezen').click(function(e){
		if($(e.target).attr("readonly") == true){
			temp_veld_waarde = $(this).val();
			$(e.target).prev("label").children("span").fadeOut("slow", 0.50).empty();
			$(this).attr('readonly', false).fadeTo("slow", 1);
		} else {
			$(e.target).attr('readonly', true);
		}
	});
	
	$('input.alleen_lezen').blur(function(e){
		var nieuw_waarde = $(this).val();
		if($(e.target).attr("readonly") == false){
			if (temp_veld_waarde == nieuw_waarde && nieuw_waarde != ''){
				$(e.target).prev("label").children("span").append("<strong>ongewijzigd</strong>").fadeTo("slow", 0.50);
			} else if (nieuw_waarde == '') {
				$(e.target).prev("label").children("span").append("<strong>leeg</strong>").fadeTo("slow", 0.50);
			} else {
				$(e.target).prev("label").children("span").append("<strong>gewijzigd</strong>").fadeTo("slow", 0.50);
			}
			$(e.target).attr('readonly', true).fadeTo("slow", 0.40);
		}
	});
	
	// en omdat ook de selects dezelfde functionaliteit moeten hebben.
	
	$('.enable_list').click(function(e){
		if($('select.alleen_lezen').attr("disabled") == true){
			$(this).attr('src', 'images/fugue/icons/ui-combo-box-blue.png');
			temp_select_waarde = $('select.alleen_lezen').val();
			$('select.alleen_lezen').prev("label").children("span").fadeOut("slow", 0.50).empty();
			$('select.alleen_lezen').attr('disabled', false).fadeTo("slow", 1);
		} else {
			$('select.alleen_lezen').attr('disabled', true);
			
			$(this).attr('src', 'images/fugue/icons/ui-combo-box-edit.png');
		}
	});
	

	$('select.alleen_lezen').change(function(e){
		var nieuw_waarde = $('select.alleen_lezen').val();
		if($('select.alleen_lezen').attr("disabled") == false){
			if (temp_veld_waarde == nieuw_waarde && nieuw_waarde != ''){
				$('select.alleen_lezen').prev("label").children("span").append("<strong>ongewijzigd</strong>").fadeTo("slow", 0.50);
			} else {
				$('select.alleen_lezen').prev("label").children("span").append("<strong>gewijzigd</strong>").fadeTo("slow", 0.50);
			}
			$('select.alleen_lezen').attr('disabled', true).fadeTo("slow", 0.40);
		}
	});

});