<?php

function valideerVelden($velden, $regels){
	$fouten = array();

	for($i = 0; $i<count($regels); $i++	){
		$rij			= explode (",", $regels[$i]);
		$verplichting 	= $rij[0];
		$veld_naam		= $rij[1];


		if (count($rij) == 4){
			$veld_naam_2 	= $rij[2];
			$foutmelding	= $rij[3];
		} else {
			$foutmelding	= $rij[2];
		}

		if (preg_match("/^lengte/", $verplichting)){
			$lengte_verplichting	= $verplichting;
			$verplichting 			= "lengte";
		}

		switch($verplichting){
			case "verplicht":
				if (!isset($velden[$veld_naam]) || $velden[$veld_naam] == ""){
					$fouten[$veld_naam][] = $foutmelding;
				}
				break;
			case "lengte":
				$vergelijkings_regel	= "";
				$regel_string			= "";

				if (preg_match("/lengte=/", $lengte_verplichting)){
					$vergelijkings_regel 	= "gelijk";
					$regel_string			= preg_replace("/lengte=/", "", $lengte_verplichting);
				}

				switch ($vergelijkings_regel){
					case "gelijk":
						if (strlen($velden[$veld_naam]) != $regel_string) {
							$fouten[$veld_naam][] = $foutmelding;
						}
				}
				break;
			case "nummer":
				if(isset($velden[$veld_naam]) && preg_match("/\D/", $velden[$veld_naam])){
					$fouten[$veld_naam][] = $foutmelding;
				}
				break;
			case "valide_email":
				$regexp = "/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/i";
				if (isset($velden[$veld_naam]) && !empty($velden[$veld_naam]) && !preg_match($regexp, $velden[$veld_naam])){
					$fouten[$veld_naam][] = $foutmelding;
				}
				break;
			case "zelfde_als":
				if($velden[$veld_naam] != $velden[$veld_naam_2]){
					$fouten[$veld_naam][] = $foutmelding;
				}
				break;
			}
	}
	return $fouten;
}
?>
