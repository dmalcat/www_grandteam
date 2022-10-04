<div class="bottom_menu">

	<ul class="bottom_menu_ul">

        {foreach from=dbContentCategory::getAll(1, null, 5) item=item}
			<li class="bottom_menu_li">
				<a href="{$item->getUrl()}" {if $item->selected} class="on"{/if} target="{$item->getTarget()}" id="{$item->seo_name}">{$item->name}</a></li>
			{/foreach}

	</ul>        
</div>