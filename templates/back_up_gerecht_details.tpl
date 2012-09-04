<div id="product_data">
	<div id="product_text">
		<input type="hidden" id="lijn_id" name="lijn_id" value=""/>
		<input type="hidden" id="gerecht_id" name="gerecht_id" value=""/>
		<input type="hidden" id="gerecht_naam" name="gerecht_naam" value=""/>
		<input type="hidden" id="gerecht_prijs" name="gerecht_prijs" value=""/>
		<p>Gerecht:</p>
		<p id="v_gerecht_naam">
		</p>
		<p>Prijs:</p>
		<p id="v_gerecht_prijs">
		&#8364; <span id="v_gerecht_basisprijs"></span><span id="matrix_prijs"></span>
		</p>
	</div>
</div>
<div id="product_options">
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