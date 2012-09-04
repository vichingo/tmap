<?php
require_once '../includes/autoClass.php';

if ($_REQUEST["tabel"])
{
	$tabel = $_REQUEST["tabel"];
	switch ($tabel)
	{
	
	case "g":
		$g_obj = new gerecht();
		$g_obj->readLine($_REQUEST["id"]);
		echo $g_obj->makeJson();
		//echo $v_obj->c_Query;
		break;
	case "gb":
		$gb_obj = new gerecht_bestanddeel();
		$gb_obj->readLine($_REQUEST["id"]);
		echo $gb_obj->makeJson();
		//echo $v_obj->c_Query;
		break;
	}
}
?>
