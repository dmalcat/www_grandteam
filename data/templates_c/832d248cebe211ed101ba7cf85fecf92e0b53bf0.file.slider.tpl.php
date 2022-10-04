<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:12:17
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/boxes/slider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9150431845bb941513552c6-84392489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '832d248cebe211ed101ba7cf85fecf92e0b53bf0' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/boxes/slider.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9150431845bb941513552c6-84392489',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_if')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.if.php';
if (!is_callable('smarty_modifier_date_format')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.date_format.php';
?><div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbGallery::getById(1)->getImages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['item']->index++;
 $_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['forSlider']['first'] = $_smarty_tpl->tpl_vars['item']->first;
?>
            <li data-target="#myCarousel" data-slide-to="0" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['forSlider']['first']){?>class="active"<?php }?>>
            </li>
        <?php }} ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbGallery::getById(1)->getImages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['item']->index++;
 $_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['forSlider']['first'] = $_smarty_tpl->tpl_vars['item']->first;
?>
            <div class="item <?php echo smarty_modifier_if($_smarty_tpl->getVariable('smarty')->value['foreach']['forSlider']['first'],'active','');?>
">
                <img src="<?php echo $_smarty_tpl->getVariable('item')->value->oImage;?>
" alt="<?php echo $_smarty_tpl->getVariable('item')->value->name;?>
" class="img-full">
                <div class="carousel-caption">
                    <small class="text-white"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('item')->value->datum,'%d.%m.%Y');?>
</small>
                </div>
            </div>
        <?php }} ?>




    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>