<?php /* Smarty version Smarty-3.0.7, created on 2022-04-08 14:27:17
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/dokumenty.tpl" */ ?>
<?php /*%%SmartyHeaderCode:76535586862502a25a7d476-12711881%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5ddd6b288a8e1130831c422e5137e125cf88354' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/dokumenty.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '76535586862502a25a7d476-12711881',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_fckeditor')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/function.fckeditor.php';
if (!is_callable('smarty_modifier_date_format')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.date_format.php';
?><h1 class="clanek_title"><?php if ($_smarty_tpl->getVariable('dbGallery')->value){?>EDITACE DOKUMENTŮ - <?php echo $_smarty_tpl->getVariable('dbGallery')->value->name;?>
<?php }else{ ?>NOVÉ DOKUMENTY<?php }?></h1>
<form method="post" id="nove_dokumenty" enctype="multipart/form-data">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->name;?>
" class="validate[required]" id="nazev"/>
        </div>
        <div class="nazev_ft"></div>

        <span class="label">Popis galerie</span>
        <div class="text_1_hd"></div>
        <div class="text_1_bg">
            <?php echo smarty_function_fckeditor(array('BasePath'=>"/fckeditor/",'InstanceName'=>"description",'Value'=>(($tmp = @$_smarty_tpl->getVariable('dbGallery')->value->description)===null||$tmp==='' ? '' : $tmp),'Width'=>"505",'Height'=>"110px",'ToolbarSet'=>"Basic"),$_smarty_tpl);?>

        </div>
        <div class="text_1_ft"></div>
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
			</tr>
        </table>
    </div>


    <div class="submit_box">
		<input type="hidden" name="id_gallery_type" value="<?php echo dbGallery::TYPE_FILES;?>
"/>
		<input type="hidden" name="id_gallery_template" value="<?php echo dbGallery::TYPE_FILES;?>
"/>
		<?php if ($_smarty_tpl->getVariable('dbGallery')->value){?>
			<input type="submit" value="Upravit fotogalerii" name="doGalleryEdit" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat fotogalerii"  name="doGalleryDelete" class="smazat_tlac" onclick="return confirm('Opravdu smazat fotogalerii ?')"/>
		<?php }else{ ?>
			<input type="submit" value="Uložit a zavřít" name="doGalleryAdd" class="ulozit_upravy_tlac" />
			<input type="submit" value="Uložit a přidat obsah"  name="doGalleryAddEdit" class="ulozit_upravy_tlac" />
		<?php }?>
		  <!--  <input type="submit" value="Smazat dokumenty" class="smazat_tlac pozice_pro_tri_tlacitka" /> -->
    </div>

</form>