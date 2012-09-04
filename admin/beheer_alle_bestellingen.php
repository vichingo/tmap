<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de bestanddelen</title>
<?php
include 'header_admin.inc';
?>

<script language="javascript" type="text/javascript" src="script/tmap_beheer_alle_bestellingen.js"></script>
<style type="text/css">
label,input {
	display: block;
}

input.text {
	margin-bottom: 12px;
	width: 95%;
	padding: .4em;
}

fieldset {
	padding: 0;
	border: 0;
	margin-top: 25px;
}

h1 {
	font-size: 1.2em;
	margin: .6em 0;
}

div#users-contain {
	width: 350px;
	margin: 20px 0;
}

div#users-contain table {
	margin: 1em 0;
	border-collapse: collapse;
	width: 100%;
}

div#users-contain table td,div#users-contain table th {
	border: 1px solid #eee;
	padding: .6em 10px;
	text-align: left;
}

.ui-dialog .ui-state-error {
	padding: .3em;
}

.validateTips {
	border: 1px solid transparent;
	padding: 0.3em;
}
</style>
<?php


$alle_bestellingen = new tmap();
/*
 * SELECT b.`bestelling_nummer`,
 * b.`besteltijd`,
 * b.`levertijd`,
 * le.`naam`,
 * k1.`achternaam`,
 * k1.`straat`,
 * k1.`straat_nummer`,
 * k1.`nummer_bus`,
 * l.`code`,
 * l.`name`,
 * l.`longitude`,
 * l.`latitude`,
 *  b.`id`
 */
$alle_bestellingen->column_arr 	= array(	 'b.id'
											,'b.bestelling_nummer'
											,'b.besteltijd'
											,'b.levertijd'
											,'le.naam leverwijze_naam'
											,'k1.achternaam'
											,'k1.straat'
											,'k1.straat_nummer'
											,'k1.nummer_bus'
											,'l.code postcode'
											,'l.name plaats'
											,'l.longitude'
											,'l.latitude'
											,'b.totaal_prijs'
											);

											/*
 * FROM bestelling b,
 * bestelling_lijn bl,
 * bestellijn_gerecht_opties bj,
 * klant_bestelling k,
 * klant k1,
 * lokatie l,
 * leverwijze le,
 * optie_variant o,
 * gerecht_opties g
 */
$alle_bestellingen->table_arr 	= array(	 'bestelling b'
											,'bestelling_lijn bl'
											,'bestellijn_gerecht_opties bj'
											,'klant_bestelling k'
											,'klant k1'
											,'lokatie l'
											,'leverwijze le'
											,'optie_variant o'
											,'gerecht_opties g'
											);
/*
 * WHERE bl.bestelling_id = b.id
 * AND k.bestelling_id = b.id
 * AND k.klant_id = k1.id
 * AND b.leverwijze_id = le.id
 * AND bj.bestellijn_id = bl.id
 * AND k1.lokatie_id = l.id
 */
$where_arr						= array(	 'bl.bestelling_id' => 'b.id'
											,'k.bestelling_id' => 'b.id'
											,'k.klant_id'=>'k1.id'
											,'b.leverwijze_id'=>'le.id'
											,'bj.bestellijn_id'=>'bl.id'
											,'k1.lokatie_id'=>'l.id'
											);
//zoeker inbouwen
if (isset($_GET['act']) && $_GET['act'] == 'zoeken'){
	$zoeken_op = $_POST['zoek_veld_trefwoord'];
	if (isset($_POST['zoek_veld_trefwoord']) || $_POST['zoek_veld_trefwoord'] == ''){
		switch ($_POST['zoek_op_veld']) {
			case 1:
				array_push($where_arr['b.bestelling_nummer'], $zoeken_op);
			break;
			case 2:
				array_push($where_arr['b.besteltijd'], $zoeken_op);
			break;
			case 3:
				array_push($where_arr['b.levertijd'], $zoeken_op);
			break;
			case 4:
				array_push($where_arr['k1.achternaam'], $zoeken_op);
			break;
		}
	}
}

$alle_bestellingen->where_arr = $where_arr;

/*
 * GROUP BY b.`bestelling_nummer`;
 */
$alle_bestellingen->group_arr 	= array(	 'b.bestelling_nummer'
											);

if (isset($_GET['act']) && $_GET['act'] == 'sorteren'){
	switch ($_POST['bestel_toppers']) {
		case '1':
			$alle_bestellingen->sort_arr 	= array('b.besteltijd DESC');
			$alle_bestellingen->pagingSize	= 10;
			$lezen 							= $alle_bestellingen->lezen(TRUE);
		break;
		case '2':
			$alle_bestellingen->sort_arr 	= array('b.totaal_prijs DESC');
			$alle_bestellingen->pagingSize	= 10;
			$lezen 							= $alle_bestellingen->lezen(TRUE);
		break;
		default:
			$alle_bestellingen->sort_arr 			= array('b.besteltijd');
			$lezen = $alle_bestellingen->lezen();
		break;
	}

	/*
	 * Ik wilde nog een andere lijst sortering aanbrengen maar daar moet ik me nog in verdiepen
	 *
	 * SELECT b.`id`, count(bl.`id`) aantal_bestellingen FROM bestelling b, bestelling_lijn bl
	 * WHERE bl.`bestelling_id` =b.`id`
	 * GROUP BY b.`id`
	 * order by aantal_bestellingen desc
	 * limit 10;
	 */

} else {
	$alle_bestellingen->sort_arr 			= array('b.besteltijd');
	$lezen = $alle_bestellingen->lezen();
}

$alle_bestellingen->lijst 		= $lezen;
$alle_bestellingen_lijst 		= $alle_bestellingen->lijst;
$alle_bestellingen_kol 			= $alle_bestellingen->aantalKolommen;
$alle_bestellingen_rij 			= $alle_bestellingen->aantalRijen;
$alle_bestellingen_kol_nam 		= $alle_bestellingen->kolomNamen;
//echo $alle_bestellingen->r_Query;
//echo $alle_bestellingen->makeJson();


$resto_lokatie 				= new tmap();
$resto_lokatie->table_arr 	= array(	 'resto r'
										,'lokatie l');
$resto_lokatie->column_arr 	= array(	 'l.longitude'
										,'l.latitude');
$resto_lokatie->where_arr	= array(	 'r.lokatie_id' => 'l.id');
$resto_lokatie->lijst 		= $resto_lokatie->lezen();
$resto_lokatie_lijst 		= $resto_lokatie->lijst;
$resto_lokatie_long			= $resto_lokatie_lijst[0]->longitude;
$resto_lokatie_lat			= $resto_lokatie_lijst[0]->latitude;

/*
 * SELECT r.`lokatie_adres`, l.`code`, l.`name`
 * FROM resto r, lokatie l
 * WHERE r.`lokatie_id` = l.`id`;
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

$resto_adres_string			= $resto_adres_lijst[0]->adres . ", " . $resto_adres_lijst[0]->postcode . " " . $resto_adres_lijst[0]->plaats ;

$opties = new gerecht_opties();
$opties->read();
global $optie_lijst;
$optie_lijst = $opties->lijst;

$aantal_opties = $opties->aantalRijen;

?>
</head>
<body>
	<div class="hidden" id="resto_adres"><?php echo $resto_adres_string; ?></div>
	<div id="beheer_velden">
		<div class="sorteer_velden">
			<form id="sort_form" action="<?php echo $_SERVER["PHP_SELF"]; ?>?act=sorteren" method="post">
				<div id="toppers">
					<label for="bestel_toppers">Toppers</label>
					<select name="bestel_toppers" id="bestel_toppers">							<option value="0">Top 10 van</option>
							<option value="1">laatste bestellingen</option>							<option value="2">duurste bestellingen</option>
					</select>
				</div>
				<div class="sorteer_veld_knop">
					<button type="submit">Bekijk Top bestelling(en)</button>
				</div>
			</form>
		</div>
		<div class="zoek_velden">
			<form id="search_form" action="<?php echo $_SERVER["PHP_SELF"]; ?>?act=zoeken" method="post">
				<div id="zoek_op_velden">
					<label for="zoek_op_veld">Zoek bestelling op</label>
					<select name="zoek_op_veld" id="zoek_op_veld">
							<option value="0">Selecteer een veld</option>
							<option value="1">Nummer</option>
							<option value="2">Besteltijd</option>
							<option value="3">Levertijd</option>
							<option value="4">Achternaam klant</option>
					</select>
				</div>
				<!-- via jquery (plugin: jquery.maskedinput-1.2.2) de input mask bepalen voor het onderstaande input veld
				en dan met php zoek zoekopdracht uitvoeren op de  -->
				<div id="zoek_veld">
					<label id="zoek_veld_label" for="zoek_veld_trefwoord">Zoek naar</label>
					<input type="text" name="zoek_veld_trefwoord" id="zoek_veld_trefwoord" value=""/>
				</div>
				<div class="zoek_veld_knop">
					<button type="submit">Zoek bestelling(en)</button>
				</div>
			</form>
		</div>
	</div>
	<div id="bestellingen">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="8">Bestelling(en)</th>
			</tr>
			<tr>
				<td class="rijHoofd">Bestelling Nummer</td>
				<td class="rijHoofd">Besteld om:</td>
				<td class="rijHoofd">Bezorgen/Ophalen om:</td>
				<td class="rijHoofd">Bezorgen/Ophalen</td>
				<td class="rijHoofd">Klant</td>
				<td class="rijHoofd">Adres</td>
				<td class="rijHoofd">Afstand</td>
				<td class="rijHoofd">Totaal</td>
			</tr>
		</thead>
		<?php
		if ($alle_bestellingen_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="8">Aantal Bestellingen: <?php echo $alle_bestellingen_rij;?></td>
			</tr>
		</tfoot>
		<?php


		$bestel_rij = '';
		foreach($alle_bestellingen_lijst as $value)
		{

			$bestel_rij	.= '<tbody class="itemLijst" id="rij_'. $value->id .'">';
			$bestel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$bestel_rij	.= '<td class="hidden" id="klant_adres_'. $value->id .'">' . $value->straat . " " . $value->straat_nummer . ", " . $value->plaats .'</td>';
			$bestel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$bestel_rij	.= "<td>$value->bestelling_nummer</td>";
			$bestel_rij	.= "<td>" . date('d-m-Y H:i', $value->besteltijd) . "</td>"; //
			$bestel_rij	.= "<td>" . date('d-m-Y H:i', $value->levertijd) . "</td>";
			$bestel_rij	.= "<td>$value->leverwijze_naam</td>";
			$bestel_rij	.= "<td>$value->achternaam</td>";
			$bestel_rij	.= '<td>' . $value->straat . " " . $value->straat_nummer ;
			if (!$value->nummer_bus == ''){
				$bestel_rij	.= "bus $value->nummer_bus";
			}
			$bestel_rij	.= ", $value->postcode $value->plaats</td>";
			$bestel_rij	.= "<td>";
			$afstand = tardis::afstand($resto_lokatie_lat, $resto_lokatie_long, $value->latitude, $value->longitude, "k");
			$bestel_rij	.= $afstand . " km";
			$bestel_rij	.= "</td>";
			$bestel_rij	.= "<td>&#8364 $value->totaal_prijs</td>";
			$bestel_rij	.= "</tr>\n";
			$bestel_rij	.= '</tbody>';
			$bestel_rij	.= '<tbody class="specs" id="specs_'. $value->id .'">';

			$bestelling_lijn = new tmap();
			/*
			 * SELECT b.`id` bestelling_id, bl.`id` bestellijn_id, bl.`lijn_naam`, bl.`lijn_aantal`, bl.`lijn_prijs`
			 * FROM bestelling b, bestelling_lijn bl
			 * WHERE bl.`bestelling_id` =b.`id`;
			 */
			$bestelling_lijn->table_arr 		= array(	 'bestelling b'
															,'bestelling_lijn bl');
			$bestelling_lijn->column_arr 		= array(	 'b.id bestelling_id'
															,'bl.id bestellijn_id'
															,'bl.lijn_naam'
															,'bl.lijn_aantal'
															,'bl.lijn_prijs');
			$bestelling_lijn->where_arr			= array(	 'bl.bestelling_id' => 'b.id'
															,'b.id' => $value->id);
			$bestelling_lijn->lijst 			= $bestelling_lijn->lezen();
			$bestelling_lijn_lijst 				= $bestelling_lijn->lijst;

			$bestel_rij 	.= '<tr>';
			$bestel_rij		.= '<td colspan="2" class="emptycell"></td>';
			$bestel_rij		.= '<td class="specificatie">Gerecht</td>';
			foreach($optie_lijst as $option){
				$bestel_rij		.= '<td class="specificatie">'. $option->naam .'</td>';
			}
			$bestel_rij		.= '<td class="specificatie">Aantal</td>';
			$bestel_rij		.= '<td class="specificatie">Prijs</td>';
			$bestel_rij 	.= '</tr>';
			foreach($bestelling_lijn_lijst as $specs){

				$bestel_rij 	.= '<tr>';
				$bestel_rij		.= '<td colspan="2" class="emptycell"></td>';
				$bestel_rij		.= '<td class="specificatie_lijst">' . $specs->lijn_naam . '</td>';

				$bestelling_lijn_opties = new tmap();
				$bestelling_lijn_opties->table_arr 		= array(	 'bestelling_lijn b'
																	,'bestellijn_gerecht_opties bj'
																	,'gerecht_opties g'
																	,'optie_variant o');

				$bestelling_lijn_opties->column_arr 	= array(	 'o.naam variant_naam');
				$bestelling_lijn_opties->where_arr		= array(	 'bj.bestellijn_id' => 'b.id'
																	,'bj.gerecht_optie_variant_id' => 'o.id'
																	,'o.optie_id' => 'g.id'
																	,'b.id' => $specs->bestellijn_id);
				$bestelling_lijn_opties->lijst 			= $bestelling_lijn_opties->lezen();
				$bestelling_lijn_opties_lijst 			= $bestelling_lijn_opties->lijst;
				foreach($bestelling_lijn_opties_lijst as $optie){
					$bestel_rij		.= '<td class="specificatie_lijst">' . $optie->variant_naam . '</td>';
				}
				$bestel_rij		.= '<td class="specificatie_lijst">' . $specs->lijn_aantal . '</td>';
				$bestel_rij		.= '<td class="specificatie_lijst">&#8364 ' . $specs->lijn_prijs . '</td>';
				$bestel_rij 	.= '</tr>';
			}
			$bestel_rij		.= '</tbody>';


		}
		echo $bestel_rij;
		?>
	</table>
	</div>
	<div class="route_data">
		<div id="route"></div>
		<div id="map"></div>
	</div>
	<?php
	}
	?>
</body>
</html>