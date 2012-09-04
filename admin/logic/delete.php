<?php

//echo "<pre>";
//	var_dump($_POST);
//echo "</pre>";

require_once '../../includes/autoClass.php';

if ($_POST["tabel"])
{
	$tabel = $_POST["tabel"];
	switch ($tabel)
	{
	case "vc":
		$vc_obj = new voedsel_categorie();
		$vc_obj->delete();
		break;
	case "bd":
		$bd_obj = new bestanddeel();
		$bd_obj->delete();
		break;
	case "m":
		$m_obj = new menu();
		$m_obj->delete();
		break;
	case "go":
		$go_obj = new gerecht_opties();
		$go_obj->delete();
	case "ov":
		$ov_obj = new optie_variant();
		$ov_obj->delete();
		break;
	case "gb":
		$gb_obj = new gerecht_bestanddeel();
		$gb_obj->delete();
		//echo $v_obj->d_Query;
		break;
	case "g":
		$g_obj = new gerecht();
		$g_obj->delete();
		//echo $g_obj->d_Query;
		break;
	case "gebruikers":
		$gebruiker_obj = new gebruikers();
		$gebruiker_obj->delete();
		//echo $gebruiker_obj->d_Query;
		break;
	case "klant":
		$klant_obj = new klant();
		$klant_obj->delete($_POST['id']);
		echo $klant_obj->d_Query;
		break;
	case "resto":
		$resto_obj = new resto();
		$resto_obj->delete($_POST['id']);
		echo $resto_obj->d_Query;
		break;
	case "li":
		$li_obj = new leveren_in();
		$li_obj->delete($_POST['id']);
		echo $li_obj->d_Query;
		break;
	case "faq":
		$faq_obj = new faqs();
		$faq_obj->delete($_POST['id']);
		echo $faq_obj->d_Query;
		break;
	case "gastenboek":
		$gastenboek_obj = new gastenboek();
		$gastenboek_obj->delete($_POST['id']);
		echo $faq_obj->d_Query;
		break;
	}
}
?>
