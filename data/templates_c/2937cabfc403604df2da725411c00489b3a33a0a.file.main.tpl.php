<?php /* Smarty version Smarty-3.0.7, created on 2019-01-17 16:30:18
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11115264525c409f8ae5a717-91595007%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2937cabfc403604df2da725411c00489b3a33a0a' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/main.tpl',
      1 => 1547739012,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11115264525c409f8ae5a717-91595007',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Administrace</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Author" content="3nicom.cz" />
        <meta name="Robots" content="follow" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

        <link href="/css/admin/style_admin.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/jqueryFileTree.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/jquery.treeview.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/jquery-ui-1.8.16.admin.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/shadowbox.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/jquery.uniform.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

        <link href="/css/admin/ext-all.css" media="screen" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .x-combo-list-item{
                text-align: left;
            }
        </style>


        <!--<script src="/js/jquery.1.7.1.min.js" type="text/javascript"></script>-->
        <script src="/js/admin/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="/js/admin/jqueryFileTree.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.treeview.js" type="text/javascript"></script>
        <script src="/js/admin/jquery-ui-1.8.16.js" type="text/javascript"></script>
        <script src="/js/admin/shadowbox.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.mCustomScrollbar.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.mousewheel.min.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.validationEngine-cz.js" type="text/javascript"></script>
        <script src="/js/admin/jquery.tools.min.js" type="text/javascript"></script>
        <script src="/js/admin/jquery-swapsies.js" type="text/javascript"></script>

        <script src="/res/ckeditor/ckeditor.js" type="text/javascript"></script>


        <script type="text/javascript" src="/js/admin/ext-base.js"></script>
        <script type="text/javascript" src="/js/admin/ext-all.js"></script>
        <script type="text/javascript" src="/js/admin/ux/CheckColumn.js"></script>
        <script type="text/javascript" src="/js/admin/swfobject.js"></script>
        <script type="text/javascript" src="/res/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
        <script src="/js/admin/admin.js" type="text/javascript"></script>


        <script type="text/javascript">
            Shadowbox.init();
            $(document).ready(function () {

            <?php if ($_smarty_tpl->getVariable('error_message')->value){?>
                $("#error-message").dialog({
                    modal: true, minWidth: 300, minHeight: 185, resizable: false, buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }}})
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('success_message')->value){?>
                $("#success-message").dialog({
                    modal: true, minWidth: 300, minHeight: 185, resizable: false, buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }}})
            <?php }?>

            });
        </script>

    </head>
    <body>
        <div id="container">
            <?php if (($_smarty_tpl->getVariable('dbUser')->value&&$_smarty_tpl->getVariable('dbUser')->value->isAllowed('administrace-prihlaseni'))||$_smarty_tpl->getVariable('dbUser')->value->login=='admin'){?>
                <div id="header_top">
                    <div class="header_odkaz">
                        <img src="/images/admin/ajax-loader.gif" id="ajaxLoader" border="0" alt=" " />
                        <a href="http://www.3nicom.cz/" title="3nicom" class="notooltip"></a>
                    </div>
                    <div class="cb"></div>
                    <div class="login_form_nadpis">administrační rozhraní</div>
                    <div class="nazev_webu" style="font-size: 15px; margin-top: 5px;"><?php echo Registry::getDomainName();?>
 administrace</div>
                    <div style="font-size: 12px; margin-top: -5px;" id="changePasswordDiv">
                        změna hesla uživatele: <?php echo $_smarty_tpl->getVariable('dbUser')->value->login;?>
<br/>
                        <form action="" method="post">
                            <input type="text" name="newPass" id="newPas" style="width: 100px;"/>
                            <input type="submit" name="doChangePass" value="odeslat" onclick="return confirm('Opravdu si přejete změnit heslo pro uživatele <?php echo $_smarty_tpl->getVariable('dbUser')->value->login;?>
 ?')"/>
                        </form>
                    </div>
                    <div class="jazyky">
                        <?php  $_smarty_tpl->tpl_vars['dbCL'] = new Smarty_Variable;
 $_from = dbContentLang::getAll(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbCL']->key => $_smarty_tpl->tpl_vars['dbCL']->value){
?>
                            <div class="admin_lang">
                                <a href="/admin/lang/<?php echo $_smarty_tpl->getVariable('dbCL')->value->code;?>
"><img src="/images/flags/<?php if (dbContentCategory::getLang()->code==$_smarty_tpl->getVariable('dbCL')->value->code){?>32<?php }else{ ?>24<?php }?>/<?php echo $_smarty_tpl->getVariable('dbCL')->value->code;?>
.png" alt="" /></a>
                            </div>
                        <?php }} ?>
                    </div>
                </div>
                <div id="header">
                    <?php $_template = new Smarty_Internal_Template("admin/menu/menu_top.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </div>
                <div id="main_content" <?php if ($_smarty_tpl->getVariable('par_2')->value=="clanek"||$_smarty_tpl->getVariable('par_2')->value=="kalendar"){?>style="padding-bottom:90px;"<?php }?>>
                    <?php $_template = new Smarty_Internal_Template("admin/fulltext_a_popisky_lista.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                    <div id="vysledky" class="ui-state-highlight ui-corner-all" style="display: none; clear: both; margin: 0px 0px; padding: 5px 10px;">Vysledky hledani</div>
                    <?php if ($_smarty_tpl->getVariable('par_2')->value){?>
                        <?php $_template = new Smarty_Internal_Template("admin/".($_smarty_tpl->getVariable('par_2')->value).".tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                    <?php }else{ ?>
                        <?php $_template = new Smarty_Internal_Template("admin/menu/menu_clanky.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                    <?php }?>
                </div>
                <div id="footer"></div>
            <?php }else{ ?>
                <?php $_template = new Smarty_Internal_Template("admin/login_form.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            <?php }?>

        </div>

        <div style="display:none;" id="error-message" title="Chyba">
            <?php echo $_smarty_tpl->getVariable('error_message')->value;?>

        </div>
        <div style="display:none;" id="success-message" title="Info">
            <?php echo $_smarty_tpl->getVariable('success_message')->value;?>

        </div>
        <div style="display:none;" id="dialog-confirm" title="Potvrzení">

        </div>

    </body>
</html>
