<?php

echo "<pre>";
	var_dump($_POST);
echo "</pre>";

require_once '../../includes/autoClass.php';

if ($_POST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
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
	}
}
?>
