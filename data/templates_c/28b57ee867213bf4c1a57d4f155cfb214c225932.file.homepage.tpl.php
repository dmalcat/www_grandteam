<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 06:27:33
         compiled from "/data/www/grandteam.cz/public_html/templates/homepage/homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8434894975c35864515d4f4-93180426%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28b57ee867213bf4c1a57d4f155cfb214c225932' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/homepage/homepage.tpl',
      1 => 1542621782,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8434894975c35864515d4f4-93180426',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-white text-center mt15 mb15 text-bolder">Naše služby</h2>
            </div>
            <div class="row">
                <div class="homepage pt15">
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getHomepage(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                        <div class="col-md-4 col-xs-12 item">
                            <a href="<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
">
                                <div class="wrap" style="background-image: url(<?php echo $_smarty_tpl->getVariable('item')->value->getImage(1,null,true)->src;?>
);">
                                    <h2><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</h2>
                                    <div class="content">
                                        <div class="clearfix"></div>
                                        <div class="clanky">
                                            <?php  $_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('item')->value->getSubcategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sub']->key => $_smarty_tpl->tpl_vars['sub']->value){
?>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <a href="<?php echo $_smarty_tpl->getVariable('sub')->value->getUrl();?>
"><?php echo $_smarty_tpl->getVariable('sub')->value->name;?>
</a>
                                                    </li>
                                                </ul>
                                            <?php }} ?>
                                        </div>
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
</div>

<div class="container-fluid">
    <div class="container pb40">
        <div class="row">
            <div class="homepage aktuality">
                <div class="col-md-12">
                    <h2 class="text-white text-center mt15 mb15 text-bolder">Aktuality</h2>
                </div>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = dbContentCategory::getNews(3); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                    <div class="col-md-4 col-xs-12 item">
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
<div class="container">
    <div class="mb30">
        <?php $_template = new Smarty_Internal_Template("kontaktni_formular.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </div>
</div>