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
<script language="javascript" type="text/javascript" src="script/tmap_beheer_resto.js"></script>
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
$resto = new resto();
$resto->read();
$resto_lijst 	= $resto->lijst;
$resto_kol 		= $resto->aantalKolommen;
$resto_rij 		= $resto->aantalRijen;
$resto_kol_nam 	= $resto->kolomNamen;
//echo $resto->makeJson();

$lokatie = new lokatie();
$lokatie->read();
$lokatie_lijst = $lokatie->lijst;

?>
</head>
<body>
	<form id="delete_bd">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $resto_kol+1;?>">Restaurant(s)</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Taal</td>
				<td class="rijHoofd">Adres</td>
				<td class="rijHoofd">Geen leveringskosten vanaf</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($resto_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $resto_kol+1;?>">Aantal Restaurants: <?php echo $resto_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($resto_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->naam</td>";
			$tabel_rij	.= "<td>$value->taal</td>";
			$tabel_rij	.= "<td>$value->lokatie_adres";
			foreach($lokatie_lijst as $lok){
				if ($value->lokatie_id == $lok->id){
					$tabel_rij	.= " ". $lok->code ." ". $lok->name ." ";
				}
			}
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>&#8364 $value->leveringkosten_minimaal  </td>";
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
				<button value="resto" id="verwijder">Verwijder</button>
				<button value="resto" id="maak">Voeg toe</button>
				<button value="resto" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een restaurant toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_resto">
			<fieldset>
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_taal">Taal</label>
				<input type="text" name="a_taal" id="a_taal" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_lokatie_adres">Adres</label>
				<input type="text" name="a_lokatie_adres" id="a_lokatie_adres" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_lokatie_id">Plaats</label>
				<select name="a_lokatie_id" id="a_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lokatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="a_leveringkosten_minimaal">Geen leveringskosten boven de</label>
				<input type="text" name="a_leveringkosten_minimaal" id="a_leveringkosten_minimaal" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig restaurant">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_resto">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_taal">Taal</label>
				<input type="text" name="e_taal" id="e_taal" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_lokatie_adres">Adres</label>
				<input type="text" name="e_lokatie_adres" id="e_lokatie_adres" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_lokatie_id">Plaats</label>
				<select name="e_lokatie_id" id="e_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lokatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="e_leveringkosten_minimaal">Geen leveringskosten boven de</label>
				<input type="text" name="e_leveringkosten_minimaal" id="e_leveringkosten_minimaal" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>
</body>
</html>
