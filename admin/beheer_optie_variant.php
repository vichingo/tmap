<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de varianten</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_optie_variant.js"></script>
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
$ov = new optie_variant();
$ov->read();
$ov_lijst 		= $ov->lijst;
$ov_kol			= $ov->aantalKolommen;
$ov_rij 		= $ov->aantalRijen;
$ov_kol_nam 	= $ov->kolomNamen;
//echo $ov->r_Query;
$go = new gerecht_opties();
$go->read();
$go_lijst = $go->lijst;
?>
</head>
<body>
	<form id="delete_v">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $ov_kol+1;?>">Optie varianten</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Matrix</td>
				<td class="rijHoofd">Optie</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($ov_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $ov_kol+1;?>">Aantal varianten: <?php echo $ov_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($ov_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->variatie</td>";
			$tabel_rij	.= "<td>$value->matrix</td>";
			$tabel_rij	.= "<td>$value->optie_naam</td>";
			$tabel_rij	.= "<td class=\"hidden\">$value->optie_id</td>";
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
				<button value="ov" id="verwijder">Verwijder</button>
				<button value="ov" id="maak">Voeg toe</button>
				<button value="ov" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een variant toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_ov">
			<fieldset>
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_matrix">Matrix</label>
				<input type="text" name="a_matrix" id="a_matrix" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_optie_id">Categorie</label>
				<select name="a_optie_id" id="a_optie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$go_optie = '';

					foreach($go_lijst as $value){
						$go_optie 	.= "<option value=\"". $value->id . "\">";
						$go_optie	.= $value->naam;
						$go_optie	.= "</option>";
					}
					echo $go_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig variant">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_ov">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_matrix">Matrix</label>
				<input type="text" name="e_matrix" id="e_matrix" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_optie_id">Categorie</label>
				<select name="e_optie_id" id="e_optie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$go_optie = '';

					foreach($go_lijst as $value){
						$go_optie 	.= "<option value=\"". $value->id . "\">";
						$go_optie	.= $value->naam;
						$go_optie	.= "</option>";
					}
					echo $go_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>
</body>
</html>
