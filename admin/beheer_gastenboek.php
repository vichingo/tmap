<?php
require_once '../includes/autoClass.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer het gastenboek</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_gastenboek.js"></script>
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
$gastenboek 		= new gastenboek();
$gastenboek->read('DESC');
$gastenboek_lijst 	= $gastenboek->lijst;
$gastenboek_kol 	= $gastenboek->aantalKolommen;
$gastenboek_rij 	= $gastenboek->aantalRijen;
$gastenboek_kol_nam = $gastenboek->kolomNamen;
//echo $gastenboek->makeJson();

?>
</head>
<body>
	<?php
		if (isset($_COOKIE['authorized'])){
	?>
	<!-- new -->

	<form id="delete_bd">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $gastenboek_kol+1;?>">Gastenboek berichten</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Email</td>
				<td class="rijHoofd" style="width:30em;">Bericht</td>
				<td class="rijHoofd">Tijd</td>
				<td class="rijHoofd">IP</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($gastenboek_kol > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $gastenboek_kol+1;?>">Aantal bestanddelen: <?php echo $gastenboek_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($gastenboek_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->naam</td>";
			$tabel_rij	.= "<td>$value->email</a></td>";
			$tabel_rij	.= "<td>$value->bericht</td>";
			$tabel_rij	.= "<td>". date('d-m-Y  H:i', $value->post_tijd) . "</td>";
			$tabel_rij	.= "<td>$value->ip</td>";
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
				<button value="gastenboek" id="verwijder">Verwijder</button>
				<button value="gastenboek" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
	}
	?>
	<div id="edit-form" class="hidden" title="Wijzig gastenboek">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_gastenboek">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<input type="hidden" name="e_post_tijd" id="e_post_tijd" value="" />
				<input type="hidden" name="e_ip" id="e_ip" value="" />
				<input type="hidden" name="e_naam" id="e_naam" value="" />
				<input type="hidden" name="e_email" id="e_email" value="" />
				<label for="e_bericht">Antwoord</label>
				<textarea name="e_bericht" id="e_bericht" cols="30" rows="10" class="text ui-widget-content ui-corner-all"></textarea>
			</fieldset>
		</form>
	</div>
	<?php
		} else {
	?>

	Toestemming is alleen toegestaan voor bevoegd personeel.

	<?php
		}
	?>
</body>
</html>
