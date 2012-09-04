<?php
session_start();
require_once 'includes/autoClass.php';


//echo '<pre>';
//		var_dump($_POST);
//echo '</pre>';

switch ($_GET["act"]) {
	case 'toevoegen':
		addBericht();
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
}

function addBericht(){
	$naam 		= $_POST['gb_naam'];
	$email 		= stripslashes($_POST['gb_email']);
	$bericht	= strip_tags($_POST['gb_bericht'], '<b><br>');
	$post_tijd	= time();
	$ip			= $_SERVER['REMOTE_ADDR'];

	if($_POST['gb_naam'] != '' && $_POST['gb_email'] != '' && $_POST['gb_bericht'] != ''){
		$addendum				= new gastenboek();
		$email					= $addendum->escapeString($email);
		$addendum->table_arr	= array('gastenboek');
		$addendum->column_arr	= array('id','naam','email','bericht','post_tijd','ip');
		$addendum->value_arr	= array(NULL, $naam, $email, $bericht, $post_tijd, $ip);
		$addendum->nieuw();
	}
}

?>