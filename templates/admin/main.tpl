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

        {*        <script src="/bower_components/selectize/dist/js/standalone/selectize.min.js"></script>*}
        {*        <link rel="stylesheet" href="/bower_components/selectize/dist/css/selectize.bootstrap3.css"/>*}


        <script type="text/javascript" src="/js/admin/ext-base.js"></script>
        <script type="text/javascript" src="/js/admin/ext-all.js"></script>
        <script type="text/javascript" src="/js/admin/ux/CheckColumn.js"></script>
        <script type="text/javascript" src="/js/admin/swfobject.js"></script>
        <script type="text/javascript" src="/res/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
        <script src="/js/admin/admin.js" type="text/javascript"></script>


        <script type="text/javascript">
            Shadowbox.init();
            $(document).ready(function () {

            {if $error_message}
                $("#error-message").dialog({
                    modal: true, minWidth: 300, minHeight: 185, resizable: false, buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }}})
            {/if}
            {if $success_message}
                $("#success-message").dialog({
                    modal: true, minWidth: 300, minHeight: 185, resizable: false, buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }}})
            {/if}

            });
        </script>

    </head>
    <body>
        <div id="container">
            {if ($dbUser && $dbUser->isAllowed('administrace-prihlaseni')) || $dbUser->login == 'admin'}
                <div id="header_top">
                    <div class="header_odkaz">
                        <img src="/images/admin/ajax-loader.gif" id="ajaxLoader" border="0" alt=" " />
                        <a href="http://www.3nicom.cz/" title="3nicom" class="notooltip"></a>
                    </div>
                    <div class="cb"></div>
                    <div class="login_form_nadpis">administrační rozhraní</div>
                    <div class="nazev_webu" style="font-size: 15px; margin-top: 5px;">{Registry::getDomainName()} administrace</div>
                    <div style="font-size: 12px; margin-top: -5px;" id="changePasswordDiv">
                        změna hesla uživatele: {$dbUser->login}<br/>
                        <form action="" method="post">
                            <input type="text" name="newPass" id="newPas" style="width: 100px;"/>
                            <input type="submit" name="doChangePass" value="odeslat" onclick="return confirm('Opravdu si přejete změnit heslo pro uživatele {$dbUser->login} ?')"/>
                        </form>
                    </div>
                    <div class="jazyky">
                        {foreach from=dbContentLang::getAll() item=dbCL}
                            <div class="admin_lang">
                                <a href="/admin/lang/{$dbCL->code}"><img src="/images/flags/{if dbContentCategory::getLang()->code == $dbCL->code}32{else}24{/if}/{$dbCL->code}.png" alt="" /></a>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div id="header">
                    {include file="admin/menu/menu_top.tpl"}
                </div>
                <div id="main_content" {if $par_2=="clanek" or $par_2=="kalendar"}style="padding-bottom:90px;"{/if}>
                    {include file="admin/fulltext_a_popisky_lista.tpl"}
                    <div id="vysledky" class="ui-state-highlight ui-corner-all" style="display: none; clear: both; margin: 0px 0px; padding: 5px 10px;">Vysledky hledani</div>
                    {if $par_2}
                        {include file="admin/$par_2.tpl"}
                    {else}
                        {include file="admin/menu/menu_clanky.tpl"}
                    {/if}
                </div>
                <div id="footer"></div>
            {else}
                {include file="admin/login_form.tpl"}
            {/if}

        </div>

        <div style="display:none;" id="error-message" title="Chyba">
            {$error_message}
        </div>
        <div style="display:none;" id="success-message" title="Info">
            {$success_message}
        </div>
        <div style="display:none;" id="dialog-confirm" title="Potvrzení">

        </div>

    </body>
</html>
