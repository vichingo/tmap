<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:09
         compiled from home.tpl */ ?>
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
	<?php 
	if (isset($_COOKIE['klant']['klant_id'])){
		$klant_id = $_COOKIE['klant']['klant_id'];
		if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
			 ?>
				<div class="maincontent">
			<?php 
			} else {
			 ?>
				<div class="maincontent stretched">
			<?php 
			}
		}
	 ?>

			<div class="intro">
				<h1>Welkom</h1>
				<h2>Welkom op onze website</h2>
				<p>Bekijk onze menukaart door deze hierboven in het menu te kiezen.</p>
				<p>Heeft u al een account bij ons, log dan in met uw e-mail adres en wachtwoord.</p>
				<p>Heeft u nog geen account bij ons, maar bent u voor een snelle afhandeling van uw bestelling, registreer u dan op voorhand, zodat u achteraf de gegevens niet hoeft in te vullen. </p>
			</div>
		</div>
	</div>
	<?php 
	if (isset($_COOKIE['klant']['klant_id'])){
		$klant_id = $_COOKIE['klant']['klant_id'];
		if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
			 ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "welkom_klant.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php 
			}
		}
	 ?>
</div>