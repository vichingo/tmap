<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de voedsel categorieën</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_voedsel_categorie.js"></script>
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
	$vc = new voedsel_categorie();
	$vc->read();

	$vc_lijst 		= $vc->lijst;
	$vc_kol 		= $vc->aantalKolommen;
	$vc_rij 		= $vc->aantalRijen;
?>
</head>
<body>
	<form id="delete_vc">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $vc_kol+1;?>">Voedsel categorien</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijSelect">
					<div id="showDelete">
						<img src="../images/fugue/icons/ui-check-boxes-series.png" />
					</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($vc_kol > 0){
		?>
		<tfoot>
			<tr>
				<td colspan="2">Aantal groepen: <?php echo $vc_rij;?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$tabel_rij = '';
			foreach($vc_lijst as $value)
			{
				$tabel_rij	.= "<tr class=\"item_rij\">";
				$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
				$tabel_rij	.= "<td>$value->categorie</td>"; //let op... heeft de query column een alias naam of niet
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
				<button value="vc" id="verwijder">Verwijder</button>
				<button value="vc" id="maak">Voeg toe</button>
				<button value="vc" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een categorie toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_vc">
			<fieldset>
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig categorie">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_vc">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>
</body>
</html>