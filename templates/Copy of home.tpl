<div class="container_16">
	{include file="navbar.tpl"}
	<div class="clear">
	</div>
	<div class="grid_16" id="header">
		<div class="grid_9 alpha">
			<h1 class="site_header">Welkom</h1>
		</div>
		<div class="grid_7 omega">
			<div class="box">
				<div id="login-forms">
					<form id="f_login" name="f_login" method="post" action="">
						<h1>Aanmelden</h1>
						<p class="notice">
							Meld u aan om een pizza te bestellen
						</p>
						<li>
							<label>
								Naam:
								<span class="klein">Vul uw email in</span>
							</label>
							<input type="text" name="email" id="email"/>
						</li>
						
						<li>
							<label>
								Wachtwoord:
							</label>
							<input type="text" name="wachtwoord" id="wachtwoord"/>
						</li>
						<li>
							<button class="login button" type="submit" value="aanmelden">aanmelden</button>
							<div class="spacer"></div>
						</li>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div class="grid_16" id="mainContent">
		<div class="grid_9 alpha" id="content">
			<div class="menukaart">
				<div class="menusoort">
{php}
$menu = new menu();
$menu->read();
$menu_lijst = $menu->lijst;

$gerecht = new gerecht();
$gerecht->read();
$gerecht_lijst = $gerecht->lijst;

$gerecht_bestanddeel = new gerecht_bestanddeel();
$gerecht_bestanddeel->read();
$gerecht_bestanddeel_lijst = $gerecht_bestanddeel->lijst;
//echo $gerecht_bestanddeel->makeJson();


{/php}
					<h1>Pizza's</h1>
					<form id="gerecht">
					<div class="gerecht">
						<div class="gerecht_image">
							<img src="images/content/Pizza_Prosciutto.jpg" alt="Pizza Porscuitto" width="200px"/>
						</div>
						<div class="gerecht_nummer">
							1001
						</div>
						<div class="gerecht_naam">
							<h3>Pizza Proscuitto</h3>
						</div>
						<div class="gerecht_bestanddelen">
							<p>(Tomatensaus, Kaas, Ham)</p>
						</div>
						<div class="basis_prijs">
							<p>&#8364; 9,00</p>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="grid_3" id="details">
			<h3>Bestelling verfijnen</h3>
			<div class="optielijst">
				<!--voor elke optie-->
				<label for="optielijst_1">Formaat</label>
				<select name="optielijst_1" id="optielijst_1">
					<option value="0">Maak een keuze</option>
					<option value="1">Normaal</option>
					<option value="1.1">Medium</option>
					<option value="1.2">Groot</option>
				</select>
				<label for="optielijst_2">Bodem</label>
				<select name="optielijst_1" id="optielijst_1">
					<option value="0">Maak een keuze</option>
					<option value="1">Napolitaans</option>
					<option value="1.1">Panpizza</option>
					<option value="1.2">Stuffed Crust</option>
				</select>
			</div>
			<div class="plusmin">
				<div class="minlijst">
					<label for="min_bestanddeel">Zonder (meerdere keuzes mogelijk)</label>
					<select name="min_bestanddeel" id="min_bestanddeel" multiple="multiple">
						<option value="1">Tomatensaus</option>
						<option value="2">Kaas</option>
						<option value="3">Ham</option>
					</select>
				</div>
				<div class="pluslijst">
					<label for="plus_bestanddeel">Met (meerdere keuzes mogelijk)</label>
					<select name="plus_bestanddeel" id="plus_bestanddeel" multiple="multiple" size="4">
						<option value="1">Tomatensaus</option>
						<option value="2">Kaas</option>
						<option value="3">Ham</option>
						<option value="4">Salami</option>
						<option value="5">Tonijn</option>
						<option value="6">Ananas</option>
						<option value="7">Prei</option>
						<option value="8">Brocolli</option>
						<option value="9">Champignons</option>
					</select>
				</div>
			</div>
			<div>
				<button type="button" name="add_shoppingcart">Plaats in winkelmandje</button>
			</div>
		</div>
		<div class="grid_4 omega" id="bestelling">
			<h3>Uw Bestelling</h3>
			<div class="bestel_lijn" id="bestellijn_id_1">
				<div class="aantal">1x</div>
				<div class="gerecht_naam">Pizza Proscuitto</div>
				<div class="totaal_prijs">&#8364; 12,00</div>
				<div class="lijn_verwijderen" id="lijn_id_1">
					<img src="images/fugue/icons/_overlay/shopping-basket--minus.png" alt="verwijderen"/>
				</div>
				<div class="extra_info hidden">
					<ul>
						<li>
							<span>Formaat:</span>
							<span>Groot</span>
						</li>
						<li>
							<span>Bodem:</span>
							<span>Panpizza</span>
						</li>
						<li>
							<span>-Ham</span>
						</li>
						<li>
							<span>+Tonijn</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="bestel_lijn" id="bestellijn_id_2">
				<div class="aantal">1x</div>
				<div class="gerecht_naam">Pizza Proscuitto</div>
				<div class="totaal_prijs">&#8364; 12,00</div>
				<div class="lijn_verwijderen" id="lijn_id_2">
					<img src="images/fugue/icons/_overlay/shopping-basket--minus.png" alt="verwijderen"/>
				</div>
				<div class="extra_info hidden">
					<ul>
						<li>
							<span>Formaat:</span>
							<span>Normaal</span>
						</li>
						<li>
							<span>Bodem:</span>
							<span>Napolitaans</span>
						</li>
						<li>
							<span>+Tonijn</span>
							<span>+Champignons</span>
						</li>
					</ul>
				</div>
			</div>
			<div>
				<button type="button" name="bestelling">Plaats bestelling</button>
			</div>
		</div>
	</div>
</div>