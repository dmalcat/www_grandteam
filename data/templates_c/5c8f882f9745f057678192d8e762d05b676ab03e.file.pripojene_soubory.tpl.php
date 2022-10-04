<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:37
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/pripojene_soubory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17004711775bb94a4d675c40-42981324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c8f882f9745f057678192d8e762d05b676ab03e' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/pripojene_soubory.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17004711775bb94a4d675c40-42981324',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.truncate.php';
?><div class="soubory_box">
		<h2>PŘIPOJENÉ SOUBORY <?php if ($_smarty_tpl->getVariable('dbCC')->value){?>(<?php echo count($_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_FILES));?>
)<?php }?></h2>
		<?php if ($_smarty_tpl->getVariable('dbCC')->value){?>
			<?php  $_smarty_tpl->tpl_vars['pGallery'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_FILES); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fotogalerie']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pGallery']->key => $_smarty_tpl->tpl_vars['pGallery']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fotogalerie']['iteration']++;
?>
				 <form action="" method="post">
					<div class="galerie_box">
						<div class="galerie_cislo"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['fotogalerie']['iteration'];?>
</div>
						<div class="galerie_text" style="margin-left: 0px; width: 250px;"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('pGallery')->value->title,25);?>
</div>
						<input type="hidden" name="idGallery" value="<?php echo $_smarty_tpl->getVariable('pGallery')->value->id;?>
"/>
						<input type="hidden" name="galleryPriority" value="<?php echo dbGallery::DEFAULT_PRIORITY;?>
"/>
						<input type="submit" title="Odebrat soubory od článku" name="doUnMapGallery" class="pridat_spojeni" value="ODEBRAT PŘIPOJENÍ" onclick="return confirm('Opravdu odebrat propojeni s těmito soubory ?')">
					</div>
				 </form>
			<?php }} ?>
		<?php }?>
		<div class="galerie_box">
		 	<form action="" method="post" id="doMapGalleryFoto">
				<div class="galerie_cislo"></div>
				<div class="galerie_select">
					<select name="idGallery">
						<option value=""> -- vyberte -- </option>
						<?php  $_smarty_tpl->tpl_vars['pGallery'] = new Smarty_Variable;
 $_from = dbGallery::getAll(dbGallery::TYPE_FILES); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pGallery']->key => $_smarty_tpl->tpl_vars['pGallery']->value){
?>
							<option name="idGallery" value="<?php echo $_smarty_tpl->getVariable('pGallery')->value->id_gallery;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('pGallery')->value->title,40);?>
</option>
						<?php }} ?>
					</select>
				</div>
				<input type="hidden" name="galleryPriority" value="<?php echo dbGallery::DEFAULT_PRIORITY;?>
"/>
				<input type="submit" title="Přidat soubory k článku" name="doMapGallery" class="pridat_spojeni" value="PŘIPOJIT K ČLÁNKU">
			 </form>
		</div>
	</div>