<?php
//gebruik of start de sessie
session_start();

/*
 * Omdat ik werk met objecten moeten we die via
 * de onderstaande require in kunnen laden door later in het script
 * alleen maar $var = new ObjectInstance(); te initieren.
 */
require_once 'includes/autoClass.php';

/*
 * hier haal ik de key=>value paren op van alle
 * mogelijke opties en steek ze in een array $opties
 */
//$opties = tardis::array_search_key('optie', $_POST);
//
//echo '<pre>';
//		var_dump($_POST);
//echo '</pre>';
/*
 * Objecten aanmaken
 *
 *
 *
 */
/*$opties = new gerecht_opties();
$opties->read();
$optie_lijst = $opties->lijst;

$optie_variant = new optie_variant();
$optie_variant->read();
$optie_variant_lijst = $optie_variant->lijst;

echo '<pre>';
		var_dump($optie_lijst);
echo '</pre>';

echo '<pre>';
		var_dump($optie_variant_lijst);
echo '</pre>';*/


/*
 * switch door alle mogelijk winkelwagen acties
 */

switch ($_REQUEST["act"]) {
	case verzamelen:
		addtocart();
		break;
	case verwijderen:
		removefromcart();
		break;
	case vermeerderen:
		verhoogLijn();
		break;
	case verminderen:
		verlaagLijn();
		break;
	case leegSessie:
		clearSession();
		break;
	case mandjelegen:
		leegMandje();
		break;
}

/*
 * Voeg gekozen gerecht toe aan mandje
 *
 * Controleer of er niet een zelfde gerecht gekozen is door
 * het gerecht_id en de prijs (opties veranderen de prijs) te vergelijken.
 */
function addtocart(){

	$aantal 		= 1;
	$lijn_id 		= $_POST['lijn_id'];
	$gerecht_id 	= $_POST['gerecht_id'];
	$gerecht_naam	= $_POST['gerecht_naam'];
	$gerecht_prijs	= $_POST['gerecht_prijs'];
	$gerecht_prijs	= number_format($gerecht_prijs, 2);
	$opties			= $_POST['optie'];

	$lijn_totaal_prijs	= floatval($_POST['gerecht_prijs']);
	$lijn_totaal_prijs	= number_format($lijn_totaal_prijs, 2);

	if(is_array($_SESSION['mandje'])){

		$max=count($_SESSION['mandje']);
		$_SESSION['mandje'][$max]['aantal']				= $aantal;
		$_SESSION['mandje'][$max]['lijn_id']			= $lijn_id;
		$_SESSION['mandje'][$max]['gerecht_id']			= $gerecht_id;
		$_SESSION['mandje'][$max]['gerecht_naam']		= $gerecht_naam;
		$_SESSION['mandje'][$max]['gerecht_prijs']		= $gerecht_prijs;
		$_SESSION['mandje'][$max]['lijn_totaal_prijs']	= $gerecht_prijs;
		if ($opties){
			foreach($opties as $naam=>$matrix){
				//bouw cart sessie waarde
				$pieces = explode("_", $matrix);
				$optie_id = $pieces[0];
				$_SESSION['mandje'][$max]['optie'][$naam]		= $optie_id;
			}
		}
		$dubbel = false;
		for ($i = 0; $i<$max ; $i++){
			if($_SESSION['mandje'][$i]['gerecht_id'] == $gerecht_id){
				if($_SESSION['mandje'][$i]['gerecht_prijs'] == $gerecht_prijs){
					$dubbel = true;
				}
			}
			if ($dubbel){
				$_SESSION['mandje'][$i]['lijn_id']		= $lijn_id;
				unset($_SESSION['mandje'][$max]);
				$_SESSION['mandje'][$i]['aantal']++;
				$nieuwe_totaal_prijs = $_SESSION['mandje'][$i]['gerecht_prijs'] * $_SESSION['mandje'][$i]['aantal'];
				$_SESSION['mandje'][$i]['lijn_totaal_prijs'] = number_format($nieuwe_totaal_prijs, 2);
			}
		}
	} else {
		$_SESSION['mandje']=array();
		$_SESSION['mandje'][0]['aantal']				= $aantal;
		$_SESSION['mandje'][0]['lijn_id']				= $lijn_id;
		$_SESSION['mandje'][0]['gerecht_id']			= $gerecht_id;
		$_SESSION['mandje'][0]['gerecht_naam']			= $gerecht_naam;
		$_SESSION['mandje'][0]['gerecht_prijs']			= $gerecht_prijs;
		$_SESSION['mandje'][0]['lijn_totaal_prijs']		= $gerecht_prijs;
		if ($opties){
			foreach($opties AS $naam=>$matrix){
				//bouw cart sessie waarde
				$pieces = explode("_", $matrix);
				$optie_id = $pieces[0];
				$_SESSION['mandje'][0]['optie'][$naam]		= $optie_id;
			}
		}
	}
//	echo '<pre>';
//		var_dump($_SESSION['mandje']);
//	echo '</pre>';
header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function removefromcart(){
	$lijn = intval($_REQUEST["lijnid"]);
	$max=count($_SESSION['mandje']);
	for($i=0;$i<$max;$i++){
		if($lijn == $_SESSION['mandje'][$i]['lijn_id']){
			unset($_SESSION['mandje'][$i]);
			break;
		}
	}
	$_SESSION['mandje']=array_values($_SESSION['mandje']);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function verhoogLijn(){
	$lijn = intval($_REQUEST["lijnid"]);
	$max=count($_SESSION['mandje']);
	for($i=0;$i<$max;$i++){
		if($lijn == $_SESSION['mandje'][$i]['lijn_id']){
			$_SESSION['mandje'][$i]['aantal']++;
			$nieuwe_totaal_prijs = $_SESSION['mandje'][$i]['gerecht_prijs'] * $_SESSION['mandje'][$i]['aantal'];
			$_SESSION['mandje'][$i]['lijn_totaal_prijs'] = number_format($nieuwe_totaal_prijs, 2);
			break;
		}
	}
	$_SESSION['mandje']=array_values($_SESSION['mandje']);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function verlaagLijn(){
	$lijn = intval($_REQUEST["lijnid"]);
	$max=count($_SESSION['mandje']);
	for($i=0;$i<$max;$i++){
		if($lijn == $_SESSION['mandje'][$i]['lijn_id']){
			$_SESSION['mandje'][$i]['aantal']--;
			$nieuwe_totaal_prijs = $_SESSION['mandje'][$i]['lijn_totaal_prijs'] - $_SESSION['mandje'][$i]['gerecht_prijs'];
			$_SESSION['mandje'][$i]['lijn_totaal_prijs'] = number_format($nieuwe_totaal_prijs, 2);
			break;
		}
	}
	$_SESSION['mandje']=array_values($_SESSION['mandje']);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function clearSession(){
	unset($_SESSION['mandje']);
	unset($_SESSION['totalen']);
	unset($_SESSION['reservatie_tijd']);
	unset($_SESSION['leverwijze_id']);
	unset($_SESSION['fouten']);
	unset($_SESSION['levertijd_is_vroeger']);
	unset($_COOKIE['klant']);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
function leegMandje(){
	unset($_SESSION['mandje']);
	unset($_SESSION['totalen']);
	unset($_SESSION['reservatie_tijd']);
	unset($_SESSION['leverwijze_id']);
	header('Location: index.php');
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
