
<div class="content_bg">
	<div class="content_in">        
		<div style="background-image:url(/images/content_submenu_in.jpg); background-repeat: repeat-x; background-position:bottom; float:left;">
			<div class="content_clanek">       
				{include file="boxes/drobisky.tpl"}
				{foreach from=$pGalleries item=dbGallery}
					<div class="vypis_content_box" style="width:815px;">
						<div class="vypis_content_box_text" style="width:785px; font-size:16px;"> 
                        <div style="float:left;width: 208px; height: 115px; margin-right:10px; ">
							<img src="{$dbGallery->galleryImage}" style="max-width: 208px; max-height: 115px;  float:left;" /></div>
							<a href="{$dbGallery->getUrl()}" style="text-decoration:none;" ><h2 style=" font-size:20px;">{$dbGallery->name}</h2></a> 
								{$dbGallery->annotation}
						</div>
						<a href="{$dbGallery->getUrl()}" style="margin-bottom:-10px; float:right; font-size:11px; text-decoration: none; margin-right:20px;" >VÍCE...</a></div>       
					{/foreach}

			</div>
		</div>
	</div>
</div>

<div class="right">
	{include file="boxes/vizitky.tpl"} 
	{include file="boxes/novinky.tpl"} 
	{include file="boxes/fotogalerie.tpl"} 		
	{include file="boxes/videa.tpl"}
</div>			