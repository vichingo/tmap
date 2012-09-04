<div class="lijn_data" id="gerecht_{php}echo $gerecht->id;{/php}">
	<form name="verzamelen" method="post" action="mandje.php">
		<div class="product_data">
			<div class="product_text">
				<input type="hidden" id="lijn_id" name="lijn_id" value="{php}
				 echo tardis::maakpin(8);
				{/php}"/>
				<input type="hidden" id="gerecht_id_{php}echo $gerecht->id;{/php}" name="gerecht_id" value="{php}echo $gerecht->id;{/php}"/>
				<input type="hidden" id="gerecht_naam_{php}echo $gerecht->id;{/php}" name="gerecht_naam" value="{php}echo $gerecht->naam;{/php}"/>
				<input type="hidden" id="gerecht_prijs_{php}echo $gerecht->id;{/php}" name="gerecht_prijs" value="{php}echo $basisprijs_totaal;{/php}"/>
				<p>Gerecht:</p>
				<p class="gerecht_naam">
				{php}echo $gerecht->code;{/php} {php}echo $gerecht->naam;{/php}
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