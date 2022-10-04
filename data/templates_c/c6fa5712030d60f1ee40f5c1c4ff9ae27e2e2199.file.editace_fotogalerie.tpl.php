<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 02:21:16
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/editace_fotogalerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3180199965bb9517c6cde66-93055427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c6fa5712030d60f1ee40f5c1c4ff9ae27e2e2199' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/editace_fotogalerie.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3180199965bb9517c6cde66-93055427',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/function.cycle.php';
?><h1 class="clanek_title">OBSAH FOTOGALERIE / EDITACE FOTOGALERIE -  [ odkaz: <?php echo $_smarty_tpl->getVariable('dbGallery')->value->getUrl();?>
 ]</h1>
<div class="galerie_levy_sloupec">
    <span class="label">Fotky v galerii</span>
    <div class="galerie_bg">
        <div class="galerie_bg_popis">
            <div class="galerie_bg_popis1">Pořadí</div>
            <div class="galerie_bg_popis2">Zobrazit</div>
            <!--  <div class="galerie_bg_popis3">Upravit</div> -->
            <div class="galerie_bg_popis4">Smazat</div>
        </div>
        <div id="mcs_container">
            <div class="customScrollBox">
                <div class="container">
                    <div class="content">
                        <?php  $_smarty_tpl->tpl_vars['dbGalleryImage'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbGallery')->value->getImages(false); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbGalleryImage']->key => $_smarty_tpl->tpl_vars['dbGalleryImage']->value){
?>
                            <div class="foto_box" style="background-color:<?php echo smarty_function_cycle(array('values'=>"#EBEBEB,#fff"),$_smarty_tpl);?>
" id="galleryImage_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
">
                                <div class="foto_poradi">
                                    <input id="imagePriority_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" type="text" name="priority" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->priority;?>
" style="width: 20px; margin-left: 10px;" class="imagePriority uniform"  rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"/>
                                </div>
                                <div class="foto_obr">
                                    <a href="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->dImage;?>
" rel="shadowbox[]">
                                        <img src="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->tImage;?>
" alt=" " border="0" />
                                    </a>
                                </div>
                                <div class="foto_text">
                                    <div class="foto_nazev"><input type="text" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->name;?>
" class="imageName uniform" rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" id="imageName_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"/></div>
                                    <div class="foto_popis"><textarea name="fotoDescription" class="imageDescription uniform" rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" id="imageDescription_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->description;?>
</textarea></div>
                                </div>
                                <div class="foto_data">
                                    <div class="foto_zobrazit"><input type="checkbox"  id="imageVisible_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" class="imageVisible" <?php if ($_smarty_tpl->getVariable('dbGalleryImage')->value->visible){?>checked="checked"<?php }?> rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" /></div>
                                    <!--  <div class="foto_upravit"><a href="/" title="Upravit fotku"></a></div> -->

                                    <div class="foto_smazat"><a href="javascript: void(0)" title="Smazat fotografii" id="imageDelete_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" class="imageDelete"  rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"></a></div>


                                    <form action="" method="post" enctype="multipart/form-data" id="galleryImageForm_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
">
                                        <div class="foto_vymena">
                                            <input type="file" name="image" class="galleryImageFileInput" rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"/>
                                            <input type="hidden" name="image[name]" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->name;?>
"/>
                                            <input type="hidden" name="idImage" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"/>
                                        </div>
                                        <div class="odkaz_bg">
                                            <input type="text" name="url" class="imageUrl" id="imageUrl_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" placeholder="odkaz fotografie ..."   rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->url;?>
"/>
                                        </div>
                                        <div class="autor_bg">
                                            <input type="text" name="author" class="imageAuthor" id="imageAuthor_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" placeholder="autor fotografie ..."   rel="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
" value="<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->author;?>
"/>
                                        </div>
                                        <!--
                                                                                  <div class="foto_spec_data">Speciální data:</div>
                                                                                <div class="typ_foto">
                                                                                        <select>
                                                                                                <option value="">Typ foto: reference</option>
                                                                                                <option value="">Typ foto: mapa</option>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="gps_bg">
                                                                                        <input type="text" name=""/>
                                                                                </div>
                                        -->
<!--										<input type="submit" value="Upravit fotografii" class="submit_upravit_foto" id="galleryImageSubmit_<?php echo $_smarty_tpl->getVariable('dbGalleryImage')->value->id;?>
"/>-->
                                    </form>
                                </div>
                            </div>
                        <?php }} ?>
                    </div>
                </div>
                <div class="dragger_container">
                    <div class="dragger"></div>
                </div>
            </div>
            <a href="#" class="scrollUpBtn"></a> <a href="#" class="scrollDownBtn"></a>
        </div>
    </div>
</div>


<div class="galerie_pravy_sloupec">
    <!--<a href="javascript:void(0)" title="Vložit foto z počítače" class="upload_foto_tlac">Vložit foto z počítače</a>-->
    <div id="text" style="display:none;margin-top:18px;">
        <input type="hidden" name="type" value="file"/>
        <input id="file_upload" type="file" name="file_upload" rel="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
"/>
    </div>


</div>

<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>
