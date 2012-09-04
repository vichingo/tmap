<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:24
         compiled from gastenboek.tpl */ ?>
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
		<div class="gb_lijstkolom">

		<?php 

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
		 ?>
		<!-- begin bericht -->
		<div class="gb_bericht">
				<div class="gb_bericht-datum">
					<div class="gb_bericht-dag"><p><?php  echo $dag; ?></p></div>
					<div class="gb_bericht-maand"><p><?php  echo $maand; ?></p></div>
					<div class="gb_bericht-jaar"><p><?php  echo $jaar; ?></p></div>
					<div class="gb_bericht-tijd"><p><?php  echo $uur; ?></p></div>
				</div>
				<div class="gb_bericht-content">
					<div class="gb_bericht-naam"><p><?php  echo $bericht->naam; ?></p></div>
					<div class="gb_bericht-email"><p><?php  echo $bericht->email; ?></p></div>
					<div class="gb_bericht-krabbel"><p><?php  echo $bericht->bericht; ?></p></div>
				</div>
				<div class="gb_bericht-nummer"><p>#<?php  echo $nummer; ?></p></div>
			</div>
		<!-- einde bericht -->
		<?php 

		}
		 ?>
		</div>
	</div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gastenboek_bericht.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>