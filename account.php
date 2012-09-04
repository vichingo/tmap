<?php
session_start();
require_once 'includes/autoClass.php';
require_once 'includes/validatie.php';


switch ($_GET["act"]) {
	case 'login':
		loginKlant();
		break;
	case 'registreer':
		registreerKlant();
		break;
	case 'logout':
		logoutKlant();
		break;
	case 'wijzig':
		wijzigKlant();
		break;
}

function loginKlant(){
	if (isset($_POST['l_email']) || isset($_POST['l_wachtwoord'])){



		$kl_login_email 		= $_POST["l_email"];
		$kl_login_wachtwoord 	= $_POST["l_wachtwoord"];

		$kl_login_email 		= stripslashes($kl_login_email);


		$klant_obj 					= new klant();
		$klant_obj->table_arr 		= array('klant');
		$klant_obj->column_arr 		= array('*');
		$kl_login_email 			= $klant_obj->escapeString($kl_login_email);
		$klant_obj->where_string	= "email = '" . $kl_login_email . "' AND
										   wachtwoord = '" . hash('sha1', $kl_login_wachtwoord) . "';"; //thuis hash('sha1', $kl_login_wachtwoord)
		$klant_obj->lijst = $klant_obj->lezen();
		//echo $klant_obj->r_Query;
		$klant_lijst = $klant_obj->lijst;
		$klant_rijen = $klant_obj->aantalRijen;
		// haal de id van de lokatie op voor de ingelogde klant;
		$kl_lokatie_id 		= $klant_lijst[0]->lokatie_id;
		$kl_id 				= $klant_lijst[0]->id;
		$kl_voornaam		= $klant_lijst[0]->voornaam;
		$kl_achternaam		= $klant_lijst[0]->achternaam;
		$kl_straat			= $klant_lijst[0]->straat;
		$kl_straat_nummer	= $klant_lijst[0]->straat_nummer;
		if($klant_lijst[0]->nummer_bus != ''){
			$kl_nummer_bus	= $klant_lijst[0]->nummer_bus;
		}
		$kl_straat			= $klant_lijst[0]->straat;
		$kl_tel_vast		= $klant_lijst[0]->tel_vast;
		$kl_tel_gsm			= $klant_lijst[0]->tel_gsm;
		$kl_email			= $klant_lijst[0]->email;
		$kl_promotie		= $klant_lijst[0]->promotie;


		$kl_geblokkeerd		= $klant_lijst[0]->geblokkeerd;
		// adres is altijd ff moeilijk

		/*
		 *  Ik wilde er een bus nummer bij zetten, maar dit zal alleen het zoeken in Google maps moeilijker maken
		 *  dus onderstaande relikwie is alleen om te laten zien dat het wel mogelijk is.
		 */
//		if (isset($klant_lijst[0]->nummer_bus)){
//			$kl_adres .= " " . $klant_lijst[0]->nummer_bus;
//		}

		$lok					= new lokatie();
		$lok->readLine($kl_lokatie_id);
		$lok_lijst 				= $lok->lijst;

		$plaats = 	$lok_lijst[0]->name;
		$postcode = $lok_lijst[0]->code;
		$kl_adres		= $klant_lijst[0]->straat . ' ' . $klant_lijst[0]->straat_nummer . ', ' . $postcode . ' ' . $plaats;

		$kl_wachtwoord	= $klant_lijst[0]->wachtwoord;


		if ($klant_rijen == 1){
			$wrongpass = false;
			if (!isset($_COOKIE[' . $kl_id . ']['loggedin'])){
				setcookie('klant[klant_id]', $kl_id , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][loggedin]', 'yes', time()+3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][username]', $kl_login_email, time()+ 3600 * 24 * 10); //10 dagen geldig
				setcookie('klant[' . $kl_id . '][wachtwoord]', $kl_wachtwoord, time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][lokatie_id]', $kl_lokatie_id , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][voornaam]', $kl_voornaam , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][achternaam]', $kl_achternaam , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][adres]', $kl_adres , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][straat]', $kl_straat , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][straat_nummer]', $kl_straat_nummer , time()+ 3600 * 24 * 10);
				if($klant_lijst[0]->nummer_bus != ''){
					setcookie('klant[' . $kl_id . '][nummer_bus]', $kl_nummer_bus , time()+ 3600 * 24 * 10);
				}
				setcookie('klant[' . $kl_id . '][tel_vast]', $kl_tel_vast , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][tel_gsm]', $kl_tel_gsm , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][email]', $kl_email , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][promotie]', $kl_promotie , time()+ 3600 * 24 * 10);
				setcookie('klant[' . $kl_id . '][geblokkeerd]', $kl_geblokkeerd , time()+ 3600 * 24 * 365);
			}
			$_SESSION['klantdata']	= $_POST;
			header('Location: index.php?lokatie=home');
		} else {
			//echo 'verkeerde wachtwoord/gebruikersnaam';
			$_SESSION['foute_login'] = true;
			header('Location: index.php?lokatie=inloggen');
			$wrongpass = true;
		}

	}
}

function logoutKlant(){
	//unset($_SESSION['mandje']);
	if (isset($_COOKIE[klant][klant_id])){
		$kl_id = $_COOKIE[klant][klant_id];
		if (isset($_COOKIE[klant][$kl_id][loggedin])){
			setcookie('klant[' . $kl_id . '][loggedin]', '', time() - (3600 * 24 * 100));
			foreach($_COOKIE[klant][$kl_id] as $key=>$value){
				setcookie('klant[' . $kl_id . '][' . $key . ']', '', time() - (3600 * 24 * 100));
			}
		}
		setcookie('klant[klant_id]', '', time() - (3600 * 24 * 100));
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}

function registreerKlant(){



	$regels = array(); // sla de validatie regels op.

	$regels[]	= "verplicht,voornaam,Dit veld is verplicht.";
	$regels[]	= "verplicht,achternaam,Dit veld is verplicht.";
	$regels[]	= "verplicht,straat,Dit veld is verplicht.";

	$regels[]	= "verplicht,straat_nummer,Dit veld is verplicht.";
	$regels[]	= "nummer,straat_nummer,Dit veld mag alleen maar cijfers bevatten.";

	//	$regels[]	= "verplicht,nummer_bus,Dit veld is verplicht.";
	$regels[]	= "nummer,nummer_bus,Dit veld mag alleen maar cijfers bevatten.";

	$regels[]	= "verplicht,lokatie_id,Dit veld is verplicht.";

	$regels[]	= "verplicht,tel_vast,Dit veld is verplicht.";
	$regels[]	= "nummer,tel_vast,Dit veld mag alleen maar cijfers bevatten.";
	$regels[]	= "lengte=10,tel_vast,Dit veld mag maar 10 cijfers bevatten.";

	$regels[]	= "verplicht,tel_gsm,Dit veld is verplicht.";
	$regels[]	= "nummer,tel_gsm,Dit veld mag alleen maar cijfers bevatten.";
	$regels[]	= "lengte=10,tel_gsm,Dit veld mag maar 10 cijfers bevatten.";

	$regels[]	= "verplicht,email,Dit veld is verplicht.";
	$regels[]	= "valide_email,email,E-mail is niet juist.";

	$regels[]	= "verplicht,wachtwoord,Dit veld is verplicht.";
	$regels[]	= "zelfde_als,wachtwoord,v_wachtwoord,Controleer of wachtwoorden identiiek zijn.";

	$fouten = valideerVelden($_POST, $regels);

	if(empty($fouten)){
		$_POST['wachtwoord'] = hash('sha1', $_POST['wachtwoord']);
		$klant = new klant();
		$klant->create();

		$lok					= new lokatie();
		$lok->readLine($_POST['lokatie_id']);
		$lok_lijst 				= $lok->lijst;

		$plaats = $lok_lijst[0]->name;
		$postcode = $lok_lijst[0]->code;

		$adres = $_POST['straat'] . ' ' . $_POST['straat_nummer'] . ', ' . $postcode . ' ' . $plaats;

		$klant_id = $klant->last_id;
		setcookie('klant[klant_id]', $klant_id , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][username]', $_POST['email'], time()+ 3600 * 24 * 10); //10 dagen geldig
		setcookie('klant[' . $klant_id . '][wachtwoord]', $_POST['wachtwoord'], time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][loggedin]',  'yes', time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][lokatie_id]', $_POST['lokatie_id'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][voornaam]', $_POST['voornaam'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][achternaam]', $_POST['achternaam'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][adres]', $adres , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][straat]', $_POST['straat'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][straat_nummer]', $_POST['straat_nummer'] , time()+ 3600 * 24 * 10);
		if($klant_lijst[0]->nummer_bus != ''){
			setcookie('klant[' . $klant_id . '][nummer_bus]', $_POST['nummer_bus'] , time()+ 3600 * 24 * 10);
		}
		setcookie('klant[' . $kl_id . '][tel_vast]', $_POST['tel_vast'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $kl_id . '][tel_gsm]', $_POST['tel_gsm'], time()+ 3600 * 24 * 10);
		setcookie('klant[' . $kl_id . '][email]', $_POST['email'] , time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][promotie]', $_POST['promotie'] , time()+ 3600 * 24 * 10);


		header('Location: index.php?lokatie=inloggen');
	} else {
		if(isset($_SESSION['fouten'])){
			unset($_SESSION['fouten']);
		}
		$_SESSION['fouten'];

		foreach($fouten as $key=>$value){
			$_SESSION['fouten'][$key] = $value;
		}
		echo '<pre>';
				var_dump($_POST);
		echo '</pre>';

		foreach($_POST as $key=>$value){
			$_SESSION['registreer_post'][$key] = $value;
		}
		echo '<pre>';
				var_dump($_SESSION);
		echo '</pre>';
		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}

}

function wijzigKlant(){
$regels = array(); // sla de validatie regels op.

	$regels[]	= "verplicht,voornaam,Dit veld is verplicht.";
	$regels[]	= "verplicht,achternaam,Dit veld is verplicht.";
	$regels[]	= "verplicht,straat,Dit veld is verplicht.";

	$regels[]	= "verplicht,straat_nummer,Dit veld is verplicht.";
	$regels[]	= "nummer,straat_nummer,Dit veld mag alleen maar cijfers bevatten.";

	//	$regels[]	= "verplicht,nummer_bus,Dit veld is verplicht.";
	$regels[]	= "nummer,nummer_bus,Dit veld mag alleen maar cijfers bevatten.";

	if($_POST['lokatie_id']){
		$regels[]	= "verplicht,lokatie_id,Dit veld is verplicht.";
	}


	$regels[]	= "verplicht,tel_vast,Dit veld is verplicht.";
	$regels[]	= "nummer,tel_vast,Dit veld mag alleen maar cijfers bevatten.";
	$regels[]	= "lengte=10,tel_vast,Dit veld mag maar 10 cijfers bevatten.";

	$regels[]	= "verplicht,tel_gsm,Dit veld is verplicht.";
	$regels[]	= "nummer,tel_gsm,Dit veld mag alleen maar cijfers bevatten.";
	$regels[]	= "lengte=10,tel_gsm,Dit veld mag maar 10 cijfers bevatten.";

	$regels[]	= "verplicht,email,Dit veld is verplicht.";
	$regels[]	= "valide_email,email,E-mail is niet juist.";

	if($_POST['wachtwoord']){
			$regels[]	= "verplicht,wachtwoord,Dit veld is verplicht.";
			$regels[]	= "zelfde_als,wachtwoord,v_wachtwoord,Controleer of wachtwoorden identiiek zijn.";
	}

	$fouten = valideerVelden($_POST, $regels);

	if(empty($fouten)){
		if(isset($_SESSION['fouten'])){
			unset($_SESSION['fouten']);
		}

		if($_POST['wachtwoord']){
			$_POST['wachtwoord'] = hash('sha1', $_POST['wachtwoord']);
		}

		if($_POST["nummer_bus"] == ''){
			unset($_POST["nummer_bus"]);
		}
		if($_POST['promotie'] == 'true'){
			$_POST['promotie'] = 1;
		} else {
			$_POST['promotie'] = 0;
		}
		$klant_id = $_COOKIE[klant][klant_id];

		$wijzig_klant = new klant();
		$wijzig_klant->updateNaRegistratie($klant_id);

		$lok					= new lokatie();
		if ($_POST['lokatie_id']){
			$lok->readLine($_POST['lokatie_id']);
		} else {
			$lok->readLine($_COOKIE[klant][$klant_id]['lokatie_id']);
		}

		$lok_lijst 				= $lok->lijst;

		$plaats = $lok_lijst[0]->name;
		$postcode = $lok_lijst[0]->code;

		$adres = $_POST['straat'] . ' ' . $_POST['straat_nummer'] . ', ' . $postcode . ' ' . $plaats;



		foreach($_POST as $key=>$value){
			setcookie('klant[' . $klant_id . '][' . $key . ']', $value, time()+ 3600 * 24 * 10);
		}
		setcookie('klant[' . $klant_id . '][promotie]',  $_POST['promotie'], time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][loggedin]',  'yes', time()+ 3600 * 24 * 10);
		setcookie('klant[' . $klant_id . '][adres]', $adres , time()+ 3600 * 24 * 10);

		header('Location: index.php?lokatie=klantdata');
	} else {
		if(isset($_SESSION['fouten'])){
			unset($_SESSION['fouten']);
		}
		$_SESSION['fouten'];

		foreach($fouten as $key=>$value){
			$_SESSION['fouten'][$key] = $value;
		}
//		echo '<pre>';
//				var_dump($_POST);
//		echo '</pre>';

		foreach($_POST as $key=>$value){
			$_SESSION['registreer_post'][$key] = $value;
		}
//		echo '<pre>';
//				var_dump($_SESSION);
//		echo '</pre>';
		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}
}
?>