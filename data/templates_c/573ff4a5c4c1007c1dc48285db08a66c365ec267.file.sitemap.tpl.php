<?php /* Smarty version Smarty-3.0.7, created on 2022-04-15 13:21:13
         compiled from "/data/www/grandteam.cz/public_html/templates/sitemap/sitemap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5083335362595529b2cec2-74742164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '573ff4a5c4c1007c1dc48285db08a66c365ec267' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/sitemap/sitemap.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5083335362595529b2cec2-74742164',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_translate')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.translate.php';
?><div class="content_bg">

    <div class="content">
        <h1 class="content_title"><?php echo smarty_modifier_translate('Mapa stránek');?>
</h1>
        <div class="content_drobisky">
        </div>
        <div class="content_text2">
            <div class="mapa_stranek_kategorie"><?php echo smarty_modifier_translate('Hlavní menu');?>
</div>
            <ul class="mapa_stranek_ul">
            	<?php  $_smarty_tpl->tpl_vars['dbContentCategory'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(1,null,3); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategory']->key => $_smarty_tpl->tpl_vars['dbContentCategory']->value){
?>
            		<li>
                        <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategory')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategory')->value->name);?>
</a>
                        <?php if (count($_smarty_tpl->getVariable('dbContentCategory')->value->getSubCategories())){?>
                            <ul>
                              <?php  $_smarty_tpl->tpl_vars['dbContentCategorySub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategory')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySub']->value){
?>
                                  <li>
                                      <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySub')->value->name);?>
</a>
                                      <?php if (count($_smarty_tpl->getVariable('dbContentCategorySub')->value->getSubCategories())){?>
                                          <ul>
                                            <?php  $_smarty_tpl->tpl_vars['dbContentCategorySubSub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategorySub')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySubSub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySubSub']->value){
?>
                                                <li>
                                                    <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->name);?>
</a>
                                                    <?php if (count($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getSubCategories())){?>
                                						<ul>
                                						<?php  $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub']->value){
?>
                                                            <li>
                                                                <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->name);?>
</a>
                                                            </li>
                                						<?php }} ?>
                                						</ul>
                                					<?php }?>
                                                </li>
                                            <?php }} ?>
                                          </ul>
                              		  <?php }?>
                              	</li>
                              <?php }} ?>
                            </ul>
                      <?php }?>
                    </li>
            	<?php }} ?>
            </ul>
            <div class="mapa_stranek_kategorie"><?php echo smarty_modifier_translate('Úřední deska');?>
</div>
            <ul class="mapa_stranek_ul">
            	<?php  $_smarty_tpl->tpl_vars['dbContentCategory'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(1,null,6); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategory']->key => $_smarty_tpl->tpl_vars['dbContentCategory']->value){
?>
            		<li>
                        <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategory')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategory')->value->name);?>
</a>
                        <?php if (count($_smarty_tpl->getVariable('dbContentCategory')->value->getSubCategories())){?>
                            <ul>
                              <?php  $_smarty_tpl->tpl_vars['dbContentCategorySub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategory')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySub']->value){
?>
                                  <li>
                                      <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySub')->value->name);?>
</a>
                                      <?php if (count($_smarty_tpl->getVariable('dbContentCategorySub')->value->getSubCategories())){?>
                                          <ul>
                                            <?php  $_smarty_tpl->tpl_vars['dbContentCategorySubSub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategorySub')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySubSub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySubSub']->value){
?>
                                                <li>
                                                    <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->name);?>
</a>
                                                    <?php if (count($_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getSubCategories())){?>
                                						<ul>
                                						<?php  $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbContentCategorySubSub')->value->getSubCategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub']->key => $_smarty_tpl->tpl_vars['dbContentCategorySubSubSub']->value){
?>
                                                            <li>
                                                                <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategorySubSubSub')->value->name);?>
</a>
                                                            </li>
                                						<?php }} ?>
                                						</ul>
                                					<?php }?>
                                                </li>
                                            <?php }} ?>
                                          </ul>
                              		  <?php }?>
                              	</li>
                              <?php }} ?>
                            </ul>
                      <?php }?>
                    </li>
            	<?php }} ?>
            </ul>
            <div class="mapa_stranek_kategorie"><?php echo smarty_modifier_translate('Kalendář akcí');?>
</div>
            <ul class="mapa_stranek_ul">
            	<?php  $_smarty_tpl->tpl_vars['dbContentCategory'] = new Smarty_Variable;
 $_from = dbCalendar::getActual(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategory']->key => $_smarty_tpl->tpl_vars['dbContentCategory']->value){
?>
            		<li>
                        <a href="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->getUrl();?>
" class="<?php if ($_smarty_tpl->getVariable('dbContentCategory')->value->target){?>ext<?php }?>" target="<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->target;?>
"><?php echo smarty_modifier_translate($_smarty_tpl->getVariable('dbContentCategory')->value->name);?>
</a>
                    </li>
            	<?php }} ?>
            </ul>
        </div>
    </div>

    <?php $_template = new Smarty_Internal_Template("boxes/nejnovejsi_z_kategorie.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

</div>

<?php $_template = new Smarty_Internal_Template("boxes/zajimavosti.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

