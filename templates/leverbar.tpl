<span>
	{foreach item=leverin from=$leveren_in name=leverplaats}
		{if $smarty.foreach.leverplaats.first}
			{$leverin->name}
		{else}
			{if $smarty.foreach.leverplaats.last}
				en {$leverin->name}
			{else}
			, {$leverin->name}
			{/if}
		{/if}
	{/foreach}
</span>