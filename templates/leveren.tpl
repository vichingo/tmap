<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
	</div>
	<div id="contentwrapper">
		<div class="contentkolom full">
			<div id="bestelling_overzicht">
				<!-- Toon dit als gebruiker toch via de adresbalk probeert te leveren -->
				<!-- Leveren mag -->
				{php}


					if (isset($_COOKIE['klant']['klantid'])){
						$kl_id 			= $_COOKIE['klant']['klant_id'];
							if(isset($_COOKIE['klant'][$kl_id]['geblokkeerd']) && $_COOKIE['klant'][$kl_id]['geblokkeerd'] == 0){

				{/php}
				<div>
					<h1>Gegevens bestelling</h1>
					<ul>						<li>							<div class="ld_links">Bestel nummer:</div>							<div class="ld_rechts">{$bestelling_nummer}</div>						</li>						<li>							<div class="ld_links">Naam:</div>							<div class="ld_rechts">
							{php}
								$kl_id 			= $_COOKIE[klant][klant_id];
								echo " " . $_COOKIE[klant][$kl_id][voornaam] . " " . $_COOKIE[klant][$kl_id][achternaam];
							{/php}
							</div>						</li>						<li>							<div class="ld_links">Adres:</div>							<div class="ld_rechts">{php}
							if (isset($_COOKIE[klant][$kl_id][adres])){
								echo $_COOKIE[klant][$kl_id][adres];
							}
							{/php}</div>						</li>						<li>							<div class="ld_links">Besteltijd:</div>							<div class="ld_rechts">{$besteltijd}</div>						</li>						<li>							<div class="ld_links">Levertijd:</div>							<div class="ld_rechts">{$levertijd}</div>						</li>						<li>							<div class="ld_links">Aantal Pizza's:</div>							<div class="ld_rechts">{$aantalGerechten}</div>						</li>					</ul>
				</div>
				<div id="bestel_knoppen">
					<div id="verder">
						<button type="button" onClick="location.href='index.php?lokatie=home'">Ga verder</button>
					</div>
				</div>
				{php}
							} else {
								{/php}
				<div>
					<h1>Helaas,</h1>
					<h2>Wegens een nog openstaande rekening kunt u helaas niets bestellen.
					<br />Neem zo snel mogelijk contact met ons op om dit euvel te verhelpen.</h2>
				</div>
								{php}
							}
						}
				{/php}
				<!-- einde leveren mag -->
			</div>
		</div>
	</div>
</div>