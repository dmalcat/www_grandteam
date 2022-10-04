<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 11:16:40
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3761807705bb9cef8ecd919-73578647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26d777ebf4bb98592e0fc2bb1b7c45a6d602f31b' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/menu.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3761807705bb9cef8ecd919-73578647',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1 class="clanek_title"><?php if (!$_smarty_tpl->getVariable('dbCC')->value){?>NOVÁ POLOŽKA MENU<?php }else{ ?>EDITACE POLOŽKY MENU - <?php echo $_smarty_tpl->getVariable('dbC')->value->title_1;?>
<?php }?></h1>
<form action="" method="post" id="nova_polozka_menu" enctype="multipart/form-data">

	<div class="clanek_levy_sloupec">
		<span class="label">Název *</span>
		<div class="nazev_hd"></div>
		<div class="nazev_bg">
			<input type="text" name="nazev" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->name;?>
" class="validate[required]" id="nazev"/>
		</div>
		<div class="nazev_ft"></div>

		<span class="label">Externí odkaz / emailová adresa</span>
		<div class="nazev_hd"></div>
		<div class="nazev_bg">
			<input type="text" name="external_url" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->external_url;?>
" class="" id="externi_url"/>
		</div>
		<div class="cb"></div>
		<div class="nazev_ft"></div>

	</div>

	<div class="clanek_pravy_sloupec">
		<table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>ZAŘAZENÍ V MENU</td>
				<td style="padding-left:35px;">
					<select name="id_content_type">
						<?php  $_smarty_tpl->tpl_vars['pContentType'] = new Smarty_Variable;
 $_from = dbContentType::getAll(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pContentType']->key => $_smarty_tpl->tpl_vars['pContentType']->value){
?>
							<option value="<?php echo $_smarty_tpl->getVariable('pContentType')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('pContentType')->value->id==$_smarty_tpl->getVariable('dbCC')->value->id_content_type){?>selected="selected"<?php }?><?php if (!$_smarty_tpl->getVariable('dbCC')->value&&$_smarty_tpl->getVariable('pContentType')->value->id==dbContentType::DEFAULT_ID_CONTENT_TYPE){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('pContentType')->value->name;?>
</option>
						<?php }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td nowrap="nowrap">ZAŘAZENÍ V KATEGORII</td>
				<td style="padding-left:35px;">
					<select name="id_parent" id="id_content_category">
						<option value="">---</option>
						<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(null,null,$_smarty_tpl->getVariable('dbCC')->value->id_content_type); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
?>
							<option value="<?php echo $_smarty_tpl->getVariable('cat')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('cat')->value->id==(($tmp = @$_smarty_tpl->getVariable('dbCC')->value->id_parent)===null||$tmp==='' ? $_GET['parent'] : $tmp)){?> selected="true" <?php }?>><?php echo $_smarty_tpl->getVariable('cat')->value->name;?>
</option>
							<?php  $_smarty_tpl->tpl_vars['sub_cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cat')->value->getSubCategories(null); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sub_cat']->key => $_smarty_tpl->tpl_vars['sub_cat']->value){
?>
								<option value="<?php echo $_smarty_tpl->getVariable('sub_cat')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('sub_cat')->value->id==(($tmp = @$_smarty_tpl->getVariable('dbCC')->value->id_parent)===null||$tmp==='' ? $_GET['parent'] : $tmp)){?> selected="true" <?php }?>>----<?php echo $_smarty_tpl->getVariable('sub_cat')->value->name;?>
</option>
								<?php  $_smarty_tpl->tpl_vars['sub_sub_cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sub_cat')->value->getSubCategories(null); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sub_sub_cat']->key => $_smarty_tpl->tpl_vars['sub_sub_cat']->value){
?>
									<option value="<?php echo $_smarty_tpl->getVariable('sub_sub_cat')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('sub_sub_cat')->value->id==(($tmp = @$_smarty_tpl->getVariable('dbCC')->value->id_parent)===null||$tmp==='' ? $_GET['parent'] : $tmp)){?> selected="true" <?php }?>>--------<?php echo $_smarty_tpl->getVariable('sub_sub_cat')->value->name;?>
</option>
									<?php  $_smarty_tpl->tpl_vars['sub_sub_sub_cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sub_sub_cat')->value->getSubCategories(null); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sub_sub_sub_cat']->key => $_smarty_tpl->tpl_vars['sub_sub_sub_cat']->value){
?>
										<option value="<?php echo $_smarty_tpl->getVariable('sub_sub_sub_cat')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('sub_sub_sub_cat')->value->id==(($tmp = @$_smarty_tpl->getVariable('dbCC')->value->id_parent)===null||$tmp==='' ? $_GET['parent'] : $tmp)){?> selected="true" <?php }?>>--------<?php echo $_smarty_tpl->getVariable('sub_sub_sub_cat')->value->name;?>
</option>
										<?php  $_smarty_tpl->tpl_vars['sub_sub_sub_sub_cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sub_sub_sub_cat')->value->getSubCategories(null); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sub_sub_sub_sub_cat']->key => $_smarty_tpl->tpl_vars['sub_sub_sub_sub_cat']->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('sub_sub_sub_sub_cat')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('sub_sub_sub_sub_cat')->value->id==(($tmp = @$_smarty_tpl->getVariable('dbCC')->value->id_parent)===null||$tmp==='' ? $_GET['parent'] : $tmp)){?> selected="true" <?php }?>>------------<?php echo $_smarty_tpl->getVariable('sub_sub_sub_sub_cat')->value->name;?>
</option>
										<?php }} ?>
									<?php }} ?>

								<?php }} ?>
							<?php }} ?>
						<?php }} ?>
					</select>
				</td>
			</tr>
		</table>

		<table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th style="text-align:left;padding-left:30px;">Anotační obrázek 1</th>
				<th><!--  Anotační obrázek 2 --></th>
				<th><!--  Anotační obrázek 3 --></th>
			</tr>
			<tr>
				<td>
					<div class="anotacni_obr">
						<a href="<?php echo dbContentCategory::IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
/<?php echo $_smarty_tpl->getVariable('dbCC')->value->image_1;?>
" rel="shadowbox[trip]">
							<div class="anotacni_obr_image" style="background-image:url(<?php if ($_smarty_tpl->getVariable('dbCC')->value->image_1){?><?php echo dbContentCategory::IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
/<?php echo $_smarty_tpl->getVariable('dbCC')->value->image_1;?>
<?php }else{ ?>/images/admin/obr.png<?php }?>);">
							</div>
						</a>
						<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
						<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_1"></a>
						<div id="div_upload_foto_1" class="ui-datepicker">
							<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
								<div class="ui-datepicker-title">Nahrát foto</div>
								<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_1').hide();">
									<span class="ui-icon ui-icon-closethick"></span>
								</a>
							</div>
							<div style="width:250px;margin-top:10px;margin-left:5px;">
								<input type="file" name="content_category_image[]"/>
							</div>
						</div>
					</div>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
		</table>

	</div>



	<div class="submit_box">
		<?php if ($_smarty_tpl->getVariable('dbCC')->value){?>
			<input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
"/>
			<input type="hidden" name="visible" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->visible;?>
"/>
			<input type="hidden" name="menu" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->menu;?>
"/>
			<input type="hidden" name="priority" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->priority;?>
"/>
			<input type="submit" value="Uložit úpravy" name="do_clanek" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat menu" class="smazat_tlac" />
		<?php }else{ ?>
			<input type="hidden" name="menu" value="<?php echo dbContentCategory::TYPE_MENU;?>
"/>
			<input type="submit" value="Vložit položku menu" name="do_clanek" class="ulozit_upravy_tlac pozice_uprostred" />
		<?php }?>

		<!--<input type="submit" value="Smazat položku menu" class="smazat_tlac" />-->
	</div>

</form>

<div class="dalsi_moznosti_title ui-accordion-header">
	<span class="ui-icon ui-icon-circle-plus"></span>
	DALŠÍ MOŽNOSTI
</div>
<div class="dalsi_moznosti_box" style="padding-bottom: 0px; margin-bottom: 20px;">
	<?php $_template = new Smarty_Internal_Template("admin/pripojene_fotogalerie.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php $_template = new Smarty_Internal_Template("admin/pripojene_videogalerie.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<?php $_template = new Smarty_Internal_Template("admin/pripojene_soubory.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
