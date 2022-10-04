<?php /* Smarty version Smarty-3.0.7, created on 2022-04-08 14:27:09
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/fotogalerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14808793262502a1d9a8831-60517778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f79e4ec47113f335bb4ffa28500014227698854' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/fotogalerie.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14808793262502a1d9a8831-60517778',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.date_format.php';
?><h1 class="clanek_title"><?php if ($_smarty_tpl->getVariable('dbGallery')->value){?>EDITACE FOTOGALERIE - <?php echo $_smarty_tpl->getVariable('dbGallery')->value->name;?>
<?php }else{ ?>NOVÁ FOTOGALERIE<?php }?> </h1>
<form method="post" id="nova_fotogalerie" enctype="multipart/form-data">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->name;?>
" class="validate[required]" id="nazev"/>
        </div>
        <div class="nazev_ft"> </div>
		<div class="clear"></div>
        <div class="text_1_bg">
        </div>
		<!--        <span class="label sipka">Prostý text</span>-->
		<!--        <div class="text_2_hd"></div>-->
		<!--        <div class="text_2_bg">-->
		<!--            <textarea name="descriptionPlain"><?php echo $_smarty_tpl->getVariable('dbGallery')->value->description;?>
</textarea>-->
		<!--        </div>-->
		<!--        <div class="cb"></div>-->
		<!--        <div class="text_2_ft"></div>-->
    </div>



    <div class="clanek_pravy_sloupec">
        <table class="datum_table" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
			<tr>
				<th>Datum</th>
				<th>Datum uveřejnění</th>
				<th>Datum stažení</th>
			</tr>
			<tr>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker1" name="datum" value="<?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->getVariable('dbGallery')->value->datum)===null||$tmp==='' ? time() : $tmp),'%d.%m.%Y');?>
"/>
					</div>
				</td>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker2" name="visible_from" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('dbGallery')->value->visible_from,'%d.%m.%Y');?>
"/>
					</div>
				</td>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker3" name="visible_to" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('dbGallery')->value->visible_to,'%d.%m.%Y');?>
"/>
					</div>
				</td>
			</tr>
        </table>

        <table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th style="text-align:left;padding-left:25px;">Anotační obrázek</th>
				<th style="text-align:left;padding-left:25px;">Struktura</th>
			</tr>
			<tr>
				<td>
					<div class="anotacni_obr">
						<a href="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->galleryImage;?>
" rel="shadowbox[trip]">
							<div class="anotacni_obr_image" style="background-image:url(<?php echo (($tmp = @$_smarty_tpl->getVariable('text')->value)===null||$tmp==='' ? '/images/admin/obr.png' : $tmp);?>
);">
								<?php if ($_smarty_tpl->getVariable('dbGallery')->value->galleryImage){?>
                                    <img src="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->galleryImage;?>
" style="max-width: 115px; max-height: 103px;"/>
                                <?php }?>
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
								<input type="file" name="image"/>
							</div>
						</div>
					</div>
				</td>
				<td>
					<select name="id_parent" id="">
						<option value="">--- vyberte ---</option>
						<?php  $_smarty_tpl->tpl_vars['dbGalleryTmp'] = new Smarty_Variable;
 $_from = dbGallery::getAll(dbGallery::TYPE_FOTO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbGalleryTmp']->key => $_smarty_tpl->tpl_vars['dbGalleryTmp']->value){
?>
							<?php if ($_smarty_tpl->getVariable('dbGallery')->value->id!=$_smarty_tpl->getVariable('dbGalleryTmp')->value->id){?><option value="<?php echo $_smarty_tpl->getVariable('dbGalleryTmp')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('dbGalleryTmp')->value->id==$_smarty_tpl->getVariable('dbGallery')->value->id_parent){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('dbGalleryTmp')->value->name;?>
</option><?php }?>
						<?php }} ?>
					</select>
				</td>
			</tr>
        </table>

    </div>


	<div style="clear: both;"><br/></div>
	<span class="label" style="margin-left: 80px;">Anotace galerie</span>
	<div style="text-align: center; " class="text_3">
		<textarea name="annotation" id="ckGalerieAnnotation" cols="30" rows="10" style=" height: 290px; margin-left: auto; margin-right: auto;" class="ckeditor" height="390"><?php echo (($tmp = @$_smarty_tpl->getVariable('dbGallery')->value->annotation)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
	</div>
	<span class="label" style="margin-left: 80px;">Text galerie</span>
	<div style="text-align: center" class="text_3">
		<textarea name="description" id="ckGalerieDescription" cols="30" rows="20" style="height: 390px; margin-left: auto; margin-right: auto;" class="ckeditor" height="390"><?php echo (($tmp = @$_smarty_tpl->getVariable('dbGallery')->value->description)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
	</div>



    <div class="submit_box">
		<input type="hidden" name="id_gallery_type" value="<?php echo dbGallery::TYPE_FOTO;?>
"/>
		<input type="hidden" name="id_gallery_template" value="<?php echo dbGallery::TYPE_FOTO;?>
"/>
		<?php if ($_smarty_tpl->getVariable('dbGallery')->value){?>
			<input type="submit" value="Upravit fotogalerii" name="doGalleryEdit" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat fotogalerii"  name="doGalleryDelete" class="smazat_tlac" onclick="return confirm('Opravdu smazat fotogalerii ?')"/>
		<?php }else{ ?>
			<input type="submit" value="Uložit a zavřít" name="doGalleryAdd" class="ulozit_upravy_tlac" />
			<input type="submit" value="Uložit a přidat obsah"  name="doGalleryAddEdit" class="ulozit_upravy_tlac" />
		<?php }?>

		<!--<input type="submit" value="Smazat fotogalerii" class="smazat_tlac pozice_pro_tri_tlacitka" />-->
    </div>

</form>