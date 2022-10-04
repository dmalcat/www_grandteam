<div class="content_bg">
    <div class="content_in"> 
	<div style=" background-image:url(/images/content_submenu_in.jpg); background-repeat: repeat-x; background-position:bottom; float:left;">
	    <div class="content_clanek">       
		{*include file="boxes/drobisky.tpl"*}
		{foreach from=$p_search_results item=sub_item}
		    <div class="vypis_content_box" style="width:815px;">
			<div class="vypis_content_box_text" style="width:785px; ;"> 
			    <div style="float:left; width: 208px; height: 115px; margin-right:10px; ">
				{if $sub_item->image_1}
				    <img src="{dbContentCategory::IMAGES_PATH}{$sub_item->id}/P-{$sub_item->image_1}" style="max-width: 208px; max-height: 115px; margin-right:10px; float:left;" /></div>
				{else}
				<div style="width: 208px; height: 115px; background-color: #E9E7E8;">
				    <img src="/images/logo_bottom.jpg" style="max-width: 208px; max-height: 115px; margin-right:10px; float:left; padding-top: 20px;" />
				</div>
			    </div>

			{/if}

			<a href="{$sub_item->getUrl()}" style="text-decoration:none;" ><h2 style=" font-size:19px; margin-bottom:10px;">{$sub_item->name}</h2></a> 
			{$sub_item->getContent()->text_1} </div>
		    <a href="{$sub_item->getUrl()}" style="margin-bottom:-10px; float:right; font-size:11px; text-decoration: none; margin-right:20px;" >VÍCE...</a></div>       
		{/foreach}


	</div>
    </div>
</div>
{include file="content/pager.tpl"}
</div>
<div class="right">
    {*include file="boxes/vizitky.tpl"*} 
    {include file="boxes/novinky.tpl"} 
    {include file="boxes/fotogalerie.tpl"} 		
    {include file="boxes/videa.tpl"}
</div>

{*
<div class="list">
<h1 class="detail_title">Výsledky hledání na dotaz "{$smarty.post.search_full}"</h1>
<div class="content_text2">
{if $p_search_results.content}
<p>( nalezeno {$p_search_results.content|@count} výsledků)</p>
<ul id="search_result" class="content_menu">
{foreach from=$p_search_results.content item=p_item}
<li>
<a href="/{$p_item->seo_name}" class="aktuality_menu_title" target="{$p_item->target}">{$p_item->name}</a>
</li>
{/foreach}
</ul>
{/if}
</div>
</div>
*}