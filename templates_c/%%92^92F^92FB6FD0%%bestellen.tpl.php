<?php /* Smarty version 2.6.26, created on 2010-08-11 22:32:14
         compiled from bestellen.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'bestellen.tpl', 63, false),)), $this); ?>
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
		<div class="contentkolom full">
			<div id="bestelling">
			<?php if ($this->_tpl_vars['aantalLijnen'] > 0): ?>
				<div id="bestel_lijst">
				<table>					<thead>
						<tr>
							<td><p>Aantal</p></td>							<td><p>Naam</p></td><?php $_from = $this->_tpl_vars['gerecht_optie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optie']):
?>
							<td><p><?php echo $this->_tpl_vars['optie']->naam; ?>
</p></td>
<?php endforeach; endif; unset($_from); ?>							<td><p>Prijs</p></td>
							<td><p>Wijzigen</p></td>						</tr>
					</thead>					<tfoot>
						<tr>							<td colspan = "<?php echo $this->_tpl_vars['aantal_opties']+1; ?>
"></td>							<td><p>Totaal:</p></td>							<td><p>&#8364; <?php echo $this->_tpl_vars['totaalBedragzv']; ?>
 <?php if ($this->_tpl_vars['leverwijze_id'] == 2): ?><?php if ($this->_tpl_vars['totaalBedragzv'] < $this->_tpl_vars['leveringkosten_minimaal']): ?> + &#8364; <?php echo $this->_tpl_vars['bezorg_kosten']; ?>
  = &#8364; <?php echo $this->_tpl_vars['totaalBedrag']; ?>
<?php endif; ?><?php endif; ?></p></td>							<td></td>						</tr>
					</tfoot>					<tbody>
					<?php $_from = $this->_tpl_vars['mandje']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mandje'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mandje']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mandjelijn']):
        $this->_foreach['mandje']['iteration']++;
?>
						<tr>
							<td><p><?php echo $this->_tpl_vars['mandjelijn']['aantal']; ?>
</p></td>							<td><p><?php echo $this->_tpl_vars['mandjelijn']['gerecht_naam']; ?>
</p></td>
<?php $_from = $this->_tpl_vars['mandjelijn']['optie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['m_optie']):
?>
	<?php $_from = $this->_tpl_vars['gerecht_optie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['g_optie']):
?>
		<?php if ($this->_tpl_vars['g_optie']->naam == $this->_tpl_vars['k']): ?>
			<?php $_from = $this->_tpl_vars['optie_variatie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optie_v']):
?>
				<?php if ($this->_tpl_vars['optie_v']->optie_id == $this->_tpl_vars['g_optie']->id): ?>
					<?php if ($this->_tpl_vars['optie_v']->id == $this->_tpl_vars['m_optie']): ?>
									<td><p>
										<?php echo $this->_tpl_vars['optie_v']->variatie; ?>

									</p></td>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>							<td><p>&#8364; <?php echo $this->_tpl_vars['mandjelijn']['lijn_totaal_prijs']; ?>
</p></td>
							<td>
								<div class="bestellijnPlusMin">
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
							</td>						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
			</div>
			<div id="bestel_handelingen">
				<div id="levertijd">
				<?php if ($this->_tpl_vars['reservatie']): ?>
					<p>Het <?php echo $this->_tpl_vars['leverwijze_naam']; ?>
 van de bestelling zal op <?php echo $this->_tpl_vars['reservatiedatum']; ?>
 om <?php echo $this->_tpl_vars['reservatietijd']; ?>
 gebeuren.</p>
				<?php else: ?>
				 	<p><?php echo ((is_array($_tmp=$this->_tpl_vars['leverwijze_naam'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
: &#177 40 minuten na het versturen van de bestelling.</p>
				<?php endif; ?>
				</div>
	<?php 
		if($_COOKIE[klant][klant_id]){
			$klant_id = $_COOKIE[klant][klant_id];
			if($_COOKIE[klant][$klant_id][loggedin] == yes){
				if($_COOKIE['klant'][$klant_id]['geblokkeerd'] == 0){
				 ?>
				<div id="bestel_knoppen">
					<div id="annuleren">
						<button type="button" onClick="location.href='mandje.php?act=mandjelegen'">Bestelling annuleren</button>
					</div>
					<div id="voltooien">
						<button type="button" onClick="location.href='index.php?lokatie=leveren'">Bestelling versturen</button>
					</div>
					<div id="wijzigen">
						<button type="button" onClick="location.href='index.php?lokatie=menu'">Bestelling wijzigen</button>
					</div>
				</div>
				<?php 
				} else {
				 ?>
				<div id="aanmelden">
					<p>Wegens een nog openstaande rekening kunt u helaas niets bestellen.
					<br />Neem zo snel mogelijk contact met ons op om dit euvel te verhelpen.</p>
				</div>
				<?php 
				}
			} else {
				 ?>
				<div id="aanmelden">
					<p>Om de bestelling te kunnen verder zetten wordt u verzocht uzelf aan te melden.</p>
				</div>
				<?php 
			}
		} else {
	 ?>
		<div id="aanmelden">
			<p>Om de bestelling te kunnen verder zetten wordt u verzocht uzelf aan te melden of te registreren.</p>
		</div>
	<?php 
	}
	 ?>
				</div>
<?php else: ?>
				<div class="lege_bestelling">
					<p>Inhoud van mandje is leeg</p>
				</div>
<?php endif; ?>
			</div>

	</div>
	</div>
</div>