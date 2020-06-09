<?php /* Smarty version 2.6.18, created on 2020-06-01 20:05:32
         compiled from ImportForm_step2.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ImportForm_step2.html', 6, false),array('block', 'translate', 'ImportForm_step2.html', 29, false),)), $this); ?>
<?php echo '
<script language="javascript"><!--
function expandImportData(){
	var a = document.getElementById(\'preview-import-data-a\');
	var imgs = a.getElementsByTagName(\'img\');
'; ?>
	imgs[0].src = '<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['DATAFACE_URL'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
/images/treeExpanded.gif';<?php echo '
	a.onclick = collapseImportData;
	var spans = a.getElementsByTagName(\'span\');
	spans[0].innerHTML = \'Hide Import Data\';
	var div = document.getElementById(\'preview-import-data-div\');
	div.style.display = \'\';
	return false;
}

function collapseImportData(){
	var a = document.getElementById(\'preview-import-data-a\');
	var imgs = a.getElementsByTagName(\'img\');
'; ?>
	imgs[0].src = '<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['DATAFACE_URL'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
/images/treeCollapsed.gif';<?php echo '
	a.onclick = expandImportData;
	var spans = a.getElementsByTagName(\'span\');
	spans[0].innerHTML = \'Preview Import Data\';
	var div = document.getElementById(\'preview-import-data-div\');
	div.style.display = \'none\';
	return false;

}
//--></script>
'; ?>

<h4><?php $this->_tag_stack[] = array('translate', array('id' => "templates.ImportForm_step2.HEADING_FOUND_RECORDS",'num' => $this->_tpl_vars['num_records'])); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Found <?php echo ((is_array($_tmp=$this->_tpl_vars['num_records'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 records to import.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h4>
<a id="preview-import-data-a" title="<?php $this->_tag_stack[] = array('translate', array('id' => "templates.ImportForm_step2.LABEL_PREVIEW")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Preview Import Data<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" href="#" onclick="expandImportData(); return false;"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['DATAFACE_URL'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/treeCollapsed.gif"> <span><?php $this->_tag_stack[] = array('translate', array('id' => "templates.ImportForm_step2.LABEL_PREVIEW")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Preview Import Data<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></a>
<div id="preview-import-data-div" style="display: none">
<?php echo $this->_tpl_vars['preview_data']; ?>

</div>