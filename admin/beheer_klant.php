<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de klanten</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_klant.js"></script>
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
$klant = new klant();
$klant->read();
$klant_lijst 	= $klant->lijst;
$klant_kol 		= $klant->aantalKolommen;
$klant_rij 		= $klant->aantalRijen;
$klant_kol_nam 	= $klant->kolomNamen;
//echo $klant->makeJson();

$lokatie = new lokatie();
$lokatie->read();
$lokatie_lijst = $lokatie->lijst;


/*
 * SELECT lo.`id`, lo.`name` FROM leveren_in l, lokatie lo
 * WHERE l.`lokatie_id`=lo.`id`;
 *
 */
$lever_locatie = new tmap();
$lever_locatie->table_arr = array("leveren_in l","lokatie lo");
$lever_locatie->column_arr = array("lo.id","lo.name");
$lever_locatie->where_arr = array("l.lokatie_id" => "lo.id");
$lever_locatie->lijst = $lever_locatie->lezen();
$lever_locatie_lijst = $lever_locatie->lijst;




$resto_locatie = new tmap();
/*
 * SELECT l.`longitude`, l.`latitude`, r.`id` FROM resto r, lokatie l
WHERE r.`lokatie_id` = l.`id`;
 *
 */
$resto_locatie->column_arr = array("l.longitude","l.latitude","r.id");
$resto_locatie->table_arr = array("resto r","lokatie l");
$resto_locatie->where_arr = array("r.lokatie_id" => "l.id");
$resto_locatie->lijst = $resto_locatie->lezen();
$resto_locatie_lijst = $resto_locatie->lijst;
//echo $resto_locatie->r_Query;
//echo $resto_locatie->makeJson();
?>
</head>
<body>
	<form id="delete_klant">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $klant_kol+1;?>">Klanten</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Adres</td>
				<td class="rijHoofd">Contact</td>
				<td class="rijHoofd">geblokkeerd</td>
				<td class="rijHoofd">promotie</td>
				<td class="rijHoofd">Aanmaakdatum</td>
				<td class="rijHoofd">Afstand</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($klant_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $klant_kol+1;?>">Aantal klanten: <?php echo $klant_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($klant_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->voornaam $value->achternaam</td>";
			$tabel_rij	.= "<td>" . $value->straat . " " . $value->straat_nummer;
			if ($nummer_bus){
				$tabel_rij	.= " bus $value->nummer_bus";
			}

			foreach($lokatie_lijst as $lokatie){
				if($value->lokatie_id == $lokatie->id){
					$tabel_rij	.=  ", " . $lokatie->code . " " . $lokatie->name;
				}
			}

			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>$value->tel_vast $value->tel_gsm - $value->email</td>";
			$tabel_rij	.= "<td>";
			if ($value->geblokkeerd == 1){
				$tabel_rij	.= "ja";
			} else {
				$tabel_rij	.= "nee";
			}
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>";
			if ($value->promotie == 1){
				$tabel_rij	.= "ja";
			} else {
				$tabel_rij	.= "nee";
			}
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>". date('d-m-Y', $value->aanmaakdatum) . "</td>";
			$tabel_rij	.= "<td>";
			$klant_locatie = new tmap();
			$klant_locatie->table_arr = array("klant k","lokatie l");
			$klant_locatie->column_arr = array("l.longitude","l.latitude","k.id");
			$klant_locatie->where_arr = array("k.lokatie_id" => "l.id", "k.id" => $value->id);
			$klant_locatie->lijst = $klant_locatie->lezen();
			$klant_locatie_lijst = $klant_locatie->lijst;
//			echo $klant_locatie->r_Query;
//			echo $klant_locatie->makeJson();

			foreach($resto_locatie_lijst as $key=>$waarde){
				$re_lat = $waarde->latitude;
				$re_lon = $waarde->longitude;
			}
			foreach($klant_locatie_lijst as $key=>$waarde2){
				$kl_lat = $waarde2->latitude;
				$kl_lon = $waarde2->longitude;
			}
			$afstand 	 = tardis::afstand($re_lat,$re_lon, $kl_lat, $kl_lon, "k");
			$tabel_rij	.= $afstand . " km";
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td class=\"hidden choice\"><input class=\"keuze\" type=\"checkbox\" name=\"id[]\" value=\"" . $value->id . "\" /></td>";
			$tabel_rij	.= "</tr>\n";

		}
		echo $tabel_rij;
		?>
		</tbody>
	</table>
	</form>
	<table id="knoppen">
		<thead></thead>
		<tfoot></tfoot>
		<tbody>
			<tr>
				<td>
				<button value="klant" id="verwijder">Verwijder</button>
				<button value="klant" id="maak">Voeg toe</button>
				<button value="klant" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een klant toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_klant">
			<fieldset>
				<label for="a_voornaam">Voornaam</label>
				<input type="text" name="a_voornaam" id="a_voornaam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_achternaam">Achternaam</label>
				<input type="text" name="a_achternaam" id="a_achternaam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_straat">Straat</label>
				<input type="text" name="a_straat" id="a_straat" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_straat_nummer">Nummer</label>
				<input type="text" name="a_straat_nummer" id="a_straat_nummer" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_nummer_bus">Bus</label>
				<input type="text" name="a_nummer_bus" id="a_nummer_bus" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_lokatie_id">Woonplaats</label>
				<select name="a_lokatie_id" id="a_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lever_locatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="a_tel_vast">Vast telefoon nummer</label>
				<input type="text" name="a_tel_vast" id="a_tel_vast" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_tel_gsm">Mobiel telefoon nummer</label>
				<input type="text" name="a_tel_gsm" id="a_tel_gsm" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_email">E-mail adres</label>
				<input type="text" name="a_email" id="a_email" value="" class="text ui-widget-content ui-corner-all" />

				<label for="a_wachtwoord">Wachtwoord</label>
				<input type="text" name="a_wachtwoord" id="a_wachtwoord" value="" class="text ui-widget-content ui-corner-all" />

				<input type="hidden" name="a_aanmaakdatum" id="a_aanmaakdatum" value="<?php echo time();?>"/>

				<label for="a_geblokkeerd">Geblokkeerd</label>
				<input type="checkbox" name="a_geblokkeerd" id="a_geblokkeerd" value="ja"/>
				<label for="a_promotie">Promotie</label>
				<input type="checkbox" name="a_promotie" id="a_promotie" value="ja"/>
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig klantgegevens">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_klant">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />

				<label for="e_voornaam">Voornaam</label>
				<input type="text" name="e_voornaam" id="e_voornaam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_achternaam">Achternaam</label>
				<input type="text" name="e_achternaam" id="e_achternaam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_straat">Straat</label>
				<input type="text" name="e_straat" id="e_straat" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_straat_nummer">Nummer</label>
				<input type="text" name="e_straat_nummer" id="e_straat_nummer" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_nummer_bus">Bus</label>
				<input type="text" name="e_nummer_bus" id="e_nummer_bus" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_lokatie_id">Woonplaats</label>
				<select name="e_lokatie_id" id="e_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lever_locatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="e_tel_vast">Vast telefoon nummer</label>
				<input type="text" name="e_tel_vast" id="e_tel_vast" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_tel_gsm">Mobiel telefoon nummer</label>
				<input type="text" name="e_tel_gsm" id="e_tel_gsm" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_email">E-mail adres</label>
				<input type="text" name="e_email" id="e_email" value="" class="text ui-widget-content ui-corner-all" />

				<label for="e_wachtwoord">Wachtwoord</label>
				<input type="text" name="e_wachtwoord" id="e_wachtwoord" value="" class="text ui-widget-content ui-corner-all" />

				<input type="hidden" name="e_aanmaakdatum" id="e_aanmaakdatum" value="<?php echo time();?>"/>

				<label for="e_geblokkeerd">Geblokkeerd</label>
				<input type="checkbox" name="e_geblokkeerd" id="e_geblokkeerd" />
				<label for="e_promotie">Promotie</label>
				<input type="checkbox" name="e_promotie" id="e_promotie" />
			</fieldset>
		</form>
	</div>
</body>
</html>
