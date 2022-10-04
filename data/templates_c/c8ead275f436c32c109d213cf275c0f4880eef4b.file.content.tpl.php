<?php /* Smarty version Smarty-3.0.7, created on 2018-11-22 09:36:37
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/content/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12310378205bf66a9539a4b7-88420782%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c8ead275f436c32c109d213cf275c0f4880eef4b' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/content/content.tpl',
      1 => 1542836330,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12310378205bf66a9539a4b7-88420782',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div class="Xbackground-white text-black pt50 content_detail">
    <div class="container">
        <div class="row">
            <div class="pb50">
                <?php if ($_smarty_tpl->getVariable('dbCC')->value->getImage(1)->image){?>
                    <div class="detail_img">
                        <img src="<?php echo $_smarty_tpl->getVariable('dbCC')->value->getImage(1)->src;?>
" alt="<?php echo $_smarty_tpl->getVariable('dbCC')->value->name;?>
" class="img-responsive img-full" />
                    </div>
                <?php }?>
                <div class="Xtext-justify content_text pb50">
                    <h1 class="text-bold mb5 pb5"><?php echo $_smarty_tpl->getVariable('dbCC')->value->name;?>
</h1>
                    <div class="detail_text mt15"><?php echo $_smarty_tpl->getVariable('dbC')->value->text_2;?>
</div>

                    <?php if ($_smarty_tpl->getVariable('dbCC')->value->getSubcategories()&&false){?>
                        <div class="homepage mt30 mb30">
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getSubcategories(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                                <div class="col-md-4 item">
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
                            <div class="clearfix"></div>
                        </div>
                    <?php }?>

                    <?php if ($_smarty_tpl->getVariable('dbCC')->value->seoname=="kontakty"){?>
                        <div class="mt30">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2560.9703415771014!2d14.433347316126623!3d50.068117079424376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b947d51a62647%3A0x63fdae91a7f8a58c!2sB%C4%9Blehradsk%C3%A1+858%2F23%2C+120+00+Praha+2-Vinohrady!5e0!3m2!1scs!2scz!4v1538869104860" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    <?php }?>

                    <div class="Xrow mt15 mb15">
                        <div>
                            <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_FOTO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
?>
                                <?php $_template = new Smarty_Internal_Template("content/fotogalerie/content_fotogalerie_do_stranky.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('dbGallery',$_smarty_tpl->tpl_vars['gal']->value);$_template->assign('slider',true); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                            <?php }} ?>

                            <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_FILES); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
?>
                                <?php $_template = new Smarty_Internal_Template("content/fotogalerie/content_download_do_stranky.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('dbGallery',$_smarty_tpl->tpl_vars['gal']->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                            <?php }} ?>

                            <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getMappedGalleries(dbGallery::TYPE_VIDEO); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
?>
                                <?php  $_smarty_tpl->tpl_vars['dbGalleryImage'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('gal')->value->getImages(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['for_galerie']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbGalleryImage']->key => $_smarty_tpl->tpl_vars['dbGalleryImage']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['for_galerie']['iteration']++;
?>
                                    <div class="row text-center">
                                        <div class="col-md-6 col-md-offset-3">
                                            <?php $_template = new Smarty_Internal_Template("content/content_video_jplayer_do_stranky.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('video',$_smarty_tpl->getVariable('dbGalleryImage')->value->dVideo);$_template->assign('index',"g".($_smarty_tpl->getVariable('smarty')->value['foreach']['for_galerie']['iteration']));$_template->assign('height',"300px");$_template->assign('image',$_smarty_tpl->getVariable('dbGalleryImage')->value->pImage);$_template->assign('name',$_smarty_tpl->getVariable('dbGalleryImage')->value->name); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                                        </div>
                                    </div>
                                <?php }} ?>
                            <?php }} ?>
                        </div>
                    </div>
                </div>
                <div class="mt30">
                    <h3 class="text-center text-white fs18">MÁTE DOTAZ NEBO POPTÁVKU ? KONTAKTUJTE NÁS</h3>
                    <?php $_template = new Smarty_Internal_Template("kontaktni_formular.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </div>
            </div>
        </div>
    </div>
</div>
