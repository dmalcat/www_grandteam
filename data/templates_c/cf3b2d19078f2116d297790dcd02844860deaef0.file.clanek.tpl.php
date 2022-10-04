<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:37
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/clanek.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2026167475bb94a4d534de9-80971371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf3b2d19078f2116d297790dcd02844860deaef0' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/clanek.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2026167475bb94a4d534de9-80971371',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.date_format.php';
?><?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->getVariable('pContentCategory')->value->content, null, null);?>
<h1 class="clanek_title"><?php if (!$_smarty_tpl->getVariable('dbCC')->value){?>NOVÝ ČLÁNEK<?php }else{ ?>EDITACE ČLÁNKU - <?php echo $_smarty_tpl->getVariable('content')->value->title_1;?>
 : náhled <a href="<?php echo $_smarty_tpl->getVariable('dbCC')->value->getUrl();?>
" target="_blank">zde</a> &nbsp;&nbsp;&nbsp;[odkaz: <?php echo $_smarty_tpl->getVariable('dbCC')->value->getUrl();?>
]<?php }?></h1>
<form method="post" id="novy_clanek" enctype="multipart/form-data">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="nazev" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->name;?>
" class="validate[required]" id="nazev" autofocus=""/>
        </div>
        <div class="nazev_ft"></div>
        <span class="label">Externí odkaz</span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="external_url" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->external_url;?>
" class="" id="externi_url" placeholder="odkaz na jinou stranku ..."/>
        </div>
        <div class="cb"></div>
        <div class="nazev_ft"></div>

        <?php if ($_smarty_tpl->getVariable('idContentType')->value==7){?>
            <span class="label">Cena</span>
            <div class="nazev_hd"></div>
            <div class="nazev_bg">
                <input type="text" name="price" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->price;?>
" class="" id="cena" placeholder="Cena ..."/>
            </div>
            <div class="cb"></div>
            <div class="nazev_ft"></div>

            <span class="label">Lokalita</span>
            <div class="nazev_hd"></div>
            <div class="nazev_bg">
                <input type="text" name="locality" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->locality;?>
" class="" id="lokalita" placeholder="Lokalita ..."/>
            </div>
            <div class="cb"></div>
            <div class="nazev_ft"></div>
        <?php }?>

    </div>

    <div class="clanek_pravy_sloupec">
        <table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0">
            <?php if (!$_smarty_tpl->getVariable('dbCC')->value->id_content_type||true){?>
            <?php if ($_GET['parent']){?><?php $_smarty_tpl->tpl_vars['parentIdContentType'] = new Smarty_variable(dbContentCategory::getById($_GET['parent'])->id_content_type, null, null);?><?php }?>
            <tr>
                <td>ZAŘAZENÍ V MENU</td>
                <td style="padding-left:35px;">
                    <select name="id_content_type">
                        <?php  $_smarty_tpl->tpl_vars['pContentType'] = new Smarty_Variable;
 $_from = dbContentType::getAll(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pContentType']->key => $_smarty_tpl->tpl_vars['pContentType']->value){
?>
                            <option value="<?php echo $_smarty_tpl->getVariable('pContentType')->value->id_content_type;?>
" <?php if ($_smarty_tpl->getVariable('pContentType')->value->id_content_type==(($tmp = @(($tmp = @$_smarty_tpl->getVariable('idContentType')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('parentIdContentType')->value : $tmp))===null||$tmp==='' ? Content_3n::DEFAULT_ID_CONTENT_TYPE : $tmp)){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('pContentType')->value->name;?>
</option>
                        <?php }} ?>
                    </select>
                </td>
            </tr>
            <tr>
            <?php }else{ ?>
            <tr><td></td><td></td></tr>
        <?php }?>
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
                    <?php }} ?>
                </select>
            </td>
        </tr>
    </table>

    <table class="datum_table" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th>Datum</th>
            <th>Datum uveřejnění</th>
            <th>Datum stažení</th>
        </tr>
        <tr>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker1" name="datum" value="<?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->getVariable('pContentCategory')->value->content_category->datum)===null||$tmp==='' ? time() : $tmp),'%d.%m.%Y');?>
"/>
                </div>
            </td>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker2" name="visible_from" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('pContentCategory')->value->content_category->visible_from,'%d.%m.%Y');?>
"/>
                </div>
            </td>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker3" name="visible_to" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('pContentCategory')->value->content_category->visible_to,'%d.%m.%Y');?>
"/>
                </div>
            </td>
        </tr>
    </table>



</div>



<span class="label popis_text_hlavni">Vlastní text</span>
<div class="text_3">
    <textarea name="text_2" id="" cols="30" rows="20" style="width: 800px; height: 390px;font-size:15px;line-height:20px;" class="ckeditor" height="390"><?php echo $_smarty_tpl->getVariable('content')->value->text_2;?>
</textarea>
</div>

<div class="submit_box" style="bottom:20px;left:0px;position:absolute;">
    <?php if ($_smarty_tpl->getVariable('pContentCategory')->value){?>
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
"/>
        <input type="hidden" name="id_content" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->getContent()->id;?>
"/>
        <input type="hidden" name="visible" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->visible;?>
"/>
        <input type="hidden" name="menu" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->menu;?>
"/>
        <input type="hidden" name="priority" value="<?php echo $_smarty_tpl->getVariable('dbCC')->value->priority;?>
"/>
        <input type="submit" value="Uložit úpravy" name="do_clanek" class="ulozit_upravy_tlac" />
        <input type="submit" value="Smazat článek" class="smazat_tlac contentCategoryDelete" rel="<?php echo $_smarty_tpl->getVariable('dbCC')->value->id;?>
" title="Smazat článek" alt="<?php echo $_smarty_tpl->getVariable('dbCC')->value->name;?>
"/>
    <?php }else{ ?>
        <input type="hidden" name="menu" value="<?php echo dbContentCategory::TYPE_CLANEK;?>
"/>
        <input type="submit" value="Vložit článek" name="do_clanek" class="ulozit_upravy_tlac pozice_uprostred" />
    <?php }?>

</div>

<?php if ($_smarty_tpl->getVariable('dbCC')->value||true){?>
    <?php $_template = new Smarty_Internal_Template('admin/clanek_dalsi_moznosti.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php }?>


<?php if (!$_smarty_tpl->getVariable('dbCC')->value){?>
</form>
<?php }?>