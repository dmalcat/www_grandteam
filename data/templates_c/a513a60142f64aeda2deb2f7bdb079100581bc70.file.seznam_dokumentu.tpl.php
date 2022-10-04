<?php /* Smarty version Smarty-3.0.7, created on 2022-04-08 14:27:12
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/seznam_dokumentu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:203328882162502a207980d8-23192973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a513a60142f64aeda2deb2f7bdb079100581bc70' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/seznam_dokumentu.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203328882162502a207980d8-23192973',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.date_format.php';
?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbGallery::getAll(dbGallery::TYPE_FILES); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
    <div class="seznam_bg" id="galleryList_<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
">
        <div class="seznam_nazev">
            <a href="/admin/editace_dokumentu/<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</a>
        </div>
        <div class="seznam_zobrazit">
            <input type="checkbox" <?php if ($_smarty_tpl->getVariable('item')->value->visible){?>checked="checked"<?php }?>  onclick="setGalleryVisibility(this, <?php echo $_smarty_tpl->getVariable('item')->value->id;?>
)"/>
        </div>
        <div class="seznam_upravit_galerii">
            <a href="/admin/editace_dokumentu/<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" title="Upravit obsah fotogalerii"></a>
        </div>
        <div class="seznam_upravit">
            <a href="/admin/dokumenty/<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" title="Upravit fotogalerii"></a>
        </div>

        <div class="seznam_smazat">
            <a href="javascript: void(0)" title="Smazat fotogalerii" rel="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" class="galleryDelete"></a>
        </div>
        <div class="seznam_datum"><?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->getVariable('sub_item')->value->datum)===null||$tmp==='' ? time() : $tmp),"%d.%m.%Y");?>
</div>
    </div>
<?php }} ?>
<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>