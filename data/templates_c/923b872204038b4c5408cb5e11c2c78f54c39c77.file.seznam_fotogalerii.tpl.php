<?php /* Smarty version Smarty-3.0.7, created on 2022-04-08 14:26:59
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/seznam_fotogalerii.tpl" */ ?>
<?php /*%%SmartyHeaderCode:45638062962502a134b7c03-57525269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '923b872204038b4c5408cb5e11c2c78f54c39c77' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/seznam_fotogalerii.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45638062962502a134b7c03-57525269',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.date_format.php';
?><div id="accordion_gallery">
    <?php  $_smarty_tpl->tpl_vars['dbGallery'] = new Smarty_Variable;
 $_from = dbGallery::getAll(dbGallery::TYPE_FOTO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbGallery']->key => $_smarty_tpl->tpl_vars['dbGallery']->value){
?>
        <h3 class="bg" data-id="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
">
            <div class="seznam_bg" id="galleryList_<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
">
                <div class="seznam_nazev">
                    <a href="/admin/editace_fotogalerie/<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
" class="no_acc" style="display: inline; color: white;"><?php echo $_smarty_tpl->getVariable('dbGallery')->value->name;?>
 (<?php echo count($_smarty_tpl->getVariable('dbGallery')->value->getImages());?>
)</a>
                </div>
                <div class="seznam_zobrazit">
                    <input type="checkbox" <?php if ($_smarty_tpl->getVariable('dbGallery')->value->visible){?>checked="checked"<?php }?>  onclick="setGalleryVisibility(this, <?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
)"/>
                </div>
                <div class="seznam_upravit_galerii">
                    <a href="/admin/editace_fotogalerie/<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
" title="Upravit obsah fotogalerii" class="no_acc"></a>
                </div>
                <div class="seznam_upravit">
                    <a href="/admin/fotogalerie/<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
" title="Upravit fotogalerii" class="no_acc"></a>
                </div>

                <div class="seznam_smazat">
                    <a href="javascript: void(0)" title="Smazat fotogalerii" rel="<?php echo $_smarty_tpl->getVariable('dbGallery')->value->id;?>
" class="galleryDelete" class="no_acc"></a>
                </div>
                <div class="seznam_datum"><?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->getVariable('sub_dbGallery')->value->datum)===null||$tmp==='' ? time() : $tmp),"%d.%m.%Y");?>
</div>
            </div>
        </h3>


    <?php }} ?>
</div>
<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>
