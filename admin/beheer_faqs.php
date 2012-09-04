<?php
require_once '../includes/autoClass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Beheer de FAQ's</title>
<?php
include 'header.inc';
?>
<script language="javascript" type="text/javascript" src="script/tmap_beheer_faqs.js"></script>
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
$faq = new faqs();
$faq->read();
$faq_lijst 	= $faq->lijst;
$faq_kol 		= $faq->aantalKolommen;
$faq_rij 		= $faq->aantalRijen;
$faq_kol_nam 	= $faq->kolomNamen;
//echo $faq->makeJson();

?>
</head>
<body>
	<div class="tabel">
		<div class="titel"><p>FAQ's</p></div>
		<div id="sorteer_lijst">
		<?php
			if ($faq_kol > 0){
				foreach($faq_lijst as $item)
				{
		?>
		<div class="item" id="item_<?php echo $item->id;?>">			<div id="volgorde_<?php echo $item->volgorde;?>" class="kop"><?php echo $item->vraag;?></div>			<div><?php echo $item->antwoord;?></div>		</div>
		<?php
				}
		?>

		</div>
		<div class="voetnoot">			<div><p>Aantal vragen: <span><?php echo $faq_rij;?></span></p></div>		</div>
	</div>
	<div class="tabel" id="knoppen">		<div class="knoppen">
				<button value="faq" id="verwijder">Verwijder</button>
				<button value="faq" id="maak">Voeg toe</button>
				<button value="faq" id="wijzig">Wijzig</button>		</div>	</div>
	<?php
	}
	?>
	<div id="add-form" class="hidden" title="Voeg een FAQ toe">
		<p class="a_validateTips">All form fields are required.</p>
		<form id="add_faq">
			<fieldset>
				<label for="a_vraag">Vraag</label>
				<input type="text" name="a_vraag" id="a_vraag" value="" class="text ui-widget-content ui-corner-all" />
				<label for="a_antwoord">Antwoord</label>
				<textarea name="a_antwoord" id="a_antwoord" cols="30" rows="10" class="text ui-widget-content ui-corner-all"></textarea>
			</fieldset>
		</form>
	</div>

	<div id="edit-form" class="hidden" title="Wijzig FAQ">
		<p class="e_validateTips">All form fields are required.</p>
		<form id="edit_faq">
			<fieldset>
				<input type="hidden" name="e_id" id="e_id" value="" />
				<input type="hidden" name="e_volgorde" id="e_volgorde" value="" />
				<label for="e_vraag">Vraag</label>
				<input type="text" name="e_vraag" id="e_vraag" value="" class="text ui-widget-content ui-corner-all" />
				<label for="e_antwoord">Antwoord</label>
				<textarea name="e_antwoord" id="e_antwoord" cols="30" rows="10" class="text ui-widget-content ui-corner-all"></textarea>
			</fieldset>
		</form>
	</div>
</body>
</html>
