<?php /* Smarty version 2.6.26, created on 2010-08-12 13:07:41
         compiled from faq.tpl */ ?>
<div id="wrapper">
	<div id="header">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "navbar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bouncerbar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "logo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<div id="contentwrapper">
		<div id="zoekkolom">
			<div id="zoekblok">
				<form action="<?php  echo $_SERVER["PHP_SELF"]; ?>?lokatie=faq&act=zoeken" method="post">
					<input type="text" name="zoek_tekst" id="zoek_tekst" />
					<button type="submit">Zoeken</button>
				</form>
			</div>
		</div>
		<div id="faqkolom" >
		<?php 
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




		 ?>
			<div id="gevonden_vragen">
				<div id="controle_paneel">
					<div class="gezocht_naar">
						<p>U heeft gezocht naar: <span><?php echo $_POST['zoek_tekst']; ?></span></p>
					</div>
					<div class="aantal_resultaten">
						<p>Aantal resultaten: <span><?php echo $aantal_resultaten; ?></span></p>
					</div>
					<div class="alle_resultaten_tonen">
						<button type="button" onClick="location.href='index.php?lokatie=faq'">Alle vragen tonen</button>
					</div>
				</div>

				<ul>
				<?php 
					foreach($zoekvragen_lijst as $lijst){
						$score = $lijst->score;
						$score *= 10.00;
						$score = number_format($score, 1, ',', '')
				 ?>
					<li>
						<div class="relevantie"><p><?php  echo $score; ?> %</p></div>
						<div class="vraag"><p><?php  echo $lijst->vraag ; ?></p></div>
						<div class="antwoord"><p><?php  echo $lijst->antwoord ; ?></p></div>
					</li>
				<?php 
					}
					$_POST['zoek_tekst'] = '';
				 ?>
				</ul>
			</div>
		<?php 
			} else {
		 ?>
			<div id="alle_vragen">
				<h1>Veel gestelde vragen</h1>
				<ul>
				<?php 
					foreach($faqs_lijst as $faq){
				 ?>
					<li>
						<div class="vraag_nr"><p># <?php echo $faq->volgorde + 1; ?></p></div>
						<div class="vraag"><p><?php echo $faq->vraag; ?></p></div>
						<div class="antwoord"><p><?php echo $faq->antwoord; ?></p></div>
					</li>
				<?php 
				}
				 ?>				</ul>
			</div>
			<?php 
			}
			 ?>
		</div>
	</div>
</div>