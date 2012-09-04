<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
	</div>
		{include file="logo.tpl"}
		{include file="kd_details_klant.tpl"}
	<div id="contentwrapper">
		<div class="klantdatakolom">
			<div class="kd_filterbar">
{php}
$klant_id = $_COOKIE[klant][klant_id];

$klant_bestellingen = new collectie();
$klant_bestellingen->klantBestellingen($klant_id);
$klant_bestellingen_lijst	= $klant_bestellingen->lijst;


{/php}
			</div>
			<div id="kd_bestelling">
			<h3 class="kd_bestellingen_header">Uw bestellingen</h3>
				<div id="kd_bestel_lijst">
				<table>					<thead>
						<tr>
							<td class="kd_bestelling_nummer lijn_rechts">
								<img class="icon" src="images/fugue/icons/box-label.png" alt="Bestelling nummer"/>
								<p><span>Bestelling nummer</span></p>
							</td>
							<td class="kd_bestelling_besteltijd lijn_rechts">
								<img class="icon" src="images/fugue/icons/_overlay/store--arrow-in.png" alt="Besteltijd"/>
								<p>Besteltijd</p>
							</td>
							<td class="kd_bestelling_leverwijze lijn_rechts">
								<img class="icon" src="images/fugue/icons/door-open.png" alt="Bezorgen"/>
								<p>Leverwijze</p>
							</td>
							<td class="kd_bestelling_levertijd lijn_rechts">
								<img class="icon" src="images/fugue/icons/_overlay/store--arrow.png" alt="Levertijd"/>
								<p>Levertijd</p>
							</td>
							<td class="kd_bestelling_prijs">
								<img class="icon" src="images/fugue/icons/money-coin.png" alt="Bezorgen"/>
								<p>Totaal (+ leveringskosten)</p>
							</td>
						</tr>

					</thead>					<tfoot>
						<tr>
							<td></td>
						</tr>
					</tfoot>					<tbody>
					{php}
foreach($klant_bestellingen_lijst as $bestelling)
{
					$besteltijd_datum 	= date('d-m-Y', $bestelling->besteltijd);
					$besteltijd_uur 	= date('H:i', 	$bestelling->besteltijd);
					$levertijd_datum 	= date('d-m-Y', $bestelling->levertijd);
					$levertijd_uur 		= date('H:i', 	$bestelling->levertijd);

					$leverwijze	= new leverwijze();
					$leverwijze->readLine($bestelling->leverwijze_id);
					$leverwijze_lijst = $leverwijze->lijst;

					$leverwijze_naam = $leverwijze_lijst[0]->naam;

					{/php}
						<tr>
							<td><p>{php}echo $bestelling->bestelling_nummer{/php}</p></td>							<td><p><span>{php}echo $besteltijd_datum{/php}</span> om <span>{php}echo $besteltijd_uur{/php}</span></p></td>
							<td><p>{php}echo $leverwijze_naam{/php}</p></td>
							<td><p><span>{php}echo $levertijd_datum{/php}</span> om <span>{php}echo $levertijd_uur{/php}</span></p></td>							<td><p>&#8364; {php}echo $bestelling->totaal_prijs{/php}</p></td>						</tr>
						{php}
}
						{/php}
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>