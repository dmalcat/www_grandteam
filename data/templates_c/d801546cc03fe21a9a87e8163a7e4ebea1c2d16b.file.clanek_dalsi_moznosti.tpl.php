<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:37
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/clanek_dalsi_moznosti.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14991805255bb94a4d5c0565-34092450%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd801546cc03fe21a9a87e8163a7e4ebea1c2d16b' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/clanek_dalsi_moznosti.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14991805255bb94a4d5c0565-34092450',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="dalsi_moznosti_title ui-accordion-header">
    <span class="ui-icon ui-icon-circle-plus"></span>
    DALŠÍ MOŽNOSTI
</div>
<div class="dalsi_moznosti_box">
    <div class="Xclanek_levy_sloupec">
        <span class="label">Anotační text</span>
        <div class="text_3">
            <textarea name="text_1" id="" cols="30" rows="20" style="width: 800px; height: 390px;font-size:15px;line-height:20px;" class="ckeditor" height="390"><?php echo $_smarty_tpl->getVariable('content')->value->text_1;?>
</textarea>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="clanek_pravy_sloupec">
        <table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th>Obrázek 1</th>
                <th>Obrázek 2</th>
                <th>Obrázek 3</th>
                <th>Obrázek 4</th>
                <th style="text-align:left;padding-left:31px;">Soubor 1</th>
                <th style="text-align:left;padding-left:31px;">Soubor 2</th>
            </tr>
            <tr>
                <td>
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_1'];?>
" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_1" class="anotacni_obr_image" style="background-image:url(<?php if ($_smarty_tpl->getVariable('dbCC')->value->image_1){?><?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_1'];?>
<?php }else{ ?>/images/admin/obr.png<?php }?>);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_1" onclick="anotacniObrazekDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 1)"></a>
                        <div id="div_upload_foto_1" class="ui-datepicker" style="z-index: 1000;">
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
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_2'];?>
" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_2" class="anotacni_obr_image" style="background-image:url(<?php if ($_smarty_tpl->getVariable('dbCC')->value->image_2){?><?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_2'];?>
<?php }else{ ?>/images/admin/obr.png<?php }?>);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_2"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_2" onclick="anotacniObrazekDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 2)"></a>
                        <div id="div_upload_foto_2" class="ui-datepicker" style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát foto</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_2').hide();">
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
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_3'];?>
" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_3" class="anotacni_obr_image" style="background-image:url(<?php if ($_smarty_tpl->getVariable('dbCC')->value->image_3){?><?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_3'];?>
<?php }else{ ?>/images/admin/obr.png<?php }?>);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_3"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_3" onclick="anotacniObrazekDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 3)"></a>
                        <div id="div_upload_foto_3" class="ui-datepicker" style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát foto</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_3').hide();">
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
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_4'];?>
" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_4" class="anotacni_obr_image" style="background-image:url(<?php if ($_smarty_tpl->getVariable('dbCC')->value->image_4){?><?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES_PATH;?>
<?php echo $_smarty_tpl->getVariable('pContentCategory')->value->content->IMAGES['image_4'];?>
<?php }else{ ?>/images/admin/obr.png<?php }?>);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_4"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_4" onclick="anotacniObrazekDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 4)"></a>
                        <div id="div_upload_foto_4" class="ui-datepicker" style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát foto</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_4').hide();">
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
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('dbCC')->value->file1->original;?>
">
                            <div id="anotacniSoubor_1"  class="anotacni_obr_image" style="background-image:url(/images/icons/<?php echo $_smarty_tpl->getVariable('dbCC')->value->file1->fileInfo->big_icon_url;?>
);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat soubor" class="anotacni_obr_pridat" id="upload_foto_5"></a>
                        <a href="javascript:void(0)" title="Smazat soubor" class="anotacni_obr_smazat" id="delete_foto_5" onclick="anotacniSouborDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 1)"></a>
                        <div id="div_upload_foto_5" class="ui-datepicker"  style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát Soubor</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_2').hide();">
                                    <span class="ui-icon ui-icon-closethick"></span>
                                </a>
                            </div>
                            <div style="width:250px;margin-top:10px;margin-left:5px;">
                                <input type="file" name="content_category_file[]"/>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="anotacni_obr">
                        <a href="<?php echo $_smarty_tpl->getVariable('dbCC')->value->file2->original;?>
">
                            <div id="anotacniSoubor_2"  class="anotacni_obr_image" style="background-image:url(/images/icons/<?php echo $_smarty_tpl->getVariable('dbCC')->value->file2->fileInfo->big_icon_url;?>
);"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat soubor" class="anotacni_obr_pridat" id="upload_foto_6"></a>
                        <a href="javascript:void(0)" title="Smazat soubor" class="anotacni_obr_smazat" id="delete_foto_6" onclick="anotacniSouborDelete(<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
, 2)"></a>
                        <div id="div_upload_foto_6" class="ui-datepicker"  style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát Soubor</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_3').hide();">
                                    <span class="ui-icon ui-icon-closethick"></span>
                                </a>
                            </div>
                            <div style="width:250px;margin-top:10px;margin-left:5px;">
                                <input type="file" name="content_category_file[]"/>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>


</form>

<?php $_template = new Smarty_Internal_Template("admin/pripojene_fotogalerie.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("admin/pripojene_soubory.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>