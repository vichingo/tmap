<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:10
         compiled from welkom_klant.tpl */ ?>
<?php 

	$kl_id 			= $_COOKIE['klant']['klant_id'];

	/*
	 * Laaste bestelling van de klant
	 *
	 * Deze vragen we op om op de intro pagina van de klant de laatste bestelling te tonen.
	 *
	 */

	$heeft_bestellingen = new tmap();
	$heeft_bestellingen->table_arr	= array('klant_bestelling kb');
	$heeft_bestellingen->column_arr	= array('COUNT(klant_id) aantal_bestellingen');
	$heeft_bestellingen->where_arr	= array('kb.klant_id'=>$kl_id);
	$heeft_bestellingen->lijst 			= $heeft_bestellingen->lezen();
	$heeft_bestellingen_lijst 			= $heeft_bestellingen->lijst;
	$heeft_aantal_bestellingen	= $heeft_bestellingen_lijst[0]->aantal_bestellingen;


	if ($heeft_aantal_bestellingen > 0){
	$laatste_bestelling = new tmap();
	if (isset($_COOKIE['klant'][$kl_id]['last_id'])){
		$last_id = $_COOKIE['klant'][$kl_id]['last_id'];
	} else {

		$l_id 				= new tmap();
		$l_id->table_arr 	= array('klant_bestelling k');
		$l_id->column_arr 	= array('MAX(k.bestelling_id) laatste_bestelling');
		$l_id->where_arr	= array('k.klant_id'=>$kl_id);
		$l_id->lijst 		= $l_id->lezen();
		$l_id_lijst			= $l_id->lijst;

		$last_id			= $l_id_lijst[0]->laatste_bestelling;
	}

	$laatste_bestelling->column_arr 	= array( 'b.id'
												,'b.bestelling_nummer'
												,'b.besteltijd'
												,'le.naam leverwijze_naam'
												,'b.totaal_prijs'
												);

	$laatste_bestelling->table_arr 		= array( 'bestelling b'
												,'bestelling_lijn bl'
												,'klant_bestelling k'
												,'leverwijze le'
												);

	$laatste_bestelling->where_arr 		= array( 'b.leverwijze_id' => 'le.id'
												,'b.id'=>'k.bestelling_id'
												,'k.klant_id'=>$kl_id
												,'b.id'=>$last_id
												);

	$laatste_bestelling->group_arr 	= array(	 'b.bestelling_nummer'
												);
	$laatste_bestelling->sort_arr 	= array(	 'b.besteltijd'
												);
	$laatste_bestelling->lijst 			= $laatste_bestelling->lezen();
	$laatste_bestelling_lijst 			= $laatste_bestelling->lijst;
	$laatste_bestelling_kol 			= $laatste_bestelling->aantalKolommen;
	$laatste_bestelling_rij 			= $laatste_bestelling->aantalRijen;
	$laatste_bestelling_kol_nam 		= $laatste_bestelling->kolomNamen;
	//echo $laatste_bestelling->r_Query;
	//echo $laatste_bestelling->makeJson();

	/*
	 * Aantal gerechten binnen de laatste bestelling
	 */

	$lb_lijnen = new tmap();
	$lb_lijnen->table_arr 	= array('bestelling_lijn b');
	$lb_lijnen->column_arr = array('SUM(b.lijn_aantal) aantal_lijnen');
	$lb_lijnen->where_arr	= array('b.bestelling_id' => $last_id);
	$lb_lijnen->group_arr	= array('b.bestelling_id');
	$lb_lijnen->lijst 		= $lb_lijnen->lezen();
	$lb_lijnen_lijst 		= $lb_lijnen->lijst;
	$aantal_lijnen			= $lb_lijnen_lijst[0]->aantal_lijnen;

	/*
	 * De gerechten die horen bij de laaste bestelling
	 */
	}
 ?>

<div id="welkomkolom">
	<h1>Welkom,
	<?php 
		echo " " . $_COOKIE['klant'][$kl_id]['voornaam'] . " " . $_COOKIE['klant'][$kl_id]['achternaam'];
	 ?>
	</h1>
	<?php 
	//start if
	if ($laatste_bestelling_rij != 0){
	 ?>
	<h3>Uw laaste bestelling is <?php  echo tijdTussen($laatste_bestelling_lijst[0]->besteltijd, time()) ?></h3>
	<div id="laatse_bestelling">
		<div id="opsomming">
			<div class="laatse_bestelling_nummer">
				<p>BestelNummer: <span><?php  echo $laatste_bestelling_lijst[0]->bestelling_nummer; ?></span></p>
			</div>
			<div class="laatse_bestelling_tijd">
				<p>Besteld op: <span><?php  echo date('d-m-Y', $laatste_bestelling_lijst[0]->besteltijd) . ' om ' . date('H:i', $laatste_bestelling_lijst[0]->besteltijd)  ?></span></p>
			</div>
			<div class="laatse_bestelling_leverwijze">
				<p>U heeft de bestelling laten: <span><?php  echo ucfirst($laatste_bestelling_lijst[0]->leverwijze_naam); ?></span></p>
			</div>
			<div class="laatse_bestelling_lijnen">
				<p>Aantal gerechten: <span><?php echo $aantal_lijnen; ?></span></p>
			</div>
			<div class="laatse_bestelling_totaal_prijs">
				<p>Totaal te betalen: <span>&#8364; <?php  echo $laatste_bestelling_lijst[0]->totaal_prijs; ?></span></p>
			</div>
		</div>
		<div class="laatse_bestelling_lijn_header">
			<div class="laatse_bestelling_lijn_header_aantal">Aantal</div>
			<div class="laatse_bestelling_lijn_header_naam">Naam</div>
			<div class="laatse_bestelling_lijn_header_opties">Opties</div>
			<div class="laatse_bestelling_lijn_header_prijs">Prijs</div>
		</div>
		<?php 
		$bestelling_lijn = new tmap();
		$bestelling_lijn->table_arr 		= array(	 'bestelling b'
														,'bestelling_lijn bl');
		$bestelling_lijn->column_arr 		= array(	 'b.id bestelling_id'
														,'bl.id bestellijn_id'
														,'bl.lijn_naam'
														,'bl.lijn_aantal'
														,'bl.lijn_prijs');
		$bestelling_lijn->where_arr			= array(	 'bl.bestelling_id' => 'b.id'
														,'b.id' => $last_id);
		$bestelling_lijn->lijst 			= $bestelling_lijn->lezen();
		$bestelling_lijn_lijst 				= $bestelling_lijn->lijst;
		//echo $bestelling_lijn->r_Query;
		//echo $bestelling_lijn->makeJson();


		//begin foreach
		foreach ($bestelling_lijn_lijst as $lijn){
		 ?>
		<div class="laatse_bestelling_lijn">
			<div class="laatse_bestelling_lijn_aantal"><?php  echo $lijn->lijn_aantal; ?> x</div>
			<div class="laatse_bestelling_lijn_naam"><?php  echo $lijn->lijn_naam; ?></div>
			<div class="laatse_bestelling_lijn_opties">
				<ul>
				<?php 

				$bestelling_lijn_opties = new tmap();
				$bestelling_lijn_opties->table_arr 		= array(	 'bestelling_lijn b'
																	,'bestellijn_gerecht_opties bj'
																	,'gerecht_opties g'
																	,'optie_variant o');

				$bestelling_lijn_opties->column_arr 	= array(	'g.naam optie_naam'
																	,'o.naam variant_naam');
				$bestelling_lijn_opties->where_arr		= array(	 'bj.bestellijn_id' => 'b.id'
																	,'bj.gerecht_optie_variant_id' => 'o.id'
																	,'o.optie_id' => 'g.id'
																	,'b.id' => $lijn->bestellijn_id);
				$bestelling_lijn_opties->lijst 			= $bestelling_lijn_opties->lezen();
				$bestelling_lijn_opties_lijst 			= $bestelling_lijn_opties->lijst;

				//echo $bestelling_lijn_opties->r_Query;
				//echo $bestelling_lijn_opties->makeJson();
				foreach($bestelling_lijn_opties_lijst as $optie){

				//start foreach
				 ?>
					<li><?php echo $optie->optie_naam . ': ' .  $optie->variant_naam ?></li>
				<?php 
				}
				// end foreach
				 ?>
				</ul>
			</div>
			<div class="laatse_bestelling_lijn_prijs">&#8364; <?php  echo $lijn->lijn_prijs; ?></div>
		</div>
		<?php 
		}
		// end foreach
		 ?>
	</div>
	<?php 
	//else
	} else {
	 ?>
		<h3>U heeft nog geen eerdere bestelling bij ons afgerond</h3>
	<?php 
	}
	//end if
	 ?>
</div>