<?php
require_once '../../includes/autoClass.php';
require_once '../../flock/php.flock.php';

echo '<pre>';
	var_dump($_POST);
echo '</pre>';

$gebruiker_obj = new gebruikers();
$gebruiker_obj->table_arr 	= array('gebruikers');
$gebruiker_obj->column_arr 	= array('*');
$gebruiker_obj->where_arr	= array('login_naam'=>$_POST["login_naam"],
									'login_wachtwoord' => hash('sha1', $_POST["login_wachtwoord"]));
$gebruiker_obj->read();
$gebruiker_rijen = $gebruiker_obj->aantalRijen;
echo $gebruiker_obj->makeJson();


if ($gebruiker_rijen != 0)
{
	session_start();
	session_register('authorized');
    $_SESSION['authorized'] = true;
	header("Location: index.php");
    exit;
}
else
{
    exit;
}

?>