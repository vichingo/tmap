<div id="wrapper">
	<div id="header">
		{include file="navbar.tpl"}
		{include file="bouncerbar.tpl"}
		{include file="logo.tpl"}
	</div>
	<div id="contentwrapper">
		<div id="zoekkolom">
			<div id="zoekblok">
				<form action="{php} echo $_SERVER["PHP_SELF"];{/php}?lokatie=faq&act=zoeken" method="post">
					<input type="text" name="zoek_tekst" id="zoek_tekst" />
					<button type="submit">Zoeken</button>
				</form>
			</div>
		</div>
		<div id="faqkolom" >
		{php}
			//haal data uit de database

			$faqs = new faqs();
			$faqs->read();
			$faqs_lijst = $faqs->lijst;


			if($_POST['zoek_tekst'] != ''){

			/* SELECT * FROM articles
    		* WHERE MATCH (title,body)
    		* AGAINST ('database' IN NATURAL LANGUAGE MODE);
			* IN BOOLEAN MODE
			* IN NATURAL LANGUAGE MODE
			* IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION
			* WITH QUERY EXPANSION
			*/


			//aantal zoekvragen
			$zoekvragen = new tmap();
			$zoekvragen->full_query_string 	= "	SELECT id, vraag, antwoord, MATCH (vraag,antwoord) AGAINST
												('" . $_POST['zoek_tekst'] . "') AS score
												FROM faqs WHERE MATCH (vraag,antwoord) AGAINST
												('" . $_POST['zoek_tekst'] . "')";
			$zoekvragen->lijst		= $zoekvragen->lezen();
			$zoekvragen_lijst		= $zoekvragen->lijst;
			$aantal_resultaten		= $zoekvragen->aantalRijen;
			//echo $zoekvragen->r_Query;




		{/php}
			<div id="gevonden_vragen">
				<div id="controle_paneel">
					<div class="gezocht_naar">
						<p>U heeft gezocht naar: <span>{php}echo $_POST['zoek_tekst'];{/php}</span></p>
					</div>
					<div class="aantal_resultaten">
						<p>Aantal resultaten: <span>{php}echo $aantal_resultaten;{/php}</span></p>
					</div>
					<div class="alle_resultaten_tonen">
						<button type="button" onClick="location.href='index.php?lokatie=faq'">Alle vragen tonen</button>
					</div>
				</div>

				<ul>
				{php}
					foreach($zoekvragen_lijst as $lijst){
						$score = $lijst->score;
						$score *= 10.00;
						$score = number_format($score, 1, ',', '')
				{/php}
					<li>
						<div class="relevantie"><p>{php} echo $score;{/php} %</p></div>
						<div class="vraag"><p>{php} echo $lijst->vraag ;{/php}</p></div>
						<div class="antwoord"><p>{php} echo $lijst->antwoord ;{/php}</p></div>
					</li>
				{php}
					}
					$_POST['zoek_tekst'] = '';
				{/php}
				</ul>
			</div>
		{php}
			} else {
		{/php}
			<div id="alle_vragen">
				<h1>Veel gestelde vragen</h1>
				<ul>
				{php}
					foreach($faqs_lijst as $faq){
				{/php}
					<li>
						<div class="vraag_nr"><p># {php}echo $faq->volgorde + 1;{/php}</p></div>
						<div class="vraag"><p>{php}echo $faq->vraag;{/php}</p></div>
						<div class="antwoord"><p>{php}echo $faq->antwoord;{/php}</p></div>
					</li>
				{php}
				}
				{/php}				</ul>
			</div>
			{php}
			}
			{/php}
		</div>
	</div>
</div>