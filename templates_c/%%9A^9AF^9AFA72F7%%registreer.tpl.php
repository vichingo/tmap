<?php /* Smarty version 2.6.26, created on 2010-08-16 09:02:59
         compiled from registreer.tpl */ ?>
<?php 
	$_POST = $_SESSION['registreer_post'];

 ?>
<form name="registreer" method="post" action="account.php?act=registreer">
	<input type="hidden" name="aanmaakdatum" value="<?php  echo time(); ?>"/>
	<div id="registreerkolom">
		<h1>Registreren</h1>
		<div class="row">
			<div class="row_header">Naam</div>
			<div class="row_left">
				<label for="voornaam">Voornaam</label>
				<input type="text" name="voornaam" id="voornaam" value="<?php  echo $_SESSION[registreer_post]['voornaam']; ?>" />
			</div>
			<div class="row_right">
				<label for="achternaam">Achternaam</label>
				<input type="text" name="achternaam" id="achternaam" value="<?php  echo $_SESSION[registreer_post]['achternaam']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="row_header">Adres</div>
			<div class="row_left">
				<label for="straat">Straat</label>
				<input type="text" name="straat" id="straat" value="<?php  echo $_SESSION[registreer_post]['straat']; ?>" />
			</div>
			<div class="row_right">
				<label for="straat_nummer">Nummer</label>
				<input type="text" name="straat_nummer" id="straat_nummer" value="<?php  echo $_SESSION[registreer_post]['straat_nummer']; ?>" />
			</div>
			<div class="row_right">
				<label for="nummer_bus">Bus</label>
				<input type="text" name="nummer_bus" id="nummer_bus" value="<?php  echo $_SESSION[registreer_post]['nummer_bus']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="row_left">
				<label for="lokatie_id">Woonplaats</label>
				<select name="lokatie_id" id="lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					<?php $_from = $this->_tpl_vars['leveren_in']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['leverplaats']):
?>
					<option value="<?php echo $this->_tpl_vars['leverplaats']->id; ?>
"><?php echo $this->_tpl_vars['leverplaats']->name; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="row_header">Contactgegevens</div>
			<div class="row_left">
				<label for="tel_vast">Vast nummer</label>
				<input type="text" name="tel_vast" id="tel_vast" value="<?php  echo $_SESSION[registreer_post]['tel_vast']; ?>" />
			</div>
			<div class="row_right">
				<label for="tel_gsm">GSM nummer</label>
				<input type="text" name="tel_gsm" id="tel_gsm" value="<?php  echo $_SESSION[registreer_post]['tel_gsm']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="row_header">Login gegevens</div>
			<div class="row_left">
				<label for="email">E-mail</label>
				<input type="text" name="email" id="email" value="<?php  echo $_SESSION[registreer_post]['email']; ?>" />
			</div>
			<div class="row_right">
				<label for="wachtwoord">Wachtwoord</label>
				<input type="password" name="wachtwoord" id="wachtwoord" />
			</div>
			<div class="row_right">
				<label for="v_wachtwoord">Bevestig Wachtwoord</label>
				<input type="password" name="v_wachtwoord" id="v_wachtwoord" />
			</div>
		</div>
		<div class="row">
			<div class="row_header">Promoties</div>
			<div class="row_left">
				<label for="promotie">Mogen wij u van onze promoties op de hoogte stellen</label>
				<input type="checkbox" name="promotie" id="promotie" value="ja" />
			</div>
		</div>
		<div class="row">
			<div id="reg_errors">
				<ul class="fouten_lijst">
				<?php $_from = $this->_tpl_vars['fouten']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['foutjes']):
?>
					<li> Veld <?php echo $this->_tpl_vars['k']; ?>
 meldt:
						<ul class="foutjes">
						<?php $_from = $this->_tpl_vars['foutjes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fout']):
?>
							<li><?php echo $this->_tpl_vars['fout']; ?>
</li>
						<?php endforeach; endif; unset($_from); ?>
						</ul>
					</li>
				<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="row_left">
				<button type="submit" name="klant_registreer" id="klant_registreer">Registreer</button>
			</div>
		</div>
	</div>
</form>