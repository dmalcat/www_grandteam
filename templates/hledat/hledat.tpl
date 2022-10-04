<div class="background-gray-light-light">
    <div class="container pt20">
        <h1 class="text-left pb0 mb0 mt15">Výsledky hledání na dotaz "{$needle}" ({$p_search_results.content|@count} výsledků)</h1>
        <div class="text-justify pb50">
            <div class="row content_menu_submenu mt25">
                {foreach from=$p_search_results.content item=item name=contentList}
                    <div class="col-md-3 text-center">
                        {include file="boxes/list_item.tpl"}
                    </div>
                    {if $smarty.foreach.contentList.iteration % 4 == 0}
                        <div class="clearfix"></div>
                    {/if}
                {/foreach}
                <div class="col-md-12">
                    <div class="text-right">{include file="content/paginator.tpl"}</div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="idCT" value="{$idCT}" />
</div>


