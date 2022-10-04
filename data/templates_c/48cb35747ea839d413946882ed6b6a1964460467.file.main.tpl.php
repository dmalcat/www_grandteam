<?php /* Smarty version Smarty-3.0.7, created on 2018-10-06 23:07:40
         compiled from "/data/www/grandteam.3n/templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12673641375bb9403ccc0149-07983247%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48cb35747ea839d413946882ed6b6a1964460467' => 
    array (
      0 => '/data/www/grandteam.3n/templates/main.tpl',
      1 => 1538867258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12673641375bb9403ccc0149-07983247',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/grandteam.3n/res/classes/smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="cs">
    <head>
        <?php $_template = new Smarty_Internal_Template("head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </head>
    <body>
        <?php $_template = new Smarty_Internal_Template("menu/menu_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <div class="clearfix"></div>
        <?php $_template = new Smarty_Internal_Template((($tmp = @$_smarty_tpl->getVariable('page_content')->value)===null||$tmp==='' ? 'homepage/homepage.tpl' : $tmp), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <div class="foot background-blue pt50">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row footer_menu">
                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(1,null,3)->sort("priority"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                                    <div class="col-md-15">
                                        <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
" class="text-white"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</a>
                                    </div>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="container">
                    <div class="pb15">
                        <div class="text-gray-light text-center">
                            <small>© <?php echo smarty_modifier_date_format(time(),"Y");?>
 <?php echo Registry::getDomainName();?>
 | realizace <a href="http://www.3nicom.cz" target="_blank" class="text-white">3Nicom websolutions s.r.o.</a> | <a href="http://www.getrun.cz" target="_blank" class="text-white">Getrun s.r.o.</a> </small>
                            <a href="http://www.getrun.cz"><img src="/images/LOGO-Getrun-w.png" alt="Getrun" height="40" class="pull-right" /></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $_template = new Smarty_Internal_Template("counter.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </body>
</html>


