<!DOCTYPE html>
<html lang="cs">
    <head>
        {include file="head.tpl"}
    </head>
    <body>
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TG43G7X" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <div class="container-fluid">
            <div class="row">
                <div class="wrap" id="bg_cycle">
                    <div id="Ximage-holder" class="Xheader">
                        {include file="menu/menu_top.tpl"}
                        <div>
                            {include file=$page_content|default:'homepage/homepage.tpl'}
                        </div>
                        <div class="foot background-gray pt50">
                            <div class="container-fluid">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="row footer_menu">
                                                {foreach from=dbContentCategory::getAll(1, null, 3)->sort("priority") item=item name=top_menu}
                                                    <div class="col-md-15">
                                                        <a href="{$item->getUrl()}" class="text-black">{$item->name}</a>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="pb15">
                                        <div class="text-black">
                                            <div class="row flex-container">
                                                <div class="col-md-2 col-xs-5">
                                                    <div>
                                                        <img src="/images/logo.png" alt="{Registry::getDomain()}" class="logo img-responsive"/>
                                                    </div>
                                                    <div class="mt20 pl20 pr20">
                                                        <a href="https://www.okklient.cz" target="_blank"><img src="/images/OK-KLIENT-logo-registrovane.png" alt="OK KLIENT a.s." class="img-responsive" /></a>
                                                    </div>
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
                                                            <small>© {$smarty.now|date_format:"Y"} {Registry::getDomainName()} <br class="Xhidden-xs" /></small>
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
                            <div class="fb-page" data-href="https://www.facebook.com/grandteamcz" data-width="250" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                                <div class="fb-xfbml-parse-ignore">
                                    <blockquote cite="https://www.facebook.com/grandteamcz">
                                        <a href="https://www.facebook.com/grandteamcz">Grand Asset Management</a>
                                    </blockquote>
                                </div>
                            </div>
                        </div>


                        <script type="text/plain" cookie-consent="functionality">
                            (function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.3&appId=1448956735227506";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>

                        {include file="messages.tpl"}
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





<br />
