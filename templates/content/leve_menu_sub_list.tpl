<div class="content_bg">
	<div class="content_in">        
		<div class="content_submenu_menu">          
			{include file="boxes/drobisky_submenu.tpl"}
			<ul> 
				{foreach from=$dbCC->getSubCategories(1) item=sub_item}       
					<li class="vypis_submenu_box">
						<a href="{$sub_item->getUrl()}" style=" margin-left:0px;" > <h2 style=" margin-left:0px;" >{$sub_item->name}</h2></a>
					</li>                
				{/foreach}
			</ul>
		</div>
	</div>
</div>
<div class="right">
	{include file="boxes/vizitky.tpl"} 
	{include file="boxes/fotogalerie_produkt.tpl"} 			
	{include file="boxes/videa_produkt.tpl"}
</div>
