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
	}
}
?>
