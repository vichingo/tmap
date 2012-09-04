<?php
require_once 'autoClass.php';

	// maak toolkit object

	$tardis = new tardis();

	// maak objecten

	$menu = new menu();
	$menu->read();
	$menu_lijst = $menu->lijst;
	//echo $menu->makeJson();

	$bestanddeel = new bestanddeel();
	$bestanddeel->read();
	$bestanddeel_lijst = $bestanddeel->lijst;
	//echo $bestanddeel->makeJson();


	$gerecht = new gerecht();
	$gerecht->read();
	$gerecht_lijst = $gerecht->lijst;
	//echo $gerecht->makeJson();


	$gerecht_bestanddeel = new gerecht_bestanddeel();
	$gerecht_bestanddeel->read();
	$gerecht_bestanddeel_lijst = $gerecht_bestanddeel->lijst;
	//echo $gerecht_bestanddeel->makeJson();
	$gerecht_bestanddeel_rijen = $gerecht_bestanddeel->aantalRijen;


	$opties = new gerecht_opties();
	$opties->read();
	global $optie_lijst;
	$optie_lijst = $opties->lijst;

	$aantal_opties = $opties->aantalRijen;
	//echo $opties->makeJson();


	$optie_variant = new optie_variant();
	$optie_variant->read();
	$optie_variant_lijst = $optie_variant->lijst;
	//echo $optie_variant->makeJson();


	$lokatie = new lokatie();
	$lokatie->read();
	$lokatie_lijst = $lokatie->lijst;
	//echo $lokatie->makeJson();


	$leverwijze = new leverwijze();
	$leverwijze->read();
	$leverwijze_lijst = $leverwijze->lijst;


	$restaurant = new resto();
	$restaurant->readLine(1);
	$mijn_restaurant_lijst = $restaurant->lijst;
//	echo '<pre>';
//		var_dump($mijn_restaurant_lijst);
//	echo '</pre>';
	$resto		= new resto();
	$resto->read();
	$resto_lijst	= $resto->lijst;

	$li = new leveren_in();
	$li->read();
	$li_lijst = $li->lijst;

	/*
	 * objecten waar geen classes voor zijn.
	 *
	 * of objecten die niet sneller worden door een classe te gebruiken
	 *
	 */


	/*
	 * Lijst van lokatie waar geleverd wordt
	 *
	 * hier koppelen we de lokatie_id van de leveren_in tabel aan de id van de
	 * tabel lokatie en vragen hiervan de id en naam op zodat we deze later in
	 * een drop-down menu kunnen steken
	 */

	$lever_locatie = new tmap();
	$lever_locatie->table_arr = array("leveren_in l","lokatie lo");
	$lever_locatie->column_arr = array("lo.id","lo.name");
	$lever_locatie->where_arr = array("l.lokatie_id" => "lo.id");
	$lever_locatie->lijst = $lever_locatie->lezen();
	$lever_locatie_lijst = $lever_locatie->lijst;

	/*
	 * Adres van het restaurant.
	 *
	 * Deze vragen we op om straks te gebruiken voor een eventuele google maps implementatie
	 *
	 */

	$resto_adres 				= new tmap();
	$resto_adres->table_arr 	= array(	 'resto r'
											,'lokatie l');
	$resto_adres->column_arr 	= array(	 'r.lokatie_adres adres'
											,'l.code postcode'
											,'l.name plaats');
	$resto_adres->where_arr		= array(	 'r.lokatie_id' => 'l.id');
	$resto_adres->lijst 		= $resto_adres->lezen();
	$resto_adres_lijst 			= $resto_adres->lijst;
	$resto_adres_string			= $resto_adres_lijst[0]->adres . ", " . $resto_adres_lijst[0]->plaats . " België" ;



	/*
	 * Het tellen van het aantal gerechten bij de bestellingen
	 *
	 * SELECT b.`bestelling_id`, SUM(lijn_aantal) aantal_lijnen
	 * FROM bestelling_lijn b
	 * WHERE b.`bestelling_id` = 4
	 * GROUP BY b.`bestelling_id`;
	 *
	 */

?>