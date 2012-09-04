<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
	</div>
	<div id="contentwrapper">
		<div class="gb_lijstkolom">

		{php}

		//haal berichten op

		$berichten	= new gastenboek();
		$berichten->read('ASC');
		$berichten_lijst = $berichten->lijst;

		foreach($berichten_lijst as $nummer=>$bericht){
			$nummer++;
			$tijd	= $bericht->post_tijd;
			$dag	= strftime("%d"		, $tijd);
			$maand 	= strftime("%m"		, $tijd);
			$jaar 	= strftime("%y"		, $tijd);
			$uur 	= strftime("%H:%M"	, $tijd);
		{/php}
		<!-- begin bericht -->
		<div class="gb_bericht">
				<div class="gb_bericht-datum">
					<div class="gb_bericht-dag"><p>{php} echo $dag;{/php}</p></div>
					<div class="gb_bericht-maand"><p>{php} echo $maand;{/php}</p></div>
					<div class="gb_bericht-jaar"><p>{php} echo $jaar;{/php}</p></div>
					<div class="gb_bericht-tijd"><p>{php} echo $uur;{/php}</p></div>
				</div>
				<div class="gb_bericht-content">
					<div class="gb_bericht-naam"><p>{php} echo $bericht->naam;{/php}</p></div>
					<div class="gb_bericht-email"><p>{php} echo $bericht->email;{/php}</p></div>
					<div class="gb_bericht-krabbel"><p>{php} echo $bericht->bericht;{/php}</p></div>
				</div>
				<div class="gb_bericht-nummer"><p>#{php} echo $nummer;{/php}</p></div>
			</div>
		<!-- einde bericht -->
		{php}

		}
		{/php}
		</div>
	</div>
	{include file="gastenboek_bericht.tpl"}
</div>