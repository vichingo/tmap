<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
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
		{php}

			$gerecht = new gerecht();
			$gerecht->read();
			$gerecht_lijst = $gerecht->lijst;
      $prev_pin = '';

			foreach($gerecht_lijst as $gerecht){

						$bpg 				= new tmap(); //bestanddelen per gerecht
						$bpg->table_arr		= array('gerecht_bestanddeel g', 'bestanddeel b');
						$bpg->column_arr	= array('b.naam', 'b.prijs');
						$bpg->where_arr		= array('g.bestanddeel_id' => 'b.id', 'g.gerecht_id' => $gerecht->id);
						$bpg->lijst			= $bpg->lezen();
						$bpg_lijst			= $bpg->lijst;

						$prijs_toevoeging	= 0.00;
						foreach($bpg_lijst as $item){
							$prijs_toevoeging += $item->prijs;
						}
						$dirty_basisprijs_totaal = $gerecht->basisprijs + $prijs_toevoeging;
						$basisprijs_totaal = number_format($dirty_basisprijs_totaal, 2, '.', '');


				{/php}
		<div class="lijn_data" id="gerecht_{php}echo $gerecht->id;{/php}">
			<form name="verzamelen" method="post" action="mandje.php">
				<div class="product_data">
					<div class="product_text">
						<input type="hidden" id="lijn_id" name="lijn_id" value="{php}
						$pin = tardis::maakpin(8);
						if ($prev_pin != '')
						{
						  $prev_pin = $pin;
						}

						if ($pin == $prev_pin)
						{
						  $pin = tardis::maakpin(8);
						} else {
						  $prev_pin = $pin;
						}
            echo $pin;
						{/php}"/>
						<input type="hidden" id="gerecht_id_{php}echo $gerecht->id;{/php}" name="gerecht_id" value="{php}echo $gerecht->id;{/php}"/>
						<input type="hidden" id="gerecht_naam_{php}echo $gerecht->id;{/php}" name="gerecht_naam" value="{php}echo $gerecht->naam;{/php}"/>
						<input type="hidden" id="gerecht_prijs_{php}echo $gerecht->id;{/php}" name="gerecht_prijs" value="{php}echo $basisprijs_totaal;{/php}"/>
						<p>Gerecht:</p>
						<p class="gerecht_naam">
						{php}echo $gerecht->naam;{/php}
						</p>
						<p>Prijs:</p>
						<p class="gerecht_prijs">
						&#8364; <span id="gerecht_basisprijs_{php}echo $gerecht->id;{/php}">{php}echo $basisprijs_totaal;{/php}</span><span id="matrix_prijs_{php}echo $gerecht->id;{/php}"></span>
						</p>
					</div>
				</div>
				<div class="product_options">
					<ul class="optionbar">
						{foreach item=optie from=$gerecht_optie}
						<!-- start optie section -->
						<li>
							<label for="optie_{$optie->id}">{$optie->naam}</label>
							<select class="product_optie" id="optie_{$optie->id}" name="optie[{$optie->naam}]">
								{foreach item=variatie from=$optie_variatie}
								    {if $optie->id == $variatie->optie_id}
								    	<option id="{$variatie->id}" value="{$variatie->id}_{$variatie->matrix}">{$variatie->variatie}</option>
								    {/if}
								{/foreach}
							</select>
						</li>
						<!-- end optie section -->
						{/foreach}
						<li>
							<button class="verzamelKnop" type="submit" id="verzamelen" name="act" value="verzamelen">Voeg toe aan mandje</button>
						</li>
					</ul>
				</div>
			</form>
</div>
				{php}
			}
		{/php}
	</div>
	<div id="orderkolom">
		<form name="bestellen" method="post" action="index.php?lokatie=bestellen">
		<div id="mandje_header">
			<img class="bestellen_image" src="images/design/buy-icon_32.png" alt="Uw bestelling"/>
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
		{if $levertijd_is_vroeger}
		<div id="levertijd_verkeerd">
			<p>De reservatie tijd is vroeger dan de levertijd!!</p>
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
			<button type="button" name="reservatie_knop" id="reservatie_knop">Reserveren</button>
			<div id="reservatie_input">
				<label for="reservatie_datum_tijd">Ik wil reserveren op:</label>
				<input type="text" name="reservatie_datum_tijd" id="reservatie_datum_tijd" value="{php} echo $_POST['reservatie_datum_tijd'];{/php}"/>
			</div>
		</div>
		<div id="verwerk_bestelling_knop">
			<button class="bestelKnop" type="submit" name="bestelling_verwerken">Verwerk bestelling</button>
		</div>
		</form>
	</div>

</div>