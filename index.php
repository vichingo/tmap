<?php
	//session & cookies
	session_start();
	$session_id = session_id();
	//setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1'));





	// wensput


//	echo '<br />';
//	echo '<pre>';
//		var_dump($_POST);
//	echo '</pre>';


	//includes
	/* Autoload de klassen */
	require_once 'includes/objecten.php';

	require 'lib/smarty/Smarty.class.php';
	/* Smarty initialiseren */
	$smarty = new Smarty();

	//$smarty->compile_check = true;
//	$smarty->debugging = true;
	//$smarty->debugging = false;
	//$smarty->cache = false;
	//$smarty->force_compile = true;



	//set variabelen
	define("RESTOID", '1');
	$bezorg_kosten = 2;

	if(isset($_COOKIE['klant']['klant_id'])){

		$kl_id 			= $_COOKIE['klant']['klant_id'];
		$kl_loc_id 		= $_COOKIE['klant'][$kl_id]['lokatie_id'];

		$lk_klant = new tmap();
		$lk_klant->table_arr = array("leveren_in l","klant k", "resto r");
		$lk_klant->column_arr = array("l.leveringkost");
		$lk_klant->where_arr = array("k.id" => $kl_id ,"l.lokatie_id" => $kl_loc_id, "l.resto_id" => RESTOID);
		$lk_klant->lijst = $lk_klant->lezen();
		$lk_klant_lijst = $lk_klant->lijst;

		$bezorg_kosten = $lk_klant_lijst[0]->leveringkost;

	}
	/*
	 * koppel variabelen/ arrays aan smarty
	 *
	 */

	// strings en nummers
	$smarty->assign('bezorg_kosten',$bezorg_kosten);
	if (isset($_SESSION["fouten"])){
		$smarty->assign('fouten',$_SESSION["fouten"]);
	}

	if (!empty($_POST["reservatie_datum_tijd"])){
		$reservatie_datum = $_POST["reservatie_datum_tijd"];
		$smarty->assign('reservatie', true);
		$reservatie_stukjes = explode(' ', $reservatie_datum);
		$date = $reservatie_stukjes[0];
		$time = $reservatie_stukjes[1];
		// assign aan smarty variabelen
		$smarty->assign('reservatiedatum', $date);
		$smarty->assign('reservatietijd', $time);

		$date_stukje = explode('/', $date);
		$time_stukje = explode(':', $time);
		$r_d_unix = mktime($time_stukje[0], $time_stukje[1], null, $date_stukje[1], $date_stukje[0], $date_stukje[2]);
		$_SESSION['reservatie_tijd'] = $r_d_unix;

	}

	if(isset($_SESSION['levertijd_is_vroeger']) && $_SESSION['levertijd_is_vroeger'] == true){
		$smarty->assign('levertijd_is_vroeger', true);
	}

	if (isset($_POST["leverwijze_id"])){
		$leverwijze_id 					= $_POST["leverwijze_id"];
		$leverwijze_naam 				= new leverwijze();
		$leverwijze_naam->table_arr		= array('leverwijze l');
		$leverwijze_naam->column_arr	= array('l.naam');
		$leverwijze_naam->where_arr		= array('l.id' => $leverwijze_id);
		$leverwijze_naam->lijn			= $leverwijze_naam->lezen();
		$leverwijze_naam_lijn			= $leverwijze_naam->lijn;
		$_SESSION["leverwijze_id"] 		= $leverwijze_id;
		$smarty->assign('leverwijze_id', $leverwijze_id);
		$smarty->assign('leverwijze_naam', $leverwijze_naam_lijn[0]->naam);
	} else if (isset($_SESSION["leverwijze_id"])){
		$leverwijze_id 					= $_SESSION["leverwijze_id"];
		$leverwijze_naam 				= new leverwijze();
		$leverwijze_naam->table_arr		= array('leverwijze l');
		$leverwijze_naam->column_arr	= array('l.naam');
		$leverwijze_naam->where_arr		= array('l.id' => $leverwijze_id);
		$leverwijze_naam->lijn			= $leverwijze_naam->lezen();
		$leverwijze_naam_lijn			= $leverwijze_naam->lijn;
		$smarty->assign('leverwijze_id', $leverwijze_id);
		$smarty->assign('leverwijze_naam', $leverwijze_naam_lijn[0]->naam);
	}


	//objecten
	//$smarty->assign('bestanddeel',$bestanddeel_lijst);
	$smarty->assign('gerechten', $gerecht_lijst);
	//$smarty->assign('gerecht_bestanddelen', $gerecht_bestanddeel_lijst);
	//$smarty->assign('gerecht_bestanddelen_rijen', $gerecht_bestanddeel_lijst);
	$smarty->assign('aantal_opties', $aantal_opties);
	$smarty->assign('gerecht_optie', $optie_lijst);
	$smarty->assign('optie_variatie', $optie_variant_lijst);
	$smarty->assign('lokaties', $lokatie_lijst);
	$smarty->assign('leverwijze_lijst', $leverwijze_lijst);
	$smarty->assign('leveren_in', $lever_locatie_lijst);
	$smarty->assign('resto_lokatie', $resto_adres_string);

	$leveringkosten_minimaal = $mijn_restaurant_lijst[0]->leveringkosten_minimaal;
	$smarty->assign('leveringkosten_minimaal', $leveringkosten_minimaal);
	//$smarty->assign('menus', $menu_lijst);

	// koppel mandje sessie aan smarty
	if ($_SESSION['mandje']){
		$smarty->assign('mandje', $_SESSION['mandje']);
	}


	$aantalLijnen = count($_SESSION['mandje']);

	/*
	 * Bereken mandje totalen
	 */

	$aantalGerechten = 0;
	$totaalBedragzv = 0;
	for ($a = 0; $a<$aantalLijnen ;$a++){
		$aantalGerechten += $_SESSION["mandje"][$a]['aantal'];
		$totaalBedragzv += $_SESSION["mandje"][$a]['lijn_totaal_prijs'];
		$totaalBedragzv = number_format($totaalBedragzv, 2);
	}

	$totaalBedrag = berekenTotaal();


	if($_SESSION['mandje']){
		$_SESSION['totalen']['totaal_aantal_gerechten'] = $aantalGerechten;
		$_SESSION['totalen']['subtotaal'] = number_format($totaalBedragzv, 2);
		$_SESSION['totalen']['bezorgkosten'] = $bezorg_kosten;
		$_SESSION['totalen']['totaal'] = number_format($totaalBedrag, 2);
	}

//echo '<pre>';
//	var_dump($_SESSION['totalen']);
//echo '</pre>';

	/*
	 * koppel de totalen aan smarty
	 */
	$smarty->assign('aantalLijnen', $aantalLijnen);
	$smarty->assign('aantalGerechten', $aantalGerechten);
	$smarty->assign('totaalBedragzv', $totaalBedragzv);
	$smarty->assign('bezorg_kosten', $bezorg_kosten);
	$smarty->assign('totaalBedrag', $totaalBedrag);



//echo '<pre>';
//		var_dump($_SESSION);
//echo '</pre>';

	/*
	 * toon de index templates
	 */
	switch ($_REQUEST["lokatie"]) {
		case 'home':
			$smarty->display('index_home.tpl');
			break;
		case 'gastenboek':
			$smarty->display('index_gastenboek.tpl');
			break;
		case 'registreren':
			$smarty->display('index_registreren.tpl');
			break;
		case 'inloggen':
			$smarty->display('index_inloggen.tpl');
			break;
		case 'bestellen':
			$smarty->display('index_bestellen.tpl');
			break;
		case 'leveren':
			if ($aantalLijnen > 0){
				maakBestelling();
			}
			$smarty->display('index_leveren.tpl');
			break;
		case 'faq':
			$smarty->display('index_faq.tpl');
			break;
		case 'menu':
			$smarty->display('index_menu.tpl');
			break;
		case 'klantdata':
			$smarty->display('index_klantdata.tpl');
			break;
		default:
			$smarty->display('index_home.tpl');
		break;
	}


	function maakBestelling(){
		$besteltijd = time();
		$toon_besteltijd = strftime("%d %B %Y om  %H:%M", $besteltijd);
		$toon_besteltijd_string = date('d-m-Y H:i', $besteltijd);
		if(isset($_SESSION['reservatie_tijd'])){
			$levertijd = $_SESSION['reservatie_tijd'];
		} else {
			$levertijd = $besteltijd + (40 * 60); //levertijd is besteltijd + 40 minuten;
		}
		$toon_levertijd = strftime("%d %B %Y om  %H:%M", $levertijd);
		$toon_levertijd_string = date('d-m-Y H:i', $levertijd);

		if ($levertijd < $besteltijd){
			$_SESSION['levertijd_is_vroeger'] = true;
			header('Location: index.php?lokatie=menu');
			return;
		} else {
			unset($_SESSION['levertijd_is_vroeger']);
		}

		$leverwijze_id 	= $_SESSION["leverwijze_id"];
		//$totaal_prijs 	= $_SESSION[];
		$klant_id = $_COOKIE[klant][klant_id];
		//setcookie();
		$jaar 				= date('Y');
		$maand 				= date('m');
		$dag				= date('d');
		$uur				= date('H');
		$minuut				= date('i');

		$bestelling_nummer 	= $jaar.$maand.$dag.$uur.$minuut;

		$nullen = 5-strlen($klant_id); //5 is de lengte van mijn identifier en die pre-fill ik met nullen
		$identifier = '';
		for($i = 0 ; $i<$nullen ; $i++){
			$identifier .= "0";
		}
		$identifier .= $klant_id;
		$bestelling_nummer .= $identifier;

//		echo $bestelling_nummer;
		//maak bestelling

		$m_best = new tmap();
		$m_best->table_arr = array('bestelling');
		$m_best->column_arr = array('id','besteltijd','levertijd','bestelling_nummer','leverwijze_id', 'totaal_prijs');
		$m_best->value_arr = array(NULL, $besteltijd, $levertijd, $bestelling_nummer, $leverwijze_id, $_SESSION['totalen']['totaal']);
		$m_best->nieuw();
		$m_best_last_id = $m_best->last_id;
		setcookie('klant[' . $kl_id . '][last_id]', '$m_best_last_id', time()+3600*24*10);

		$l_best = new tmap();
		$l_best->column_arr = array('id', 'bestelling_nummer');
		$l_best->table_arr = array('bestelling');
		$l_best->where_arr = array('bestelling_nummer'=>$bestelling_nummer);
		$l_best->lijst = $l_best->lezen();
		$l_best_lijst = $l_best->lijst;

		$bestelling_id = $l_best_lijst[0]->id;

		$klant_best = new tmap();
		$klant_best->table_arr = array('klant_bestelling');
		$klant_best->column_arr = array('id','klant_id','bestelling_id');
		$klant_best->value_arr = array(NULL, $klant_id, $bestelling_id);
		$klant_best->nieuw();

		if ($_SESSION["mandje"]){
			foreach($_SESSION["mandje"] as $lijn){
				$lijn_naam =  $lijn["gerecht_naam"];
				$lijn_aantal = $lijn["aantal"];
				$lijn_prijs	= $lijn["lijn_totaal_prijs"];

				/*
				 * voeg lijn toe aan database
				 */
				$maak_best_lijn = new tmap();
				$maak_best_lijn->table_arr = array('bestelling_lijn');
				$maak_best_lijn->column_arr = array('id','bestelling_id', 'lijn_naam', 'lijn_aantal', 'lijn_prijs');
				$maak_best_lijn->value_arr = array(NULL, $bestelling_id, $lijn_naam, $lijn_aantal, $lijn_prijs);
				$maak_best_lijn->nieuw();
				$last_id = $maak_best_lijn->last_id;

//				$lees_best_lijn = new tmap();
//				$lees_best_lijn->table_arr 	= array('bestelling_lijn');
//				$lees_best_lijn->column_arr	= array('id');
//				$lees_best_lijn->where_arr	= array('id'=>$last_id);
//				$lees_best_lijn->lijst = $lees_best_lijn->lezen();
//
//				$lees_best_lijn_lijn = $lees_best_lijn->lijst;


				/*
				 * voeg lijn_optie_variant toe aan database
				 */
				foreach($lijn["optie"] as $optie){
					$best_lijn_var = new tmap();
					$best_lijn_var->table_arr = array('bestellijn_gerecht_opties');
					$best_lijn_var->column_arr = array('id','gerecht_optie_variant_id', 'bestellijn_id');
					$best_lijn_var->value_arr = array(NULL, $optie, $last_id);
					$best_lijn_var->nieuw();
				}

			}
		}



		global $smarty;
		$smarty->assign("bestelling_nummer", $bestelling_nummer);
		$smarty->assign("besteltijd",$toon_besteltijd_string);
		$smarty->assign("levertijd",$toon_levertijd_string);

		// leeg het mandje


		unset($_SESSION['mandje']);
		unset($_SESSION['totalen']);
		unset($_SESSION['reservatie_tijd']);
		unset($_SESSION['leverwijze_id']);
		unset($_SESSION['levertijd_is_vroeger']);
		unset($_SESSION['fouten']);
		$aantalLijnen = 0;
		$smarty->assign('aantalLijnen', $aantalLijnen);

	}



	function berekenTotaal(){
		global $leveringkosten_minimaal;
		global $totaalBedragzv;
		global $bezorg_kosten;
		$tb = $totaalBedragzv;

		if ($totaalBedragzv < $leveringkosten_minimaal){
			$tb += $bezorg_kosten;
			$tb = number_format($tb, 2);
		} else {
			$tb = number_format($tb, 2);
		}
		return $tb;
	}


function tijdTussen($start, $einde, $na=' geleden'){
	//beide tijden moeten in seconden weergegeven worden
	$periode = $einde - $start;

	$tijdsdelen	= array(	 'se'=>array('seconde','seconden')
							,'mi'=>array('minuut','minuten')
							,'uu'=>array('uur','uren')
							,'da'=>array('dag','dagen')
							,'we'=>array('week','weken')
							,'ma'=>array('maand','maanden')
							);



	// als de periode binnen de minuut ligt
	if(60 > $periode){
		$html	= getalsVormen(round($periode), $tijdsdelen, 'se');
	}
	// als de periode binnen tussen een minuut en een uur ligt
	if(60 < $periode && $periode <= 3600){
		$html	= getalsVormen(round($periode/60,0), $tijdsdelen, 'mi');
	}
	// als de periode binnen tussen een uur en een dag ligt
	if(3600 < $periode && $periode <= 86400){
		$html	= getalsVormen(round($periode/3600,0), $tijdsdelen, 'uu');
	}
	// als de periode binnen tussen een dag en een week ligt
	if(86400 < $periode && $periode <= 604800){
		$html	= getalsVormen(round($periode/86400,0), $tijdsdelen, 'da');
	}
	// als de periode binnen tussen een week en een maand ligt
	if(604800 < $periode && $periode <= 2592000){
		$html	= getalsVormen(round($periode/604800,0), $tijdsdelen, 'we');
	}
	// als de periode binnen tussen een maand en een jaar ligt
	if(2592000 < $periode && $periode <= 29030400){
		$html	= getalsVormen(round($periode/2592000,0), $tijdsdelen, 'ma');
	}
	// als de periode meer als een jaar is
	if($periode > 29030400){
		$html = 'Is meer dan een jaar';
	}
	return $html . ' ' . $na;
}

/**
 * Dit is een functie om te bepalen of iets enkel- of meervoud is
 *
 * Bijv.:
 * $tijdsdelen	= array(	 'se'=>array('seconde','seconden')
							,'mi'=>array('minuut','minuten')
							,'uu'=>array('uur','uren')
							,'da'=>array('dag','dagen')
							,'we'=>array('week','weken')
							,'ma'=>array('maand','maanden')
							);
 *
 *
 * @param $aantal $periode aantal
 * @param $arr array van delen
 * @param $arr_index index van de te gebruiken dimensie in de $array
 * @return unknown_type
 */
function getalsVormen($aantal, $arr, $arr_index){
	$enkelvoud	= $arr[$arr_index][0];
	$meervoud	= $arr[$arr_index][1];
	$html 		= $aantal . ' ';
	if ($aantal == 1){
		$html .= $enkelvoud;
	} else {
		$html .= $meervoud;
	}
	return $html;
}

	/*
	 * TO-DO lijst:
	 *
	 * - planner maken (admin)
	 * - bestelling leveren -> Milo: done!
	 * - google map 	- met klanten 	(bij admin) ->toekomst
	 * 				- met radius	(op homepage) ->toekomst
	 * - keuze restaurant is nu nog "hard coded" (define restoid). Keuze pagina maken (toekomst)
	 * - Gerecht opties moeten worden gekoppeld aan de menu soorten. (aanpassen in dBase en admin) -> Milo: toekomst
	 * - reserveren.tpl kopieren van bestellen.tpl -> Milo: Is nu alleen bestellen geworden.
	 * 														View wijzigingen gebeuren op session niveau
	 * 														door de leverwijze(sessie_id uitlezen) en
	 * 														de reservatie(alles wat meer als 40 minuten
	 * 														in de toekomst ligt) mee te geven bij het
	 * 														verwerken van de bestelling.
	 *
	 * - klantdata:
	 * 	- overzicht vorige bestellingen op datum of of hoeveelheid
	 * 		- datum: maak een van tot datum en check dan alle bestellingen waarvan besteldatum ertussen ligt.
	 * 		- hoeveelheid: maak top 10 lijst: mysql LIMIT 10
	 * 											- top 10: laatste bestellingen.
	 * 											- top 10: duurste bestellingen.
	 *
	 *	- afhaaldienst: Maak in de bestellingen lijst van toekomstige bestellingen die gelevert moeten worden
	 *					een knopje waarop men kan klikken om de klant te verwittigen van het feit dat zijn
	 *					bestelling klaarligt, dan wel bezorgd word.
	 *
	 * - Promotie systeem:
	 * 		Promocode kan door klant ingegeven worden in het winkelmandje.
	 * 	- database: Nieuwe tabel(len) aanmaken:
	 * 		promoties:
	 * 		- 	id, onderwerp(text), bericht(mediumtext/html), startdatum (bigint(20)), einddatum(bigint(20)),
	 * 			verstuurd(tinyint(1), promocode(varchar(6)
	 * 		promoties_klant: 	relationele tabel om promo_codes aan klant te koppelen en te controleren of klant de
	 * 							al eens gebruikt heeft binnen de periode van de promotie.
	 * 		-	id, klant_id, promo_id, bestelling_id
	 *	- homepage: toon promotiebalk (start minimized) onderaan de pagina (footer).
	 *
	 *
	 */

?>