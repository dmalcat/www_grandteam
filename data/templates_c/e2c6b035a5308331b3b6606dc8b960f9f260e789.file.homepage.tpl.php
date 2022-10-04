<?php /* Smarty version Smarty-3.0.7, created on 2018-10-06 23:03:05
         compiled from "/data/www/grandteam.3n/templates/homepage/homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20566004565bb93f29cf16b5-11887570%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2c6b035a5308331b3b6606dc8b960f9f260e789' => 
    array (
      0 => '/data/www/grandteam.3n/templates/homepage/homepage.tpl',
      1 => 1538866985,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20566004565bb93f29cf16b5-11887570',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("boxes/slider.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="container-fluid">
    <div class="row background-blue">
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-white text-center mt15 mb15 text-bolder">Naše služby</h2>
            </div>
            <div class="homepage">
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getHomepage(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                    <div class="col-md-3 item">
                        <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
">
                            <div class="wrap" style="background-image: url(<?php echo $_smarty_tpl->getVariable('item')->value->getImage(1)->src;?>
);">
                                <h2><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</h2>
                                <div class="content">
                                    <?php echo $_smarty_tpl->getVariable('item')->value->getContent()->text_1;?>

                                    <div class="clearfix"></div>
                                    <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
" class="btn btn_transparent mt15">Vstoupit</a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php }} ?>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>



<div class="container-fluid">
    <div class="row aktuality background-white">
        <div class="container pb30">
            <div class="col-md-12">
                <h2 class="text-black text-center mt15 mb15 text-bolder">Aktuality</h2>
            </div>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getAll(1,null,6)->sort("priority"); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                <div class="col-md-4 item">
                    <?php $_template = new Smarty_Internal_Template("boxes/list_item.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </div>
            <?php }} ?>
        </div>
    </div>
</div>