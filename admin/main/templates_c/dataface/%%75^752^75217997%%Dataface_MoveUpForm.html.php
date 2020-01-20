<?php /* Smarty version 2.6.18, created on 2019-12-31 14:18:57
         compiled from Dataface_MoveUpForm.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Dataface_MoveUpForm.html', 23, false),)), $this); ?>
<?php echo '
<script language="javscript" type="text/javascript"><!--

function moveUp(id){
	var form = document.moveRecordForm;
	form.elements[\'-reorder:index\'].value = id;
	form.elements[\'-reorder:direction\'].value = \'up\';
	form.submit();
}

function moveDown(id){
	var form = document.moveRecordForm;
	form.elements[\'-reorder:index\'].value = id;
	form.elements[\'-reorder:direction\'].value = \'down\';
	form.submit();
}

//--></script>



'; ?>

<form style="display: none" name="moveRecordForm" method="POST" action="<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['APPLICATION_OBJECT']->url('-action=reorder_related_records'))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
	<input type="hidden" name="-redirect" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['SERVER']['PHP_SELF'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
?<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['SERVER']['QUERY_STRING'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
	<input type="hidden" name="-reorder:index"/>
	<input type="hidden" name="-reorder:direction"/>
</form>