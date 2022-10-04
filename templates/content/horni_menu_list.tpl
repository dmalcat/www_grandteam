<div class="row">
    {include file="boxes/drobisky.tpl"}
</div>
<div class="row content_menu">
    {if $dbCC->getSubCategories()|@count}
        {foreach from=$dbCC->getSubCategories()->page() item=item name=content_menu}
            <a href="{$item->getUrl()}" class="content_menu_item {if $smarty.foreach.content_menu.iteration % 3 == 0}right {/if}{if $smarty.foreach.content_menu.first or $smarty.foreach.content_menu.iteration==4 or $smarty.foreach.content_menu.iteration==7}left{/if}" style="background-image:url({dbContentCategory::IMAGES_PATH}{$item->id}/{$item->image_1});">{$item->name}</a>
        {/foreach}
    {/if}
</div>
<div class="row">
    {include file="boxes/vizitky.tpl"}
</div>

