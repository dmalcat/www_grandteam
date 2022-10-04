<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:32
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/_accordion_item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13105506425bb94a48b66043-62796316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84543d13e16ddcaebf28a543ee23ede6eb5649d6' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/_accordion_item.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13105506425bb94a48b66043-62796316',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.date_format.php';
?><div style="clear: both;"></div>
<h3 class="bg" data-id="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
">
    <div class="ikona"><span class="<?php if (count(dbContentCategory::getById($_smarty_tpl->getVariable('item')->value->id)->getSubcategories())){?>ui-icon ui-icon-circle-plus<?php }else{ ?>ui-icon ui-icon-triangle-1-e<?php }?>"></span></div>
    <div class="nazev">
        <a href="/admin/<?php if ($_smarty_tpl->getVariable('item')->value->menu==dbContentCategory::TYPE_MENU){?>menu<?php }else{ ?>clanek<?php }?>/<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" title="<?php echo $_smarty_tpl->getVariable('item')->value->name;?>
" class="nazev_a"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('item')->value->name,'24');?>
</a>
    </div>
    <div class="poradi">
        <a href="#" title="Posunout článek dolů" class="sipka_dolu" data-id="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" data-parent="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value->id_parent)===null||$tmp==='' ? 0 : $tmp);?>
"></a>
        <a href="#" title="Posunout článek nahoru" class="sipka_nahoru" data-id="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" data-parent="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value->id_parent)===null||$tmp==='' ? 0 : $tmp);?>
"></a>
    </div>
    <div class="typ"> 
        <div id="uniform-undefined" class="selector focus">
            <span style="-moz-user-select: none;"><?php if ($_smarty_tpl->getVariable('item')->value->menu==1){?>položka menu<?php }else{ ?>článek<?php }?></span>
            <select name="contentCategoryType" class="contentCategoryType" style="width: 80px;" rel="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
">
                <option value="0" <?php if ($_smarty_tpl->getVariable('item')->value->menu==0){?>selected="selected"<?php }?>>článek</option>
                <option value="1" <?php if ($_smarty_tpl->getVariable('item')->value->menu==1){?>selected="selected"<?php }?>>položka menu</option>
            </select>
        </div>
    </div>
    <div class="zobrazit">
        <div id="uniform-undefined" class="checker">
            <span class="<?php if ($_smarty_tpl->getVariable('item')->value->visible){?>checked<?php }?>">
                <input type="checkbox" name="visible" <?php if ($_smarty_tpl->getVariable('item')->value->visible){?>checked="checked"<?php }?> onclick="setContentVisibility(this, <?php echo $_smarty_tpl->getVariable('item')->value->id;?>
)" />
            </span>
        </div>
    </div>
    <div class="zobrazit_hp">
        <div id="uniform-undefined" class="checker">
            <span class="<?php if ($_smarty_tpl->getVariable('item')->value->homepage){?>checked<?php }?>">
                <input type="checkbox" name="homepage" <?php if ($_smarty_tpl->getVariable('item')->value->homepage){?>checked="checked"<?php }?> onclick="setContentCategoryHP(this, <?php echo $_smarty_tpl->getVariable('item')->value->id;?>
)"  />
            </span>
        </div>
    </div>
    <div class="aktuality">
        <div id="uniform-undefined" class="checker">
            <span class="<?php if ($_smarty_tpl->getVariable('item')->value->aktuality){?>checked<?php }?>">
                <input type="checkbox" name="aktuality" <?php if ($_smarty_tpl->getVariable('item')->value->aktuality){?>checked="checked"<?php }?>  onclick="setContentCategoryAktuality(this, <?php echo $_smarty_tpl->getVariable('item')->value->id;?>
)"  />
            </span>
        </div>
    </div>
    <div class="upravit">
        <?php if ($_smarty_tpl->getVariable('item')->value->menu!=1){?>
            <div id="uniform-undefined" class="checker">
                <span class="<?php if ($_smarty_tpl->getVariable('item')->value->zajimavosti){?>checked<?php }?>">
                    <input type="checkbox" name="zajimavosti" <?php if ($_smarty_tpl->getVariable('item')->value->zajimavosti){?>checked="checked"<?php }?>  onclick="setContentCategoryZajimavosti(this, <?php echo $_smarty_tpl->getVariable('item')->value->id;?>
)"  />
                </span>
            </div>
        <?php }?>
    </div>
    <div class="pridat_clanek"><a href="/admin/clanek//?parent=<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" title="Přidat článek"></a></div>
    <div class="smazat"><a href="javascript: void(0)" class="contentCategoryDelete" rel="<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" title="Smazat článek" alt="<?php echo $_smarty_tpl->getVariable('item')->value->name;?>
"></a></div>
    <div class="datum"><?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->getVariable('item')->value->datum)===null||$tmp==='' ? time() : $tmp),"%d.%m.%Y");?>
</div>
    <div class="cb"></div>
</h3>

