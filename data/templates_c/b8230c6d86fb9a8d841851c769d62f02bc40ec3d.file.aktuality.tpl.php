<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 07:20:56
         compiled from "/data/www/grandteam.cz/public_html/templates/pages/aktuality.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13994638845c3592c8590cf8-70597274%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8230c6d86fb9a8d841851c769d62f02bc40ec3d' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/pages/aktuality.tpl',
      1 => 1542222900,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13994638845c3592c8590cf8-70597274',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="container-fluid">
    <div class="container pb40">
        <div class="row">
            <div class="homepage aktuality">
                <div class="col-md-12">
                    <h2 class="text-white text-center mt15 mb15 text-bolder">Aktuality</h2>
                </div>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getNews(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                    <div class="col-md-4 col-xs-6 item">
                        <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
">
                            <div class="wrap" style="background-image: url(<?php echo $_smarty_tpl->getVariable('item')->value->getImage(1,null,true)->src;?>
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
            </div>
        </div>
    </div>
</div>