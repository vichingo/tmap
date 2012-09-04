<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:10
         compiled from bouncerbar.tpl */ ?>
<div id="bouncerbar">
	<ul>
	<?php 
		if($_COOKIE['klant']['klant_id']){
			$klant_id = $_COOKIE['klant']['klant_id'];
			if($_COOKIE['klant'][$klant_id]['loggedin'] == yes){
				 ?>
					<li>
						<a href="account.php?act=logout">
							Afmelden
						</a>
					</li>
					<li> | </li>
					<li>
						<a href="index.php?lokatie=klantdata">
							Uw gegevens
						</a>
					</li>
				<?php 
			} else {
	 ?>
		<li>
			<a href="index.php?lokatie=registreren">
				Registreren
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=inloggen">
				Aanmelden
			</a>
		</li>
	<?php 
		}
	} else {
	 ?>
		<li>
			<a href="index.php?lokatie=registreren">
				Registreren
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=inloggen">
				Aanmelden
			</a>
		</li>
	<?php 
	}
	 ?>

		<li> | </li>
		<li>
			<a href="admin/" target="_blank">
				Admin
			</a>
		</li>
		<li> | </li>
		<li>
			<a href="index.php?lokatie=bestellen">
				Bestelling
			</a>
				<?php if ($this->_tpl_vars['aantalLijnen'] > 0): ?>
					<img class="alertIcon" src="images/fugue/icons/_overlay/shopping-basket--exclamation.png" alt="De bestelling bevat <?php echo $this->_tpl_vars['aantalLijnen']; ?>
 gerechten"/>
				<?php endif; ?>
		</li>
	</ul>
</div>