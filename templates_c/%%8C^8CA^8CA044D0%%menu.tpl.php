<?php /* Smarty version 2.6.26, created on 2010-08-24 15:05:44
         compiled from menu.tpl */ ?>
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
		<div class="contentkolom">
			<div id="gerechten">
				<div id="gerechten_lijst">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menukaart.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
		</div>
	</div>
	<div id="product_detailkolom">
		<?php 

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


				 ?>
		<div class="lijn_data" id="gerecht_<?php echo $gerecht->id; ?>">
			<form name="verzamelen" method="post" action="mandje.php">
				<div class="product_data">
					<div class="product_text">
						<input type="hidden" id="lijn_id" name="lijn_id" value="<?php 
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
						 ?>"/>
						<input type="hidden" id="gerecht_id_<?php echo $gerecht->id; ?>" name="gerecht_id" value="<?php echo $gerecht->id; ?>"/>
						<input type="hidden" id="gerecht_naam_<?php echo $gerecht->id; ?>" name="gerecht_naam" value="<?php echo $gerecht->naam; ?>"/>
						<input type="hidden" id="gerecht_prijs_<?php echo $gerecht->id; ?>" name="gerecht_prijs" value="<?php echo $basisprijs_totaal; ?>"/>
						<p>Gerecht:</p>
						<p class="gerecht_naam">
						<?php echo $gerecht->naam; ?>
						</p>
						<p>Prijs:</p>
						<p class="gerecht_prijs">
						&#8364; <span id="gerecht_basisprijs_<?php echo $gerecht->id; ?>"><?php echo $basisprijs_totaal; ?></span><span id="matrix_prijs_<?php echo $gerecht->id; ?>"></span>
						</p>
					</div>
				</div>
				<div class="product_options">
					<ul class="optionbar">
						<?php $_from = $this->_tpl_vars['gerecht_optie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optie']):
?>
						<!-- start optie section -->
						<li>
							<label for="optie_<?php echo $this->_tpl_vars['optie']->id; ?>
"><?php echo $this->_tpl_vars['optie']->naam; ?>
</label>
							<select class="product_optie" id="optie_<?php echo $this->_tpl_vars['optie']->id; ?>
" name="optie[<?php echo $this->_tpl_vars['optie']->naam; ?>
]">
								<?php $_from = $this->_tpl_vars['optie_variatie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['variatie']):
?>
								    <?php if ($this->_tpl_vars['optie']->id == $this->_tpl_vars['variatie']->optie_id): ?>
								    	<option id="<?php echo $this->_tpl_vars['variatie']->id; ?>
" value="<?php echo $this->_tpl_vars['variatie']->id; ?>
_<?php echo $this->_tpl_vars['variatie']->matrix; ?>
"><?php echo $this->_tpl_vars['variatie']->variatie; ?>
</option>
								    <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</select>
						</li>
						<!-- end optie section -->
						<?php endforeach; endif; unset($_from); ?>
						<li>
							<button class="verzamelKnop" type="submit" id="verzamelen" name="act" value="verzamelen">Voeg toe aan mandje</button>
						</li>
					</ul>
				</div>
			</form>
</div>
				<?php 
			}
		 ?>
	</div>
	<div id="orderkolom">
		<form name="bestellen" method="post" action="index.php?lokatie=bestellen">
		<div id="mandje_header">
			<img class="bestellen_image" src="images/design/buy-icon_32.png" alt="Uw bestelling"/>
			<h3>Uw Bestelling</h3>
		</div>
		<div id="mandjelijnen">
<?php $_from = $this->_tpl_vars['mandje']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mandje'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mandje']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mandjelijn']):
        $this->_foreach['mandje']['iteration']++;
?>
		<div class="mandjelijn">
			<input type="hidden" name="mandjelijn_id" value="<?php echo $this->_tpl_vars['mandjelijn']['lijn_id']; ?>
"/>
			<div class="mandjelijn_aantal"><?php echo $this->_tpl_vars['mandjelijn']['aantal']; ?>
x</div>
			<div class="mandjelijn_naam"><?php echo $this->_tpl_vars['mandjelijn']['gerecht_naam']; ?>
</div>
			<div class="mandjeUpdateBlock">
				<div class="mandjelijnPlusMin">
					<?php if ($this->_tpl_vars['mandjelijn']['aantal'] > 1): ?>
				    <a href="mandje.php?act=verminderen&lijnid=<?php echo $this->_tpl_vars['mandjelijn']['lijn_id']; ?>
">
						<img class="mandjeIcon" src="images/fugue/icons/minus-button.png" alt="verwijder 1 van de <?php echo $this->_tpl_vars['mandjelijn']['aantal']; ?>
 <?php echo $this->_tpl_vars['mandjelijn']['gerecht_naam']; ?>
's uit bestellijst"/>
					</a>
					<?php endif; ?>
				    <a href="mandje.php?act=vermeerderen&lijnid=<?php echo $this->_tpl_vars['mandjelijn']['lijn_id']; ?>
">
						<img class="mandjeIcon" src="images/fugue/icons/plus-button.png" alt="vermeerder de <?php echo $this->_tpl_vars['mandjelijn']['gerecht_naam']; ?>
 met 1"/>
					</a>
					<a href="mandje.php?act=verwijderen&lijnid=<?php echo $this->_tpl_vars['mandjelijn']['lijn_id']; ?>
">
						<img class="mandjeIcon" src="images/fugue/icons-shadowless/_overlay/shopping-basket--minus.png" alt="verwijder <?php echo $this->_tpl_vars['mandjelijn']['gerecht_naam']; ?>
 uit bestellijst"/>
					</a>
				</div>
			</div>
			<div class="mandjelijn_prijs">&#8364; <?php echo $this->_tpl_vars['mandjelijn']['lijn_totaal_prijs']; ?>
</div>

		</div>
<?php endforeach; endif; unset($_from); ?>
		</div>
		<?php if ($this->_tpl_vars['aantalLijnen'] > 0): ?>
		<div id="mandje_totalen">
		<ul>			<li><b>Aantal Pizza's: </b><?php echo $this->_tpl_vars['aantalGerechten']; ?>
</li>
			<li><b>Bezorgkosten: </b>&#8364; <?php echo $this->_tpl_vars['bezorg_kosten']; ?>
</li>
			<li><b>Gratis bezorging vanaf: </b>&#8364; <?php echo $this->_tpl_vars['leveringkosten_minimaal']; ?>
</li>
			<li><b>Totaal bestelling: </b>&#8364; <?php echo $this->_tpl_vars['totaalBedragzv']; ?>
 <?php if ($this->_tpl_vars['totaalBedragzv'] < $this->_tpl_vars['leveringkosten_minimaal']): ?> + &#8364; <?php echo $this->_tpl_vars['bezorg_kosten']; ?>
  = &#8364; <?php echo $this->_tpl_vars['totaalBedrag']; ?>
<?php endif; ?></li>		</ul>
		</div>
		<?php else: ?>
		<div id="leeg_mandje">
			U heeft nog niets besteld.
		</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['levertijd_is_vroeger']): ?>
		<div id="levertijd_verkeerd">
			<p>De reservatie tijd is vroeger dan de levertijd!!</p>
		</div>
		<?php endif; ?>
		<div id="leverwijze_keuze">
			<label for="leverwijze_id">Leverwijze</label>
			<select id="leverwijze_id" name="leverwijze_id">
				<?php $_from = $this->_tpl_vars['leverwijze_lijst']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['leverwijze']):
?>
				    	<option value="<?php echo $this->_tpl_vars['leverwijze']->id; ?>
"><?php echo $this->_tpl_vars['leverwijze']->naam; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</div>
		<div id="reservatie_keuze_box">
			<button type="button" name="reservatie_knop" id="reservatie_knop">Reserveren</button>
			<div id="reservatie_input">
				<label for="reservatie_datum_tijd">Ik wil reserveren op:</label>
				<input type="text" name="reservatie_datum_tijd" id="reservatie_datum_tijd" value="<?php  echo $_POST['reservatie_datum_tijd']; ?>"/>
			</div>
		</div>
		<div id="verwerk_bestelling_knop">
			<button class="bestelKnop" type="submit" name="bestelling_verwerken">Verwerk bestelling</button>
		</div>
		</form>
	</div>

</div>