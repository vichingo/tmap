<?php
require_once '../../includes/autoClass.php';

if ($_REQUEST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
	switch ($tabel)
	{
	case "vc":
		$vc_obj = new voedsel_categorie();
		$vc_obj->readLine($_REQUEST["id"]);
		echo $vc_obj->makeJson();
		break;
	case "bd":
		$bd_obj = new bestanddeel();
		$bd_obj->readLine($_REQUEST["id"]);
		echo $bd_obj->makeJson();
		//echo $bd_obj->makeJson();
		break;
	case "m":
		$m_obj = new menu();
		$m_obj->readLine($_REQUEST["id"]);
		echo $m_obj->makeJson();
		//echo $m_obj->r_Query;
		break;
	case "go":
		$go_obj = new gerecht_opties();
		$go_obj->readLine($_REQUEST["id"]);
		echo $go_obj->makeJson();
		//echo $go_obj->r_Query;
		break;
	case "ov":
		$ov_obj = new optie_variant();
		$ov_obj->readLine($_REQUEST["id"]);
		echo $ov_obj->makeJson();
		//echo $ov_obj->r_Query;
		break;
	case "gb":
		$gb_obj = new gerecht_bestanddeel();
		$gb_obj->readLine($_REQUEST["id"]);
		echo $gb_obj->makeJson();
		//echo $v_obj->c_Query;
		break;
	case "g":
		$g_obj = new gerecht();
		$g_obj->readLine($_REQUEST["id"]);
		echo $g_obj->makeJson();
		//echo $v_obj->c_Query;
		break;
	case "gebruikers":
		$gebruiker_obj = new gebruikers();
		$gebruiker_obj->readLine($_REQUEST["id"]);
		echo $gebruiker_obj->makeJson();
		//echo $gebruiker_obj->c_Query;
		break;
	case "klant":
		$klant_obj = new klant();
		$klant_obj->readLine($_REQUEST["id"]);
		echo $klant_obj->makeJson();
		//echo $klant_obj->r_Query;
		break;
	case "resto":
		$resto_obj = new resto();
		$resto_obj->readLine($_REQUEST["id"]);
		echo $resto_obj->makeJson();
		//echo $resto_obj->r_Query;
		break;
	case "li":
		$li_obj = new leveren_in();
		$li_obj->readLine($_REQUEST["id"]);
		echo $li_obj->makeJson();
		//echo $li_obj->r_Query;
		break;
	case "faqs":
		$faq_obj = new faqs();
		$faq_obj->readLine($_REQUEST["id"]);
		echo $faq_obj->makeJson();
		//echo $li_obj->r_Query;
		break;
	case "gastenboek":
		$gastenboek_obj = new gastenboek();
		$gastenboek_obj->readLine($_REQUEST["id"]);
		echo $gastenboek_obj->makeJson();
		//echo $gastenboek_obj->r_Query;
		break;
	}
}
?>
