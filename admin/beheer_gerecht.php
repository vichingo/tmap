<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de gerechten</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_gerecht.js"></script>
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
$g = new gerecht();
$g->read();

$g_lijst 		= $g->lijst;
$g_kol 			= $g->aantalKolommen;
$g_rij 			= $g->aantalRijen;
$g_kol_nam 		= $g->kolomNamen;

//echo $g->r_Query;
//echo $g->makeJson();


$m = new menu();
$m->read();

$m_lijst = $m->lijst;


?>
</head>
<body>
	<form id="delete_bd">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $g_kol+1;?>">Gerechten</th>
			</tr>
			<tr>
				<td class="rijHoofd">Image</td>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Omschrijving</td>
				<td class="rijHoofd">Code</td>
				<td class="rijHoofd">Basisprijs</td>
				<td class="rijHoofd">Menu</td><!-- menu id -->
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($g_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $g_kol+1;?>">Aantal bestanddelen: <?php echo $g_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($g_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td><img class=\"image_thmb\" src=\"../images/content/$value->image\" alt=\"$value->naam\"/></td>";
			$tabel_rij	.= "<td>$value->naam</td>";
			$tabel_rij	.= "<td>$value->omschrijving</td>";
			$tabel_rij	.= "<td>$value->code</td>";
			$tabel_rij	.= "<td>&#8364 $value->basisprijs</td>";
			$tabel_rij	.= "<td>$value->menunaam</td>";
			$tabel_rij	.= "<td class=\"hidden\">$value->menu_id</td>";
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
				<button value="g" id="verwijder">Verwijder</button>
				<button value="g" id="maak">Voeg toe</button>
				<button value="g" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een gerecht toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_g">
			<fieldset>
				<label for="a_image">Image</label>
				<input type="file" name="a_image" id="a_image" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_omschrijving">Omschrijving</label>
				<input type="text" name="a_omschrijving" id="a_omschrijving" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_code">Code</label>
				<input type="text" name="a_code" id="a_code" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_basisprijs">Basisprijs (&#8364;):</label>
				<input type="text" name="a_basisprijs" id="a_basisprijs" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_menu_id">Menu</label>
				<select name="a_menu_id" id="a_menu_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$m_optie = '';

					foreach($m_lijst as $value){
						$m_optie 	.= "<option value=\"". $value->id . "\">";
						$m_optie	.= $value->naam;
						$m_optie	.= "</option>";
					}
					echo $m_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig gerecht">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_g">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_image">Image</label>
				<input type="text" name="e_image" id="e_image" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_omschrijving">Omschrijving</label>
				<input type="text" name="e_omschrijving" id="e_omschrijving" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_code">Code</label>
				<input type="text" name="e_code" id="e_code" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_basisprijs">Basisprijs (&#8364;):</label>
				<input type="text" name="e_basisprijs" id="e_basisprijs" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_menu_id">Categorie</label>
				<select name="e_menu_id" id="e_menu_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$m_optie = '';

					foreach($m_lijst as $value){
						$m_optie 	.= "<option value=\"". $value->id . "\">";
						$m_optie	.= $value->naam;
						$m_optie	.= "</option>";
					}
					echo $m_optie;
					?>
				</select>
			</fieldset>
		</form>
	</div>
</body>
</html>
