{*{include file="boxes/slider.tpl"}*}
<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-white text-center mt15 mb15 text-bolder">Naše služby</h2>
            </div>
            <div class="row">
                <div class="homepage pt15">
                    {foreach from=dbContentCategory::getHomepage() item=item}
                        <div class="col-md-4 col-xs-12 item">
                            <a href="{$item->getUrl()}">
                                <div class="wrap" style="background-image: url({$item->getImage(1, NULL, TRUE)->src});">
                                    <h2>{$item->name}</h2>
                                    <div class="content">
                                        {*                                        {$item->getContent()->text_1}*}
                                        <div class="clearfix"></div>
                                        <div class="clanky">
                                            {foreach from=$item->getSubcategories() item=sub}
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <a href="{$sub->getUrl()}">{$sub->name}</a>
                                                    </li>
                                                </ul>
                                            {/foreach}
                                        </div>
                                        {*                                        <a href="{$item->getUrl()}" class="btn btn_transparent mt15">Vstoupit</a>*}
                                    </div>
                                </div>
                            </a>
                        </div>
                    {/foreach}
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
                {foreach from=dbContentCategory::getNews(3) item=item name=top_menu}
                    {*<div class="col-md-4 item">
                    {include file="boxes/list_item.tpl"}
                    </div>*}
                    <div class="col-md-4 col-xs-12 item">
                        <a href="{$item->getUrl()}">
                            <div class="wrap" style="background-image: url({$item->getImage(1, NULL, TRUE)->src});">
                                <h2>{$item->name}</h2>
                                <div class="content">
                                    {$item->getContent()->text_1}
                                    <div class="clearfix"></div>
                                    <a href="{$item->getUrl()}" class="btn btn_transparent mt15">Vstoupit</a>
                                </div>
                            </div>
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="mb30">
        {include file="kontaktni_formular.tpl"}
    </div>
</div>