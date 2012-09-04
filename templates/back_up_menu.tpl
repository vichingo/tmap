<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
	</div>
	<div id="contentwrapper">
		<div class="contentkolom">
			<div id="gerechten">
				<div id="gerechten_lijst">
					{include file="menukaart.tpl"}
				</div>
			</div>
		</div>
	</div>
	<div id="product_detailkolom">
		<form name="verzamelen" method="post" action="mandje.php">
		{include file="gerecht_details.tpl"}
		</form>
	</div>
	<div id="orderkolom">
		<form name="bestellen" method="post" action="index.php?lokatie=bestellen">
		<div id="mandje_header">
			<img class="bestellen_image" src="images/fugue/icons/shopping-basket.png" alt="Uw bestelling"/>
			<h3>Uw Bestelling</h3>
		</div>
		<div id="mandjelijnen">
{foreach item=mandjelijn from=$mandje name=mandje}
		<div class="mandjelijn">
			<input type="hidden" name="mandjelijn_id" value="{$mandjelijn.lijn_id}"/>
			<div class="mandjelijn_aantal">{$mandjelijn.aantal}x</div>
			<div class="mandjelijn_naam">{$mandjelijn.gerecht_naam}</div>
			<div class="mandjeUpdateBlock">
				<div class="mandjelijnPlusMin">
					{if $mandjelijn.aantal > 1}
				    <a href="mandje.php?act=verminderen&lijnid={$mandjelijn.lijn_id}">
						<img class="mandjeIcon" src="images/fugue/icons/minus-button.png" alt="verwijder 1 van de {$mandjelijn.aantal} {$mandjelijn.gerecht_naam}'s uit bestellijst"/>
					</a>
					{/if}
				    <a href="mandje.php?act=vermeerderen&lijnid={$mandjelijn.lijn_id}">
						<img class="mandjeIcon" src="images/fugue/icons/plus-button.png" alt="vermeerder de {$mandjelijn.gerecht_naam} met 1"/>
					</a>
					<a href="mandje.php?act=verwijderen&lijnid={$mandjelijn.lijn_id}">
						<img class="mandjeIcon" src="images/fugue/icons-shadowless/_overlay/shopping-basket--minus.png" alt="verwijder {$mandjelijn.gerecht_naam} uit bestellijst"/>
					</a>
				</div>
			</div>
			<div class="mandjelijn_prijs">&#8364; {$mandjelijn.lijn_totaal_prijs}</div>

		</div>
{/foreach}
		</div>
		{if $aantalLijnen > 0}
		<div id="mandje_totalen">
		<ul>			<li><b>Aantal Pizza's: </b>{$aantalGerechten}</li>
			<li><b>Bezorgkosten: </b>&#8364; {$bezorg_kosten}</li>
			<li><b>Gratis bezorging vanaf: </b>&#8364; {$leveringkosten_minimaal}</li>
			<li><b>Totaal bestelling: </b>&#8364; {$totaalBedragzv} {if $totaalBedragzv < $leveringkosten_minimaal} + &#8364; {$bezorg_kosten}  = &#8364; {$totaalBedrag}{/if}</li>		</ul>
		</div>
		{else}
		<div id="leeg_mandje">
			U heeft nog niets besteld.
		</div>
		{/if}
		<div id="leverwijze_keuze">
			<label for="leverwijze_id">Leverwijze</label>
			<select id="leverwijze_id" name="leverwijze_id">
				{foreach item=leverwijze from=$leverwijze_lijst}
				    	<option value="{$leverwijze->id}">{$leverwijze->naam}</option>
				{/foreach}
			</select>
		</div>
		<div id="reservatie_keuze_box">
			<label for="reservatie_keuze">Wilt u deze bestelling reserveren</label>
			<input type="checkbox" name="reservatie" id="reservatie"/>
		</div>
		<div id="verwerk_bestelling_knop">
			<button class="bestelKnop" type="submit" name="bestelling_verwerken">Verwerk bestelling</button>
		</div>
		</form>
	</div>

</div>