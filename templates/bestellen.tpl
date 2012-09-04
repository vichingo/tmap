<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
	</div>
	<div id="contentwrapper">
		<div class="contentkolom full">
			<div id="bestelling">
			{if $aantalLijnen > 0}
				<div id="bestel_lijst">
				<table>					<thead>
						<tr>
							<td><p>Aantal</p></td>							<td><p>Naam</p></td>{foreach item=optie from=$gerecht_optie}
							<td><p>{$optie->naam}</p></td>
{/foreach}							<td><p>Prijs</p></td>
							<td><p>Wijzigen</p></td>						</tr>
					</thead>					<tfoot>
						<tr>							<td colspan = "{$aantal_opties+1}"></td>							<td><p>Totaal:</p></td>							<td><p>&#8364; {$totaalBedragzv} {if $leverwijze_id == 2}{if $totaalBedragzv < $leveringkosten_minimaal} + &#8364; {$bezorg_kosten}  = &#8364; {$totaalBedrag}{/if}{/if}</p></td>							<td></td>						</tr>
					</tfoot>					<tbody>
					{foreach item=mandjelijn from=$mandje name=mandje}
						<tr>
							<td><p>{$mandjelijn.aantal}</p></td>							<td><p>{$mandjelijn.gerecht_naam}</p></td>
{foreach item=m_optie from=$mandjelijn.optie key=k}
	{foreach item=g_optie from=$gerecht_optie}
		{if $g_optie->naam == $k}
			{foreach item=optie_v from=$optie_variatie}
				{if $optie_v->optie_id == $g_optie->id}
					{if $optie_v->id == $m_optie}
									<td><p>
										{$optie_v->variatie}
									</p></td>
					{/if}
				{/if}
			{/foreach}
		{/if}
	{/foreach}
{/foreach}							<td><p>&#8364; {$mandjelijn.lijn_totaal_prijs}</p></td>
							<td>
								<div class="bestellijnPlusMin">
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
							</td>						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
			<div id="bestel_handelingen">
				<div id="levertijd">
				{if $reservatie}
					<p>Het {$leverwijze_naam} van de bestelling zal op {$reservatiedatum} om {$reservatietijd} gebeuren.</p>
				{else}
				 	<p>{$leverwijze_naam|capitalize}: &#177 40 minuten na het versturen van de bestelling.</p>
				{/if}
				</div>
	{php}
		if($_COOKIE[klant][klant_id]){
			$klant_id = $_COOKIE[klant][klant_id];
			if($_COOKIE[klant][$klant_id][loggedin] == yes){
				if($_COOKIE['klant'][$klant_id]['geblokkeerd'] == 0){
				{/php}
				<div id="bestel_knoppen">
					<div id="annuleren">
						<button type="button" onClick="location.href='mandje.php?act=mandjelegen'">Bestelling annuleren</button>
					</div>
					<div id="voltooien">
						<button type="button" onClick="location.href='index.php?lokatie=leveren'">Bestelling versturen</button>
					</div>
					<div id="wijzigen">
						<button type="button" onClick="location.href='index.php?lokatie=menu'">Bestelling wijzigen</button>
					</div>
				</div>
				{php}
				} else {
				{/php}
				<div id="aanmelden">
					<p>Wegens een nog openstaande rekening kunt u helaas niets bestellen.
					<br />Neem zo snel mogelijk contact met ons op om dit euvel te verhelpen.</p>
				</div>
				{php}
				}
			} else {
				{/php}
				<div id="aanmelden">
					<p>Om de bestelling te kunnen verder zetten wordt u verzocht uzelf aan te melden.</p>
				</div>
				{php}
			}
		} else {
	{/php}
		<div id="aanmelden">
			<p>Om de bestelling te kunnen verder zetten wordt u verzocht uzelf aan te melden of te registreren.</p>
		</div>
	{php}
	}
	{/php}
				</div>
{else}
				<div class="lege_bestelling">
					<p>Inhoud van mandje is leeg</p>
				</div>
{/if}
			</div>

	</div>
	</div>
</div>