<?php /* Smarty version Smarty-3.0.7, created on 2022-07-12 15:47:51
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/pripojene_videogalerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:57742660362cd7b87b6e8b4-00543552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f74c37eb0e08fcf27a7b196736e95d78818205e' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/pripojene_videogalerie.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57742660362cd7b87b6e8b4-00543552',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.truncate.php';
?><div class="fotogalerie_box">
	<h2>PŘIPOJENÉ VIDEOGALERIE <?php if ($_smarty_tpl->getVariable('dbCC')->value){?>(<?php echo count($_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_VIDEO));?>
)<?php }?></h2>
	<?php if ($_smarty_tpl->getVariable('dbCC')->value){?>
		<?php  $_smarty_tpl->tpl_vars['pGallery'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_VIDEO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fotogalerie']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pGallery']->key => $_smarty_tpl->tpl_vars['pGallery']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fotogalerie']['iteration']++;
?>
			<form action="" method="post" id="doMapGalleryFoto">
				<div class="galerie_box">
					<div class="galerie_cislo"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['fotogalerie']['iteration'];?>
</div>
					<div class="galerie_text" style="margin-left: 0px; width: 250px;"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('pGallery')->value->title,25);?>
</div>
					<input type="hidden" name="idGallery" value="<?php echo $_smarty_tpl->getVariable('pGallery')->value->id;?>
"/>
					<input type="hidden" name="galleryPriority" value="<?php echo dbGallery::DEFAULT_PRIORITY;?>
"/>
					<input type="submit" title="Odebrat galerii od článku" name="doUnMapGallery" class="pridat_spojeni" value="ODEBRAT PŘIPOJENÍ" onclick="return confirm('Opravdu odebrat propojeni s touto galerií ?')">
				</div>
			</form>
		<?php }} ?>
	<?php }?>
	<div class="galerie_box">
		<form action="" method="post">
			<div class="galerie_cislo"></div>
			<div class="galerie_select">
				<select name="idGallery">
					<option value=""> -- vyberte -- </option>
					<?php  $_smarty_tpl->tpl_vars['pGallery'] = new Smarty_Variable;
 $_from = dbGallery::getAll(dbGallery::TYPE_VIDEO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pGallery']->key => $_smarty_tpl->tpl_vars['pGallery']->value){
?>
						<option name="idGallery" value="<?php echo $_smarty_tpl->getVariable('pGallery')->value->id_gallery;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('pGallery')->value->title,40);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['pGallerySub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pGallery')->value->getSubGalleries(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pGallerySub']->key => $_smarty_tpl->tpl_vars['pGallerySub']->value){
?>
							<option name="idGallery" value="<?php echo $_smarty_tpl->getVariable('pGallerySub')->value->id_gallery;?>
">&nbsp;&nbsp;-&nbsp;<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('pGallerySub')->value->title,40);?>
</option>
						<?php }} ?>
					<?php }} ?>
				</select>
			</div>
			<input type="hidden" name="galleryPriority" value="<?php echo dbGallery::DEFAULT_PRIORITY;?>
"/>
			<input type="submit" title="Přidat galerii k článku" name="doMapGallery" class="pridat_spojeni" value="PŘIPOJIT K ČLÁNKU">
		</form>
	</div>
</div>