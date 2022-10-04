<div class="container-fluid">
    <div class="container pb40">
        <div class="row">
            <div class="homepage aktuality">
                <div class="col-md-12">
                    <h2 class="text-white text-center mt15 mb15 text-bolder">Aktuality</h2>
                </div>
                {foreach from=dbContentCategory::getNews() item=item name=top_menu}
                    {*<div class="col-md-4 item">
                    {include file="boxes/list_item.tpl"}
                    </div>*}
                    <div class="col-md-4 col-xs-6 item">
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