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
<script language="javascript" type="text/javascript" src="script/tmap_beheer_bestanddeel.js"></script>
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
$bd = new bestanddeel();
$bd->read();

//echo $bd->r_Query;

$bd_lijst 		= $bd->lijst;
//echo '<pre>';
//		var_dump($bd_lijst);
//echo '</pre>';
$bd_kol 		= $bd->aantalKolommen;
$bd_rij 		= $bd->aantalRijen;
$bd_kol_nam 	= $bd->kolomNamen;
//echo $bd->makeJson();
$vc = new voedsel_categorie();
$vc->read();
$vc_lijst = $vc->lijst;
?>
</head>
<body>
	<form id="delete_bd">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $bd_kol+1;?>">Bestanddelen</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Code</td>
				<td class="rijHoofd">Prijs</td>
				<td class="rijHoofd">Categorie</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($bd_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $bd_kol+1;?>">Aantal bestanddelen: <?php echo $bd_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($bd_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->bestanddeel</td>";
			$tabel_rij	.= "<td><a href=\"http://www.voedingswaardetabel.nl/voedingswaarde/voedingsmiddel/?id=$value->code\" target=\"_blank\">$value->code</a></td>";
			$tabel_rij	.= "<td>&#8364 $value->prijs</td>";
			$tabel_rij	.= "<td>$value->categorie</td>";
			$tabel_rij	.= "<td class=\"hidden\">$value->voedsel_categorie_id</td>";
			//$tabel_rij	.= "<td><button value=\"bd\" id=\"wijzig\">Wijzig</button></td>";
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
				<button value="bd" id="verwijder">Verwijder</button>
				<button value="bd" id="maak">Voeg toe</button>
				<button value="bd" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een bestanddeel toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_bd">
			<fieldset>
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_code">Code</label>
				<input type="text" name="a_code" id="a_code" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_prijs">Prijs (&#8364;):</label>
				<input type="text" name="a_prijs" id="a_prijs" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_voedsel_categorie_id">Categorie</label>
				<select name="a_voedsel_categorie_id" id="a_voedsel_categorie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$vc_optie = '';

					foreach($vc_lijst as $value){
						$vc_optie 	.= "<option value=\"". $value->id . "\">";
						$vc_optie	.= $value->categorie;
						$vc_optie	.= "</option>";
					}
					echo $vc_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig bestanddeel">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_bd">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_code">Code</label>
				<input type="text" name="e_code" id="e_code" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_prijs">Prijs (&#8364;):</label>
				<input type="text" name="e_prijs" id="e_prijs" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_voedsel_categorie_id">Categorie</label>
				<select name="e_voedsel_categorie_id" id="e_voedsel_categorie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$vc_optie = '';

					foreach($vc_lijst as $value){
						$vc_optie 	.= "<option value=\"". $value->id . "\">";
						$vc_optie	.= $value->categorie;
						$vc_optie	.= "</option>";
					}
					echo $vc_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>
</body>
</html>
