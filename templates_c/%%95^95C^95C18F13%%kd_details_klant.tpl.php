<?php /* Smarty version 2.6.26, created on 2010-08-16 12:58:45
         compiled from kd_details_klant.tpl */ ?>
<?php 

include 'includes/objecten.php';

if (isset($_COOKIE['klant']['klant_id'])){
		$kl_id 			= $_COOKIE['klant']['klant_id'];
	}
 ?>
<div id="kd_details_kolom">
	<form name="kd_update" method="post" action="account.php?act=wijzig">
		<div class="kd_data">
			<div class="kd_data_formulier">
				<h3>De onderstaande gegevens zijn bij ons bekend</h3>
				<div class="kd_kolom sluit-links-5">
					<p>Naam</p>
					<div class="kd_row">
						<label for="voornaam">Voornaam <span></span></label>
						<input type="text" class="alleen_lezen" name="voornaam" id="voornaam" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['voornaam']; ?>" />
					</div>
					<div class="kd_row">
						<label for="achternaam">Achternaam <span></span></label>
						<input type="text" class="alleen_lezen" name="achternaam" readonly="readonly" id="achternaam" value="<?php  echo $_COOKIE['klant'][$kl_id]['achternaam']; ?>" />
					</div>
				</div>
				<div class="kd_kolom">
					<p>Adres</p>
					<div class="kd_row">
						<label for="straat">Straat <span></span></label>
						<input type="text" class="alleen_lezen" name="straat" id="straat" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['straat']; ?>" />
					</div>
					<div class="kd_row">
						<label for="straat_nummer">Nummer <span></span></label>
						<input type="text" class="alleen_lezen" name="straat_nummer" id="straat_nummer" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['straat_nummer']; ?>" />
					</div>
					<div class="kd_row">
						<label for="nummer_bus">Bus <span></span></label>
						<input type="text" class="alleen_lezen" name="nummer_bus" id="nummer_bus" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['nummer_bus']; ?>" />
					</div>
					<div class="kd_row">
						<label for="lokatie_id">Woonplaats <span></span></label>
						<select name="lokatie_id" id="lokatie_id" class="alleen_lezen" disabled="disabled">
							<?php 
							$html = '';
							foreach($lever_locatie_lijst as $value){
								$html .= '<option value="' . $value->id . '"';
							if ($value->id == $_COOKIE['klant'][$kl_id]['lokatie_id']){
								$html .= ' selected="selected"';
							}
								$html .= '>' . $value->name . '</option>';
							}
							echo $html;
							 ?>
						</select>
						<img class="enable_list" src="images/fugue/icons/ui-combo-box-edit.png" alt="Klik om andere plaats te selecteren"></img>
					</div>
				</div>
				<div class="kd_kolom">
					<p>Contactgegevens</p>
					<div class="kd_row">
						<label for="tel_vast">Vast nummer <span></span></label>
						<input type="text" name="tel_vast" id="tel_vast" class="alleen_lezen" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['tel_vast']; ?>" />
					</div>
					<div class="kd_row">
						<label for="tel_gsm">GSM nummer <span></span></label>
						<input type="text" name="tel_gsm" id="tel_gsm" class="alleen_lezen" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['tel_gsm']; ?>" />
					</div>
				</div>
				<div class="kd_kolom">
					<p>Login gegevens</p>
					<div class="kd_row">
						<label for="email">E-mail <span></span></label>
						<input type="text" name="email" id="email" class="alleen_lezen" readonly="readonly" value="<?php  echo $_COOKIE['klant'][$kl_id]['email']; ?>" />
					</div>
					<div class="kd_row">
						<label for="nieuw_wachtwoord">Wachtwoord</label>
						<input type="checkbox" name="nieuw_wachtwoord" id="nieuw_wachtwoord" value="ja" />
						<p class="info_box">Selecteer het vakje hierboven en we mailen u een nieuw wachtwoord</p>
					</div>
				</div>
				<div class="kd_kolom sluit-rechts-5">
					<p class="go_down">Promoties</p>
					<div class="kd_row">
						<label for="promotie">Mogen wij u van onze promoties op de hoogte stellen <span></span></label>
						<input type="checkbox" name="promotie" id="promotie" value="true" <?php 
						if($_COOKIE['klant'][$kl_id]['promotie'] == 1){
							echo 'checked="checked"';
						}
						 ?>/>
					</div>
				</div>
			</div>
			<div class="kd_knoppen">
				<div class="kd_knoppen_balk">
					<button type="submit" id="klant_wijzig">Wijzig gegevens</button>
				</div>
			</div>
			<?php 
			if (isset($_SESSION['fouten'])){
			 ?>
			<div class="kd_errors">
				<div class="kd_wijzig_errors">
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
			<?php 
			}
			 ?>
		</div>

	</form>
</div>