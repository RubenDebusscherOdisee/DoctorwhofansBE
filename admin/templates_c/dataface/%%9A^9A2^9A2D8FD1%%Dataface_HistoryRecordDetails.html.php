<?php /* Smarty version 2.6.18, created on 2019-10-25 13:53:27
         compiled from Dataface_HistoryRecordDetails.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Dataface_HistoryRecordDetails.html', 15, false),)), $this); ?>
<table class="details_table_wrapper">
	<tr>
		<td>
			<table class="details_table">
				

<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field']):
?>
	<?php if ($this->_tpl_vars['field']['name'] == $this->_tpl_vars['first_field_second_col']): ?>
	</table></td><td><table class="details_table">
	<?php endif; ?>
	<?php if ($this->_tpl_vars['field']['visibility']['history'] != 'hidden'): ?>
	<tr>
		<td <?php if ($this->_tpl_vars['table']->isText($this->_tpl_vars['field']['name'])): ?>colspan="2" <?php endif; ?>class="details_label_cell">
			<label>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:
			</label>
		</td>
		<?php if ($this->_tpl_vars['table']->isText($this->_tpl_vars['field']['name'])): ?></tr><tr><?php endif; ?>
		<td <?php if ($this->_tpl_vars['table']->isText($this->_tpl_vars['field']['name'])): ?>colspan="2" <?php endif; ?>class="details_value_cell <?php if ($this->_tpl_vars['table']->isText($this->_tpl_vars['field']['name'])): ?>max-10-rows<?php endif; ?>">

			<?php echo $this->_tpl_vars['history_record']->htmlValue($this->_tpl_vars['field']['name']); ?>

			
		</td>
	</tr>
	<?php endif; ?>
	
	
<?php endforeach; endif; unset($_from); ?>
			</table>
		</td>
	</tr>
</table>