<?php /* Smarty version Smarty-3.0.7, created on 2018-10-06 23:05:26
         compiled from "/data/www/grandteam.3n/templates/menu/menu_top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9670426055bb93fb604ef29-96896533%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86c6089939f76d36ed1a8f7730d8ca762c85f766' => 
    array (
      0 => '/data/www/grandteam.3n/templates/menu/menu_top.tpl',
      1 => 1538867125,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9670426055bb93fb604ef29-96896533',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="menu_top">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/images/logo.jpg" alt="<?php echo Registry::getDomain();?>
"/></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav navbar-right">
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(1,null,1)->sort("priority"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                        <?php if (count($_smarty_tpl->getVariable('item')->value->getSubcategories())){?>
                            <li class="dropdown <?php if ($_smarty_tpl->getVariable('item')->value->selected){?>active<?php }?>">
                                <a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('item')->value->getSubcategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value){
?>
                                        <li>
                                            <a href="<?php echo $_smarty_tpl->getVariable('item2')->value->getUrl();?>
"><?php echo $_smarty_tpl->getVariable('item2')->value->name;?>
</a>
                                        </li>
                                    <?php }} ?>
                                </ul>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
" class="text-uppercase"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                </ul>
            </div>
        </div>
    </nav>
</div>