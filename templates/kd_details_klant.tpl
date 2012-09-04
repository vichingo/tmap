{php}

include 'includes/objecten.php';

if (isset($_COOKIE['klant']['klant_id'])){
		$kl_id 			= $_COOKIE['klant']['klant_id'];
	}
{/php}
<div id="kd_details_kolom">
	<form name="kd_update" method="post" action="account.php?act=wijzig">
		<div class="kd_data">
			<div class="kd_data_formulier">
				<h3>De onderstaande gegevens zijn bij ons bekend</h3>
				<div class="kd_kolom sluit-links-5">
					<p>Naam</p>
					<div class="kd_row">
						<label for="voornaam">Voornaam <span></span></label>
						<input type="text" class="alleen_lezen" name="voornaam" id="voornaam" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['voornaam'];{/php}" />
					</div>
					<div class="kd_row">
						<label for="achternaam">Achternaam <span></span></label>
						<input type="text" class="alleen_lezen" name="achternaam" readonly="readonly" id="achternaam" value="{php} echo $_COOKIE['klant'][$kl_id]['achternaam'];{/php}" />
					</div>
				</div>
				<div class="kd_kolom">
					<p>Adres</p>
					<div class="kd_row">
						<label for="straat">Straat <span></span></label>
						<input type="text" class="alleen_lezen" name="straat" id="straat" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['straat'];{/php}" />
					</div>
					<div class="kd_row">
						<label for="straat_nummer">Nummer <span></span></label>
						<input type="text" class="alleen_lezen" name="straat_nummer" id="straat_nummer" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['straat_nummer'];{/php}" />
					</div>
					<div class="kd_row">
						<label for="nummer_bus">Bus <span></span></label>
						<input type="text" class="alleen_lezen" name="nummer_bus" id="nummer_bus" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['nummer_bus'];{/php}" />
					</div>
					<div class="kd_row">
						<label for="lokatie_id">Woonplaats <span></span></label>
						<select name="lokatie_id" id="lokatie_id" class="alleen_lezen" disabled="disabled">
							{php}
							$html = '';
							foreach($lever_locatie_lijst as $value){
								$html .= '<option value="' . $value->id . '"';
							if ($value->id == $_COOKIE['klant'][$kl_id]['lokatie_id']){
								$html .= ' selected="selected"';
							}
								$html .= '>' . $value->name . '</option>';
							}
							echo $html;
							{/php}
						</select>
						<img class="enable_list" src="images/fugue/icons/ui-combo-box-edit.png" alt="Klik om andere plaats te selecteren"></img>
					</div>
				</div>
				<div class="kd_kolom">
					<p>Contactgegevens</p>
					<div class="kd_row">
						<label for="tel_vast">Vast nummer <span></span></label>
						<input type="text" name="tel_vast" id="tel_vast" class="alleen_lezen" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['tel_vast'];{/php}" />
					</div>
					<div class="kd_row">
						<label for="tel_gsm">GSM nummer <span></span></label>
						<input type="text" name="tel_gsm" id="tel_gsm" class="alleen_lezen" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['tel_gsm'];{/php}" />
					</div>
				</div>
				<div class="kd_kolom">
					<p>Login gegevens</p>
					<div class="kd_row">
						<label for="email">E-mail <span></span></label>
						<input type="text" name="email" id="email" class="alleen_lezen" readonly="readonly" value="{php} echo $_COOKIE['klant'][$kl_id]['email'];{/php}" />
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
						<input type="checkbox" name="promotie" id="promotie" value="true" {php}
						if($_COOKIE['klant'][$kl_id]['promotie'] == 1){
							echo 'checked="checked"';
						}
						{/php}/>
					</div>
				</div>
			</div>
			<div class="kd_knoppen">
				<div class="kd_knoppen_balk">
					<button type="submit" id="klant_wijzig">Wijzig gegevens</button>
				</div>
			</div>
			{php}
			if (isset($_SESSION['fouten'])){
			{/php}
			<div class="kd_errors">
				<div class="kd_wijzig_errors">
					<ul class="fouten_lijst">
				{foreach item=foutjes from=$fouten key=k}
					<li> Veld {$k} meldt:
						<ul class="foutjes">
						{foreach item=fout from=$foutjes}
							<li>{$fout}</li>
						{/foreach}
						</ul>
					</li>
				{/foreach}
				</ul>
				</div>
			</div>
			{php}
			}
			{/php}
		</div>

	</form>
</div>
