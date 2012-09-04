<?php
require_once '../../includes/autoClass.php';

//echo '<pre>';
//	var_dump($_POST);
//echo '</pre>';

if ($_POST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
	switch ($tabel)
	{
	case "vc":
		$vc_obj = new voedsel_categorie();
		$vc_obj->create();
		//echo $bd_obj->c_Query;
		break;
	case "bd":
		$bd_obj = new bestanddeel();
		$bd_obj->create();
		//echo $bd_obj->c_Query;
		break;
	case "m":
		$m_obj = new menu();
		$m_obj->create();
		//echo $m_obj->c_Query;
		break;
	case "go":
		$go_obj = new gerecht_opties();
		$go_obj->create();
		//echo $go_obj->c_Query;
		break;
	case "ov":
		$ov_obj = new optie_variant();
		$ov_obj->create();
		//echo $ov_obj->c_Query;
		break;
	case "gb":
		$gb_obj = new gerecht_bestanddeel();
		$gb_obj->create();
		//echo $gb_obj->c_Query;
		break;
	case "g":
		$g_obj = new gerecht();
		$g_obj->create();
		//echo $g_obj->c_Query;
		break;
	case "gebruikers":
		$gebruikers_obj = new gebruikers();
		$gebruikers_obj->create();
		//echo $gebruikers_obj->c_Query;
		break;
	case "klant":
		$klant_obj = new klant();
		$klant_obj->create();
		echo $klant_obj->c_Query;
		break;
	case "resto":
		$resto_obj = new resto();
		$resto_obj->create();
		echo $resto_obj->c_Query;
		break;
	case "li":
		$li_obj = new leveren_in();
		$li_obj->create();
		//echo $li_obj->c_Query;
		break;
	case "faqs":
		$faq_obj = new faqs();
		$faq_obj->create();
		//echo $faq_obj->c_Query;
		break;
	case "gastenboek":
		$gastenboek_obj = new gastenboek();
		$gastenboek_obj->create();
		//echo $gastenboek_obj->c_Query;
		break;
	}
}
?>
