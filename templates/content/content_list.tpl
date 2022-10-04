<div class="background-gray-light-light">
    <div class="container pt20">
        <div class="row">
            <div class="col-md-{$rightSide|if:'8':'12'}">
                <h1 class="text-left pb0 mb0 mt15 mb15">{$dbCC->name}</h1>
                <div class="text-justify pb50">
                    {if $dbCCs|@count}
                        <div class="row">
                            {if $dbCategories->count()}
                                <div class="col-md-3">
                                    {foreach from=$dbCategories item=item name=forCategories}
                                        <div class="Xthumbnail mb15">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{$item->getUrl()}"><img src="{$item->getImage(1)->src}" alt="{$item->name}" class="img-responsive img-full" /></a>
                                                        {*                                                    <h2 class="mt10 fs15 text-left"><a href="{$item->getUrl()}">{$item->name}</a></h2>*}
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}
                            <div class="col-md-{$dbCategories->count()|if:'9':'12'}">
                                <div class="row content_menu_submenu">
                                    {foreach from=$dbCCs item=item name=contentList}
                                        <div class="col-md-12 text-center">
                                            {include file="boxes/list_item.tpl"}
                                        </div>
                                        {if $smarty.foreach.contentList.iteration % 1 == 0}
                                            <div class="clearfix"></div>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">{include file="content/paginator.tpl"}</div>
                    {/if}
                </div>
                {if $pBottom}
                    <div class="dalsi_clanky">
                        <h2 class="text-gray text-uppercase pt10 pb15"><strong>Další</strong> články</h2>
                        <div class="row">
                            {foreach from=$pBottom item=item}
                                <div class="col-md-12">
                                    {include file="boxes/list_item.tpl"}
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/if}
            </div>
            {if $rightSide}
                <div class="col-md-4">
                    {include file="prava_strana.tpl"}
                </div>
            {/if}
        </div>
    </div>
    <input type="hidden" id="idCT" value="{$idCT}" />
</div>