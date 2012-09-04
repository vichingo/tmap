{php}
	$_POST = $_SESSION['registreer_post'];

{/php}
<form name="registreer" method="post" action="account.php?act=registreer">
	<input type="hidden" name="aanmaakdatum" value="{php} echo time();{/php}"/>
	<div id="registreerkolom">
		<h1>Registreren</h1>
		<div class="row">
			<div class="row_header">Naam</div>
			<div class="row_left">
				<label for="voornaam">Voornaam</label>
				<input type="text" name="voornaam" id="voornaam" value="{php} echo $_SESSION[registreer_post]['voornaam'];{/php}" />
			</div>
			<div class="row_right">
				<label for="achternaam">Achternaam</label>
				<input type="text" name="achternaam" id="achternaam" value="{php} echo $_SESSION[registreer_post]['achternaam'];{/php}" />
			</div>
		</div>
		<div class="row">
			<div class="row_header">Adres</div>
			<div class="row_left">
				<label for="straat">Straat</label>
				<input type="text" name="straat" id="straat" value="{php} echo $_SESSION[registreer_post]['straat'];{/php}" />
			</div>
			<div class="row_right">
				<label for="straat_nummer">Nummer</label>
				<input type="text" name="straat_nummer" id="straat_nummer" value="{php} echo $_SESSION[registreer_post]['straat_nummer'];{/php}" />
			</div>
			<div class="row_right">
				<label for="nummer_bus">Bus</label>
				<input type="text" name="nummer_bus" id="nummer_bus" value="{php} echo $_SESSION[registreer_post]['nummer_bus'];{/php}" />
			</div>
		</div>
		<div class="row">
			<div class="row_left">
				<label for="lokatie_id">Woonplaats</label>
				<select name="lokatie_id" id="lokatie_id">
					<option value="0" selected="selected">Maak keuze</option>
					{foreach item=leverplaats from=$leveren_in}
					<option value="{$leverplaats->id}">{$leverplaats->name}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="row">
			<div class="row_header">Contactgegevens</div>
			<div class="row_left">
				<label for="tel_vast">Vast nummer</label>
				<input type="text" name="tel_vast" id="tel_vast" value="{php} echo $_SESSION[registreer_post]['tel_vast'];{/php}" />
			</div>
			<div class="row_right">
				<label for="tel_gsm">GSM nummer</label>
				<input type="text" name="tel_gsm" id="tel_gsm" value="{php} echo $_SESSION[registreer_post]['tel_gsm'];{/php}" />
			</div>
		</div>
		<div class="row">
			<div class="row_header">Login gegevens</div>
			<div class="row_left">
				<label for="email">E-mail</label>
				<input type="text" name="email" id="email" value="{php} echo $_SESSION[registreer_post]['email'];{/php}" />
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
		<div class="row">
			<div class="row_left">
				<button type="submit" name="klant_registreer" id="klant_registreer">Registreer</button>
			</div>
		</div>
	</div>
</form>