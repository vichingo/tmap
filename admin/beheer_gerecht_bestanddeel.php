<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de bestandelen van de gerechten</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_gerecht_bestanddeel.js"></script>
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
$gb 			= new gerecht_bestanddeel();
$gb->read();

$gb_lijst 		= $gb->lijst;
$gb_kol 		= $gb->aantalKolommen;
$gb_rij 		= $gb->aantalRijen;
$gb_kol_nam 	= $gb->kolomNamen;

//echo $gb->r_Query;
//echo $gb->makeJson();


$g 				= new gerecht();
$g->read();

$g_lijst 		= $g->lijst;
$g_rij 			= $g->aantalRijen;

$bd 			=new bestanddeel();
$bd->read();

$bd_lijst 		= $bd->lijst;
$bd_rij 		= $bd->aantalRijen;
?>
</head>
<body>
<!--	<pre>-->
	<?php
//		echo '<br>';
//		echo $gb->makeJson();
//		echo '<br>';
//		echo $g->makeJson();
//		echo '<br>';
//		echo $bd->makeJson();
	?>
<!--	</pre>-->
		<form id="delete_bd">
		<table id="lijst">
			<thead>
				<tr>
					<th colspan="<?php echo $gb_kol+1;?>">Gerecht bestanddelen</th>
				</tr>
				<tr>
					<td class="rijHoofd">Gerecht</td><!-- gerecht id -->
					<td class="rijHoofd">Bestanddeel naam</td><!-- bestanddeel id -->
					<td class="rijHoofd">Op basis</td><!-- boolean -->
					<td class="rijSelect">
					<div id="showDelete">
						<img src="../images/fugue/icons/ui-check-boxes-series.png" />
					</div>
					</td>
				</tr>
			</thead>
			<?php
			if ($gb_kol > 0){
				?>
			<tfoot>
				<tr>
					<td colspan="<?php echo $gb_kol+1;?>">Aantal bestanddelen: <?php echo $gb_rij;?></td>
				</tr>
			</tfoot>
			<tbody id="itemLijst">
			<?php


			$tabel_rij = '';
			foreach($gb_lijst as $value)
			{
				/*
				 * "gerechtBestanddeelId":"1",
				 * "gerechtId":"1",
				 * "gerechtNaam":"Pizza Prosciutto",
				 * "bestanddeelId":"56",
				 * "bestanddeelNaam":"Tomatensaus",
				 * "op_basis":"1"
				 *
				 */
				$tabel_rij	.= "<tr id=\"item_$value->gerechtBestanddeelId\" class=\"item_rij\">";
				$tabel_rij	.= "<td class=\"hidden\">$value->gerechtBestanddeelId</td>";
				$tabel_rij	.= "<td>$value->gerechtNaam</td>";
				$tabel_rij	.= "<td>$value->bestanddeelNaam</td>";
				if($value->op_basis == 1){
					$tabel_rij	.= "<td>Ja</td>";
				} else {
					$tabel_rij	.= "<td>Nee</td>";
				}
				$tabel_rij	.= "<td class=\"hidden choice\"><input class=\"keuze\" type=\"checkbox\" name=\"id[]\" value=\"" . $value->gerechtBestanddeelId . "\" /></td>";
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
				<button value="gb" id="verwijder">Verwijder</button>
				<button value="gb" id="maak">Voeg toe</button>
				<button value="gb" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een bestandeel aan een gerecht toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_gb">
			<fieldset>
				<label for="a_gerecht_id">Gerecht</label>
				<select name="a_gerecht_id" id="a_gerecht_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$g_optie = '';

					foreach($g_lijst as $value){
						$g_optie 	.= "<option value=\"". $value->id . "\">";
						$g_optie	.= $value->naam;
						$g_optie	.= "</option>";
					}
					echo $g_optie;
					?>
				</select>
				<label for="a_bestanddeel_id">Bestanddeel</label>
				<select name="a_bestanddeel_id" id="a_bestanddeel_id" multiple="multiple" size="<?php echo ceil($bd_rij / 2); ?>">
					<option value="0" selected="selected">Maak keuze</option>
					<?php

					$bd_optie = '';

					foreach($bd_lijst as $value){
						$bd_optie 	.= "<option value=\"". $value->id . "\">";
						$bd_optie	.= $value->bestanddeel;
						$bd_optie	.= "</option>";
					}
					echo $bd_optie;
					?>
				</select>
				<label for="a_op_basis">Als basis van de pizza</label>
				<input type="checkbox" name="a_op_basis" id="a_op_basis" />
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig bestandeelen van een gerecht">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_gb">
			<fieldset>
				<input type="hidden" name="e_gerecht_bestanddeel_id" id="e_gerecht_bestanddeel_id" value="" />
				<label for="e_gerecht_id">Gerecht</label>
				<select name="e_gerecht_id" id="e_gerecht_id">
					<?php

					$g_optie = '';

					foreach($g_lijst as $value){
						$g_optie 	.= "<option value=\"". $value->id . "\">";
						$g_optie	.= $value->naam;
						$g_optie	.= "</option>";
					}
					echo $g_optie;
					?>
				</select>
				<label for="e_bestanddeel_id">Bestanddeel</label>
				<select name="e_bestanddeel_id" id="e_bestanddeel_id" multiple="multiple" size="<?php echo ceil($bd_rij / 2); ?>">
					<?php

					$bd_optie = '';

					foreach($bd_lijst as $value){
						$bd_optie 	.= "<option value=\"". $value->id . "\">";
						$bd_optie	.= $value->bestanddeel;
						$bd_optie	.= "</option>";
					}
					echo $bd_optie;
					?>
				</select>
				<label for="e_op_basis">Als basis van de pizza</label>
				<input type="checkbox" name="e_op_basis" id="e_op_basis" />
			</fieldset>
		</form>
	</div>
</body>
</html>
