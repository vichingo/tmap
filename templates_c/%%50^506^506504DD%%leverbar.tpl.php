<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:10
         compiled from leverbar.tpl */ ?>
<span>
	<?php $_from = $this->_tpl_vars['leveren_in']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['leverplaats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leverplaats']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['leverin']):
        $this->_foreach['leverplaats']['iteration']++;
?>
		<?php if (($this->_foreach['leverplaats']['iteration'] <= 1)): ?>
			<?php echo $this->_tpl_vars['leverin']->name; ?>

		<?php else: ?>
			<?php if (($this->_foreach['leverplaats']['iteration'] == $this->_foreach['leverplaats']['total'])): ?>
				en <?php echo $this->_tpl_vars['leverin']->name; ?>

			<?php else: ?>
			, <?php echo $this->_tpl_vars['leverin']->name; ?>

			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
</span>