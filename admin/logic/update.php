<?php
//echo "<pre>";
//	var_dump($_REQUEST);
//echo "</pre>";

//require_once 'includes/autoClass.php';
require '../../includes/autoClass.php';

if ($_POST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
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
	case "klant":
		$klant_obj = new klant();
		$klant_obj->update(id, $_POST['id']);
		echo $klant_obj->u_Query;
		break;
	case "resto":
		$resto_obj = new resto();
		$resto_obj->update(id, $_POST['id']);
		echo $resto_obj->u_Query;
		break;
	case "li":
		$li_obj = new leveren_in();
		$li_obj->update(id, $_POST['id']);
		echo $li_obj->u_Query;
		break;
	case "faqs":
		$faq_obj = new faqs();
		$faq_obj->update(id, $_POST['id']);
		echo $faq_obj->u_Query;
		break;
	case "gastenboek":
		$gastenboek_obj = new gastenboek();
		$gastenboek_obj->update(id, $_POST['id']);
		//echo $gastenboek_obj->u_Query;
		break;
	}

}

if ($_REQUEST["act"] == 'sorteren'){

//	echo "<pre>";v
	$items = $_POST['item'];
	$length = count($items);
	for($i=0;$i<$length;$i++){
		$faq_sort = new faqs();
		$faq_sort->changeOrder($i, $items[$i]);
	}
}
?>