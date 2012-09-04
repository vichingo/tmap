<?php /* Smarty version 2.6.26, created on 2010-08-10 15:48:42
         compiled from login.tpl */ ?>
<form name="login" method="POST" action="account.php?act=login">
	<div id="loginkolom">
		<?php 
			if (isset($_SESSION["foute_login"]) && $_SESSION["foute_login"] == true)
			{
		 ?>
		    <h5 class="login_error">Gebruikersnaam/E-mail en/of wachtwoord verkeerd</h5>
		<?php 
			unset($_SESSION["foute_login"]);
			}
		 ?>
		<h1>Login</h1>
		<div class="row">
			<div class="row_left">
				<label for="l_email">E-mail</label>
				<input type="text" name="l_email" id="l_email" value=""/>
			</div>
			<div class="row_right">
				<label for="l_wachtwoord">Wachtwoord</label>
				<input type="password" name="l_wachtwoord" id="l_wachtwoord" />
			</div>
		</div>
		<div class="row">
			<div class="row_right">
				<button type="submit" name="klant_login" id="klant_login">Login</button>
			</div>
		</div>
	</div>
</form>