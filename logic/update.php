<?php
//echo "<pre>";
//	var_dump($_POST);
//echo "</pre>";

require_once '../../includes/autoClass.php';

if ($_POST["tabel"])
{
	$tabel = $_GET["tabel"];
	switch ($tabel)
	{
	case "vc":
		$vc_obj = new voedsel_categorie();
		$vc_obj->update();
		//echo $vc_obj->u_Query;
		break;
	case "bd":
		$bd_obj = new bestanddeel();
		$bd_obj->update();
		//echo $bd_obj->u_Query;
		break;
	case "m":
		$m_obj = new menu();
		$m_obj->update();
		//echo $m_obj->u_Query;
		break;
	case "go":
		$go_obj = new gerecht_opties();
		$go_obj->update();
		//echo $go_obj->u_Query;
		break;
	case "ov":
		$ov_obj = new optie_variant();
		$ov_obj->update();
		//echo $ov_obj->u_Query;
		break;
	case "gb":
		$gb_obj = new gerecht_bestanddeel();
		$gb_obj->update();
		//echo $gb_obj->u_Query;
		break;
	case "g":
		$g_obj = new gerecht();
		$g_obj->update();
		//echo $g_obj->u_Query;
		break;
	case "gebruikers":
		$gebruikers_obj = new gebruikers();
		$gebruikers_obj->update();
		//echo $gebruikers_obj->u_Query;
		break;
	case "klanten":
		$klanten_obj = new klanten();
		$klanten_obj->update();
		//echo $klanten_obj->u_Query;
		break;
	}
}
?>