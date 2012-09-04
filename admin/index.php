<?php
session_start();
require_once '../includes/autoClass.php';
//echo '<pre>';
//			var_dump($_COOKIE);
//echo '</pre>';

if (isset($_POST['login_naam']) || isset($_POST['login_wachtwoord'])){


	$login_naam 		   = $_POST["login_naam"];
	$login_wachtwoord  = $_POST["login_wachtwoord"];

	$login_naam 		   = stripslashes($login_naam);


	$gebruiker_obj = new gebruikers();
	$gebruiker_obj->table_arr 		= array('gebruikers');
	$gebruiker_obj->column_arr 		= array('*');
	$login_naam 					        = $gebruiker_obj->escapeString($login_naam);
	$gebruiker_obj->where_string	= "login_naam = '" . $login_naam . "' AND
									   login_wachtwoord= '" . hash('sha1', $login_wachtwoord) . "'";
	$gebruiker_obj->lezen();
	$gebruiker_rijen = $gebruiker_obj->aantalRijen;

	if ($gebruiker_rijen == 1){
		$wrongpass = false;
		if (!isset($_COOKIE['authorized'])){
			echo"we zetten het cookie";
			setcookie('authorized', 'yes', time()+3600*24);
		}
		//setcookie('authorized', 'yes', time()+3600*24);
		//$_COOKIE['authorized'] = 'yes';
		header('location: '. $_SERVER["PHP_SELF"]);
	} else {
		$wrongpass = true;
	}

}
if ($_REQUEST["logout"]){
	if (isset($_COOKIE['authorized'])){
		echo"we verwijderen het cookie";
		setcookie('authorized', '', time()-3600*24*100);
	}
	header('location: '. $_SERVER["PHP_SELF"]);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Admin TMAP</title>
<?php
include 'header_admin.inc';
?>

<script type="text/javascript" language="javascript" src="../lib/jquery/plugins/jquery.maskedinput-1.2.2.js"></script>
		<script language="javascript" type="text/javascript" src="../scripts/jqueryslidemenu.js"></script>
		<style type="text/css" media="screen">
			<!--
			#venster {
				overflow: auto;
				position: fixed;
				z-index:-100;
				top: 30px; /*Set top value to HeightOfFrameDiv*/
				left: 0;
				right: 0;
				bottom: 0;
			}


			body{
				margin: 0;
				padding: 0;
				border: 0;
				overflow: hidden;
				height: 100%;
				max-height: 100%;
			}

			#header{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 30px; /*Height of frame div*/
				//overflow: hidden; /*Disable scrollbars. Set to "scroll" to enable*/
				background-color: navy;
				color: white;
			}

			* html body{ /*IE6 hack*/
				padding: 30px 0 0 0; /*Set value to (HeightOfFrameDiv 0 0 0)*/
			}

			* html #venster{ /*IE6 hack*/
				height: 100%;
				width: 100%;
			}
			-->
		</style>
	</head>
	<body>
	<?php
		//wensput

		if (isset($_COOKIE['authorized'])){
	?>
		<div id="outer">
			<div id="header">
				<div id="myslidemenu" class="jqueryslidemenu">
					<ul>
						<li><a href="#">Beheer menu's</a>
							<ul>
								<li><a href="beheer_menu.php" target="content">Menu soorten</a></li>
								<li><a href="beheer_gerecht.php" target="content">Gerecht</a>
									<ul>
										<li><a href="beheer_gerecht_opties.php" target="content">Opties</a>
											<ul>
												<li><a href="beheer_optie_variant.php" target="content">Varianten</a></li>
											</ul>
										</li>
										<li><a href="beheer_gerecht_bestanddeel.php" target="content">Bestanddelen</a></li>
									</ul>
								</li>
								<li><a href="beheer_bestanddeel.php" target="content">Bestanddelen</a></li>
								<li><a href="beheer_voedsel_categorie.php" target="content">Voedsel categorien</a></li>
							</ul>
						</li>
						<li><a href="beheer_gebruikers.php" target="content">Beheer gebruikers</a></li>
						<li><a href="beheer_klant.php" target="content">Beheer klanten</a></li>
						<li><a href="#">Bestellingen</a>
							<ul>
								<li><a href="beheer_alle_bestellingen.php" target="content">Alle bestellingen</a></li>
								<li><a href="beheer_toekomstige_bestellingen.php" target="content">Toekomstige bestellingen</a></li>
							</ul>
						</li>
						<li><a href="#">Restaurant(s)</a>
							<ul>
								<li><a href="beheer_resto.php" target="content">Beheer restaurant(s)</a></li>
								<li><a href="beheer_leveren_in.php" target="content">Beheer bezorg radius</a></li>
							</ul>
						</li>
						<li><a href="#">Planning</a>
							<ul>
								<li><a href="#">Beheer Planning</a></li>
								<li><a href="#">Route's</a></li>
							</ul>
						</li>
						<li><a href="#">FAQ &#38 GB</a>
							<ul>
								<li><a href="beheer_faqs.php" target="content">Beheer FAQ's</a></li>
								<li><a href="beheer_gastenboek.php" target="content">Beheer gastenboek</a></li>
							</ul>
						</li>
						<li><a href="../index.php?lokatie=home">Website</a></li>
						<li><a href="<?php echo $_SERVER["PHP_SELF"]. "?logout=true"; ?>">Logout</a></li>
					</ul>
					<br style="clear: left"/>
				</div>
			</div>
			<div id="venster">
			<iframe name="content" width="100%" height="100%" scrolling="auto" id="content" frameborder="0" src="iframe_dummy.html">
			</iframe>
			</div>
		</div>
	<?php
		} else {
	?>
	<div>
		<h3>Login</h3>
		<?php
			if ($wrongpass){
				?>
				<h5>Login/wachtwoord verkeerd</h5>
				<?php
			}
		?>
		<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
			<label for="login_naam" style="display:block">Login</label>
			<input type="text" name="login_naam"/>
			<label for="login_wachtwoord" style="display:block">Wachtwoord</label>
			<input type="password" name="login_wachtwoord"/>
			<button type="submit" name="login" value="Login">Login</button>
		</form>
	</div>
	<?php
		}
	?>

	</body>
</html>
