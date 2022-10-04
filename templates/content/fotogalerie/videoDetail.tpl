<div class="content_bg">
	<div class="content_in">        
		<div class="content_clanek">
			<div class="content_clanek_text">
				<h2 class="galerie_detail_name">{$dbGallery->name}</h2>
				<p>{$dbGallery->description}</p>
				<table width="800" border="0" cellpadding="0" cellspacing="0" style="max-width: 800px; margin-bottom: 15px;">
					<tr>
						{foreach from=$dbGallery->getImages(true) item=dbGalleryImage name=for_galerie}
							<td align="center" valign="top">
								{include file="content/content_video_jplayer.tpl"}
							</td>
							{if $smarty.foreach.for_galerie.iteration % 1 ==0}</tr><tr>{/if}
						{/foreach}
					</tr>
				</table>
			</div>

		</div>
	</div>
</div>
<div class="right">  
	{include file="boxes/novinky.tpl"} 
	{include file="boxes/fotogalerie.tpl"}
	{include file="boxes/videa.tpl"}
</div>
{*
{if !$dbCC}{assign var=dbCC value=dbContentCategory::getHP()}{/if}
<div class="content_bg">
<div class="content_in">        
<div class="content_clanek">
<div class="content_clanek_text">
<h2 class="galerie_detail_name">{$dbCC->name}</h2>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="max-width: 800px; margin-bottom: 15px;">
<tr>
{include file="content/content_video_jplayer.tpl"}
</tr>
</table>
</div>

</div>
</div>
</div>
*}