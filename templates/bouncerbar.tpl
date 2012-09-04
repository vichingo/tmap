<div id="bouncerbar">
	<ul>
	{php}
		if($_COOKIE['klant']['klant_id']){
			$klant_id = $_COOKIE['klant']['klant_id'];
			if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
				{/php}
					<li>
						<a href="account.php?act=logout">
							Afmelden
						</a>
					</li>
					<li> | </li>
					<li>
						<a href="index.php?lokatie=klantdata">
							Uw gegevens
						</a>
					</li>
				{php}
			} else {
	{/php}
		<li>
			<a href="index.php?lokatie=registreren">
				Registreren
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=inloggen">
				Aanmelden
			</a>
		</li>
	{php}
		}
	} else {
	{/php}
		<li>
			<a href="index.php?lokatie=registreren">
				Registreren
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=inloggen">
				Aanmelden
			</a>
		</li>
	{php}
	}
	{/php}

		<li> | </li>
		<li>
			<a href="admin/" target="_blank">
				Admin
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=bestellen">
				Bestelling
			</a>
				{if $aantalLijnen > 0}
					<img class="alertIcon" src="images/fugue/icons/_overlay/shopping-basket--exclamation.png" alt="De bestelling bevat {$aantalLijnen} gerechten"/>
				{/if}
		</li>
	</ul>
</div>