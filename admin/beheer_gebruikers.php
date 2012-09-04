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
<script language="javascript" type="text/javascript" src="script/tmap_beheer_gebruikers.js"></script>
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
$gebruiker = new gebruikers();
$gebruiker->read();
$gebruiker_lijst 	= $gebruiker->lijst;
$gebruiker_kol 		= $gebruiker->aantalKolommen;
$gebruiker_rij 		= $gebruiker->aantalRijen;
//echo $gebruiker->r_Query;
?>
</head>
<body>
	<form id="delete_gebruiker">
	<table id="lijst">
		<thead>
			<tr>
				<th colspan="<?php echo $gebruiker_kol+1;?>">Bestanddelen</th>
			</tr>
			<tr>
				<td class="rijHoofd">Naam</td>
				<td class="rijHoofd">Login Naam</td>
				<td class="rijHoofd">Wachtwoord</td>
				<td class="rijSelect">
				<div id="showDelete">
					<img src="../images/fugue/icons/ui-check-boxes-series.png" />
				</div>
				</td>
			</tr>
		</thead>
		<?php
		if ($gebruiker_rij > 0){
			?>
		<tfoot>
			<tr>
				<td colspan="<?php echo $gebruiker_kol+1;?>">Aantal bestanddelen: <?php echo $gebruiker_rij;?></td>
			</tr>
		</tfoot>
		<tbody id="itemLijst">
		<?php


		$tabel_rij = '';
		foreach($gebruiker_lijst as $value)
		{
			$tabel_rij	.= "<tr id=\"item_$value->id\" class=\"item_rij\">";
			$tabel_rij	.= "<td class=\"hidden\">$value->id</td>";
			$tabel_rij	.= "<td>$value->naam</td>";
			$tabel_rij	.= "<td>$value->login_naam</td>";
			$tabel_rij	.= "<td>$value->sesam</td>";
//			$tabel_rij	.= "<td>";
//			$wwl = strlen($value->sesam);
//			for($i = 0; $i < $wwl; $i++){
//				$tabel_rij	.= "*";
//			}
//			$tabel_rij	.= "</td>";
			$tabel_rij	.= "<td class=\"hidden choice\"><input class=\"keuze\" type=\"checkbox\" name=\"id[]\" value=\"" . $value->id . "\" /></td>";
			$tabel_rij	.= "</tr>\n";

		}
		echo $tabel_rij;
		?>
		</tbody>
	<?php
	}
	?>
	</table>
	</form>
	<table id="knoppen">
		<thead></thead>
		<tfoot></tfoot>
		<tbody>
			<tr>
				<td>
				<button value="gebruiker" id="verwijder">Verwijder</button>
				<button value="gebruiker" id="maak">Voeg toe</button>
				<button value="gebruiker" id="wijzig">Wijzig</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="add-form" class="hidden" title="Voeg een bestanddeel toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_gebruiker">
			<fieldset>
				<label for="a_naam">Naam</label>
				<input type="text" name="a_naam" id="a_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_login_naam">Gebruikersnaam</label>
				<input type="text" name="a_login_naam" id="a_login_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_login_wachtwoord">Wachtwoord</label>
				<input type="password" name="a_login_wachtwoord" id="a_login_wachtwoord" value="" class="text ui-widget-content ui-corner-all" />
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig bestanddeel">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_gebruiker">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<label for="e_naam">Naam</label>
				<input type="text" name="e_naam" id="e_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_login_naam">Gebruikersnaam</label>
				<input type="text" name="e_login_naam" id="e_login_naam" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_login_wachtwoord">Wachtwoord oud</label>
				<input type="text" name="e_login_wachtwoord" id="e_login_wachtwoord" value="" class="text ui-widget-content ui-corner-all" />

			</fieldset>
		</form>
	</div>
</body>
</html>
