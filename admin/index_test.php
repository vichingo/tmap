<?php
session_start();


if (!empty($_POST)){

	if (isset($_POST['login_naam']) || isset($_POST['login_wachtwoord'])){
			$_COOKIE['authorized'] = 'yes';
	}
	echo "volle_post";

} else {
	echo"lege post";
	if ($_REQUEST["logout"]){
		$_COOKIE['authorized'] = 'no';
		//setcookie("authorized", "", time() - 3600);
		//header("Location: " . $_SERVER["PHP_SELF"]);
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Admin TMAP</title>
	</head>
	<body>
	<?php
		//wensput

//		echo $_COOKIE['authorized'];
		echo '<pre>';
			var_dump($_COOKIE);
		echo '</pre>';
//
//
//		echo $gebruiker_rijen;
//		echo $gebruiker_obj->r_Query;

		/*
		 * controleer of login juist is,  of gebruiker al een cookie heeft die op true staat
		 */

		if ($_COOKIE['authorized'] == 'yes'){
			setcookie("authorized", 'yes', time()+3600);
			echo '<pre>';
				var_dump($_COOKIE);
			echo '</pre>';
	?>
		<div id="outer">
			We zijn nu ingelogt
			<a href="<?php echo $_SERVER["PHP_SELF"]. "?logout=true"; ?>">Logout</a>
		</div>
	<?php
		} else {
	?>
	<div>
		<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
			<input type="text" name="login_naam"/>
			<input type="password" name="login_wachtwoord"/>
			<input type="submit" value="Login"/>
		</form>
	</div>
	<?php
		}
	?>

	</body>
</html>
