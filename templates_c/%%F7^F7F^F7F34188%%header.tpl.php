<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:09
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'header.tpl', 5, false),)), $this); ?>
<?php echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'; ?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Take Me Away Pizza 24 x 7') : smarty_modifier_default($_tmp, 'Take Me Away Pizza 24 x 7')); ?>
</title>

		<link rel="stylesheet" href="css/tmap.css" type="text/css" media="screen" charset="utf-8" />
		<?php 
			include 'includes/header.inc';
		 ?>
	</head>
	<body>