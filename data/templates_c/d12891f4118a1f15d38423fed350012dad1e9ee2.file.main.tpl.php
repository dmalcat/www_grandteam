<?php /* Smarty version Smarty-3.0.7, created on 2018-11-02 12:04:34
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15439800475bdc2f421bbd94-04063595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd12891f4118a1f15d38423fed350012dad1e9ee2' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/main.tpl',
      1 => 1541156662,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15439800475bdc2f421bbd94-04063595',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/www/3nicom.cloud/subdomains/grandteam/res/classes/smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="cs">
    <head>
        <?php $_template = new Smarty_Internal_Template("head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="wrap" id="bg_cycle">
                    <div id="Ximage-holder" class="Xheader">
                        <?php $_template = new Smarty_Internal_Template("menu/menu_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                        <div>
                            <?php $_template = new Smarty_Internal_Template((($tmp = @$_smarty_tpl->getVariable('page_content')->value)===null||$tmp==='' ? 'homepage/homepage.tpl' : $tmp), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                        </div>
                        <div class="foot background-gray pt50">
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
" class="text-black"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</a>
                                                    </div>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="pb15">
                                        <div class="text-black">
                                            <div class="row flex-container">
                                                <div class="col-md-2 col-xs-5">
                                                    <img src="/images/logo.png" alt="<?php echo Registry::getDomain();?>
" class="logo img-responsive"/>
                                                </div>
                                                <div class="col-md-4 col-md-offset-2 small col-xs-7 mb15">
                                                    <strong>Grand Asset Management &nbsp;s.r.o.</strong><br />
                                                    Bělehradsk&aacute; 858/23<br />
                                                    120 00 Praha 2<br />
                                                    IČ: 06339956<br />
                                                    <br />
                                                    <a href="mailto:info@grandteam.cz" class="text-black">info@grandteam.cz</a><br />
                                                    Infolinka: +420 222 222 288
                                                </div>
                                                <div class="col-md-4 text-black small col-xs-12 small">
                                                    <div class="text-right">
                                                        <div class="pull-right">
                                                            <small>© <?php echo smarty_modifier_date_format(time(),"Y");?>
 <?php echo Registry::getDomainName();?>
 <br class="Xhidden-xs" /></small>
                                                            <div class="pull-left">
                                                                <div class="small mt15 text-gray-dark fs10">
                                                                    realizace: <br class="hidden-xs" /> <a href="http://www.3nicom.cz" target="_blank" class="text-black">3Nicom websolutions s.r.o.</a> <br />
                                                                    <a href="http://www.getrun.cz" target="_blank" class="text-black">Getrun s.r.o.</a>
                                                                </div>
                                                            </div>
                                                            <div class="pull-left mt15 ml15">
                                                                <a href="http://www.getrun.cz"><img src="/images/LOGO-Getrun.png" alt="Getrun" height="40" class="pull-right" /></a>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                        <br /><br />

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="fb-root"></div>

                        <div id='fbplikebox' class="none hidden-xs">
                            <div class='fbplbadge'></div>
                            <div class="fb-page" data-href="https://www.facebook.com/MacCafe.cz/" data-width="250" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                                <div class="fb-xfbml-parse-ignore">
                                    <blockquote cite="https://www.facebook.com/MacCafe.cz/">
                                        <a href="https://www.facebook.com/MacCafe.cz/">vitahelp.cz</a>
                                    </blockquote>
                                </div>
                            </div>
                        </div>


                        <script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.3&appId=1448956735227506";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>

                        <?php $_template = new Smarty_Internal_Template("counter.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                        <?php $_template = new Smarty_Internal_Template("messages.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="preload-01"></div>
        <div id="preload-02"></div>
        <div id="preload-03"></div>
        <div id="preload-04"></div>
    </body>
</html>


