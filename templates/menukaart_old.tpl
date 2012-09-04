<h1>Menukaart</h1>
<table>
	<tbody>
		<!-- start menu section -->
		{foreach item=menu from=$menus}
		<tr>
			<td>
				<h2 class="menu_header">{$menu->naam}</h2><h4>(Klik op een rij om de opties te tonen)</h4>
			</td>
		</tr>
		<!-- start dishes section-->
		{foreach item=gerecht from=$gerechten}
		{if $menu->id == $gerecht->menu_id}
		<tr class="gerecht_rij">
			<td class="gerecht_lijn" id="rij_{$gerecht->id}">
				<img src="images/content/{$gerecht->image}" alt="{$gerecht->naam}"/>
				<div class="gerecht_data">
					<p class="gerecht_code">
						{$gerecht->code}
					</p>
					<p class="gerecht_naam">
						{$gerecht->naam}
					</p>
					<p class="gerecht_omschrijving">
						{$gerecht->omschrijving}
					</p>
					<p class="gerecht_bestanddelen">(
					{foreach item=bestanddeel from=$gerecht_bestanddelen}
					{if $gerecht->id == $bestanddeel->gerechtId}
						{$bestanddeel->bestanddeelNaam}
					{/if}
					{/foreach}
{*

{php}

	global $gerecht_bestanddeel_rijen;

	echo '<pre>';
		var_dump($gerecht_bestanddeel_lijst);
	echo '</pre>';


{/php}*}

						)
					</p>
					<p class="gerecht_basisprijs">
						&#8364; <span class="gerecht_prijs">{$gerecht->basisprijs}</span>
					</p>
				</div>
			</td>
			<td class="hidden">
				<input type="radio" class="gerecht_keuze" name="gerecht_id[]" value="{$gerecht->id}" />
			</td>
		</tr>
		{/if}
		{/foreach}
		<!-- end dishes section-->
		{/foreach}
		<!-- end menu section -->
	</tbody>
</table>