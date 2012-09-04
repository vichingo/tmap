<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
	</div>
	<div id="contentwrapper">
	{php}
	if (isset($_COOKIE['klant']['klant_id'])){
		$klant_id = $_COOKIE['klant']['klant_id'];
		if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
			{/php}
				<div class="maincontent">
			{php}
			} else {
			{/php}
				<div class="maincontent stretched">
			{php}
			}
		}
	{/php}

			<div class="intro">
				<h1>Welkom</h1>
				<h2>Welkom op onze website</h2>
				<p>Bekijk onze menukaart door deze hierboven in het menu te kiezen.</p>
				<p>Heeft u al een account bij ons, log dan in met uw e-mail adres en wachtwoord.</p>
				<p>Heeft u nog geen account bij ons, maar bent u voor een snelle afhandeling van uw bestelling, registreer u dan op voorhand, zodat u achteraf de gegevens niet hoeft in te vullen. </p>
			</div>
		</div>
	</div>
	{php}
	if (isset($_COOKIE['klant']['klant_id'])){
		$klant_id = $_COOKIE['klant']['klant_id'];
		if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
			{/php}
				{include file="welkom_klant.tpl"}
			{php}
			}
		}
	{/php}
</div>