{php}

	$kl_id 			= $_COOKIE['klant']['klant_id'];

	/*
	 * Laaste bestelling van de klant
	 *
	 * Deze vragen we op om op de intro pagina van de klant de laatste bestelling te tonen.
	 *
	 */
 	if ($_COOKIE['klant'][$kl_id]){
		$naam	= $_COOKIE['klant'][$kl_id]['voornaam'] . " " . $_COOKIE['klant'][$kl_id]['achternaam'];
		$email 	= $_COOKIE['klant'][$kl_id]['username'];
	} else {
		$naam	= '';
		$email	= '';
	}


{/php}

<div class="gb_berichtkolom">
	<h1>Welkom,
	{php}
	$html = '';
	if ($_COOKIE['klant'][$kl_id]){
		$html .= $_COOKIE['klant'][$kl_id]['voornaam'] . " " . $_COOKIE['klant'][$kl_id]['achternaam']. "\n";
		$html .= "</h1>\n";
		$html .=  "<p>Laat hieronder een berichtje achter.<br /> We hebben alvast je naam en e-mail ingevuld. <br />Wil je toch een andere naam of e-mail invullen klik dan gewoon op de tekst en je kunt hem wijzigen</p>";
	} else {
		$html .=  "Bezoeker";
		$html .=  "</h1>\n";
		$html .=  "<p>Laat hieronder een berichtje achter.<br /> Omdat we veiligheid hoog in het vaandel hebben, wordt uw IP bij het bericht opgeslagen.</p>";
	}
	echo $html;
	{/php}
	<form action="gastenboek.php?act=toevoegen" method="post">
		<div class="gb_formulier">
			<label for="gb_naam">Naam <span></span></label>
			<input type="text" name="gb_naam" id="gb_naam" {php}if($_COOKIE[klant][$kl_id][loggedin] == 'yes') echo ' class="alleen_lezen" readonly="readonly"';{/php} value="{php}echo $naam;{/php}"/>
			<label for="gb_email">E-mail adres <span></span></label>
			<input type="text" name="gb_email" id="gb_email" {php}if($_COOKIE[klant][$kl_id][loggedin] == 'yes') echo ' class="alleen_lezen" readonly="readonly"';{/php} value="{php}echo $email;{/php}"/>
			<label for="gb_bericht">Bericht</label>
			<textarea name="gb_bericht" id="gb_bericht" cols="30" rows="6"></textarea>
			<div class="gb_karakters">
				<p class="karakters_toegestaan">Aantal toegestane karakters: <span>-</span></p>				<p class="karakters_tegoed">U mag nog <span>-</span> karakters invoegen</p>
				<p class="karakters_erover"></p>
			</div>
			<div class="gb_knoppen">
				<button type="submit">Voeg bericht toe</button>
			</div>
		</div>
	</form>
</div>