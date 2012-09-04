<?php

require_once '../../includes/autoClass.php';

if ($_REQUEST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
	switch ($tabel)
	{
	case "bd":
		$bd_obj = new bestanddeel();
		$bd_obj->read();
		echo $bd_obj->makeJson();
		//$bd_Query = $bd_obj->r_Query;
		//$bd_obj->showQuery($bd_Query);
		break;
	case "klant":
		$klant_obj = new klant();
		$klant_obj->read();
		echo $klant_obj->makeJson();
		//$klant_Query = $klant_obj->r_Query;
		//$klant_obj->showQuery($klant_Query);
		break;
	}
}
?>
