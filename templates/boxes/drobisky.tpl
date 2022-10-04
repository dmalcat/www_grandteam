<div class="drobisky">
    {foreach from=$dbCC->getNavigation() item=item name=drobisky}
	{if $smarty.foreach.drobisky.iteration > 1}<span class="glyphicon glyphicon-arrow-right text-dark-gray"></span> {/if}<a href="{$item->getUrl()}" title="{$item->name}" {if $smarty.foreach.drobisky.last}{/if}class="text-dark-gray">{$item->name}</a>
    {/foreach}
</div>
