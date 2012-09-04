<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de bestanddelen</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_leveren_in.js"></script>
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
$li 		= new leveren_in();
$li->read();
$li_lijst 	= $li->lijst;
$li_kol 	= $li->aantalKolommen;
$li_rij 	= $li->aantalRijen;
$li_kol_nam = $li->kolomNamen;
//echo $li->makeJson();

$lokatie = new lokatie();
$lokatie->read();
$lokatie_lijst = $lokatie->lijst;

$resto = new resto();
$resto->read();
$resto_lijst = $resto->lijst;

?>
</head>
<body>
	<form id="delete_bd">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $li_kol+1;?>">Restaurant(s)</th>
			</tr>
			<tr>
				<td class="rijHoofd">Restaurant</td>
				<td class="rijHoofd">Bezorgd alleen in:</td>
				<td class="rijHoofd">en dat kost:</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($li_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $li_kol+1;?>">Aantal bezorgplaatsen: <?php echo $li_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($li_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";

			$tabel_rij	.= "<td>";
			foreach($resto_lijst as $resto){
				if ($value->resto_id == $resto->id){
					$tabel_rij	.= $resto->naam . " ";
				}
			}
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>";
			foreach($lokatie_lijst as $lok){
				if ($value->lokatie_id == $lok->id){
					$tabel_rij	.= " ". $lok->code ." ". $lok->name ." ";
				}
			}
			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td>&#8364 $value->leveringkost  </td>";
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
				<button value="li" id="verwijder">Verwijder</button>
				<button value="li" id="maak">Voeg toe</button>
				<button value="li" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een bezorgplaats toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_li">
			<fieldset>
				<label for="a_resto_id">Restaurant</label>
				<select name="a_resto_id" id="a_resto_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$resto_optie = '';

					foreach($resto_lijst as $value){
						$resto_optie 	.= "<option value=\"". $value->id . "\">";
						$resto_optie	.= $value->naam;
						$resto_optie	.= "</option>";
					}
					echo $resto_optie;
					?>
				</select>
				<label for="a_lokatie_id">Leveren in</label>
				<select name="a_lokatie_id" id="a_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lokatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->code . " " . $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="a_leveringkost">Leverings kosten</label>
				<input type="text" name="a_leveringkost" id="a_leveringkost" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig bezorgplaats">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_li">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_resto_id">Restaurant</label>
				<select name="e_resto_id" id="e_resto_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$resto_optie = '';

					foreach($resto_lijst as $value){
						$resto_optie 	.= "<option value=\"". $value->id . "\">";
						$resto_optie	.= $value->naam;
						$resto_optie	.= "</option>";
					}
					echo $resto_optie;
					?>
				</select>
				<label for="e_lokatie_id">Leveren in</label>
				<select name="e_lokatie_id" id="e_lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$lok_optie = '';

					foreach($lokatie_lijst as $value){
						$lok_optie 	.= "<option value=\"". $value->id . "\">";
						$lok_optie	.= $value->code . " " . $value->name;
						$lok_optie	.= "</option>";
					}
					echo $lok_optie;
					?>
				</select>
				<label for="e_leveringkost">Leverings kosten</label>
				<input type="text" name="e_leveringkost" id="e_leveringkost" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>
</body>
</html>
