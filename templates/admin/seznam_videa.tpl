<div id="accordion_gallery">
	{foreach from=dbGallery::getAll(dbGallery::TYPE_VIDEO) item=dbGallery}
		<h3 class="bg" data-id="{$dbGallery->id}">
			<div class="seznam_bg" id="galleryList_{$dbGallery->id}">
				{*				<div class="ikona"><span class="{if $dbGallery->getSubGalleries()}ui-icon ui-icon-circle-plus{else}ui-icon ui-icon-triangle-1-e{/if}"></span></div>*}
				<div class="seznam_nazev">
					<a href="/admin/editace_videa/{$dbGallery->id}" class="no_acc" style="display: inline; color: white;">{$dbGallery->name} ({$dbGallery->getSubGalleries()|@count})</a>
					{*					{$dbGallery->name}*}
				</div>
				<div class="seznam_zobrazit">
					<input type="checkbox" {if $dbGallery->visible}checked="checked"{/if}  onclick="setGalleryVisibility(this, {$dbGallery->id})"/>
				</div>
				<div class="seznam_upravit_galerii">
					<a href="/admin/editace_videa/{$dbGallery->id}" title="Upravit obsah videogalerie" class="no_acc"></a>
				</div>
				<div class="seznam_upravit">
					<a href="/admin/videa/{$dbGallery->id}" title="Upravit videogalerii" class="no_acc"></a>
				</div>

				<div class="seznam_smazat">
					<a href="javascript: void(0)" title="Smazat videogalerii" rel="{$dbGallery->id}" class="galleryDelete" class="no_acc"></a>
				</div>
				<div class="seznam_datum">{$sub_dbGallery->datum|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
			</div>
		</h3>
		<div>
			{if $dbGallery->getSubGalleries()}
				{foreach from=$dbGallery->getSubGalleries() item=dbGallerySub}
					<div class="bg" data-id="{$dbGallerySub->id}">
						<div class="seznam_bg" id="galleryList_{$dbGallerySub->id}">
							<div class="seznam_nazev">
								<a href="/admin/editace_videa/{$dbGallerySub->id}">&nbsp;&nbsp;&nbsp;-&nbsp;{$dbGallerySub->name}</a>
{*								&nbsp;&nbsp;&nbsp;-&nbsp;{$dbGallerySub->name}*}
							</div>
							<div class="seznam_zobrazit">
								<input type="checkbox" {if $dbGallerySub->visible}checked="checked"{/if}  onclick="setGalleryVisibility(this, {$dbGallerySub->id})"/>
							</div>
							<div class="seznam_upravit_galerii">
								<a href="/admin/editace_videa/{$dbGallerySub->id}" title="Upravit obsah videogalerie" class="no_acc"></a>
							</div>
							<div class="seznam_upravit">
								<a href="/admin/videoa/{$dbGallerySub->id}" title="Upravit videogalerii" class="no_acc"></a>
							</div>

							<div class="seznam_smazat">
								<a href="javascript: void(0)" title="Smazat videogalerii" rel="{$dbGallerySub->id}" class="galleryDelete" class="no_acc"></a>
							</div>
							<div class="seznam_datum">{$sub_dbGallery->datum|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
						</div>
					</div>
				{/foreach}
			{/if}
		</div>

	{/foreach}
</div>
<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>
<script>
	$(function() {
		// definice obrazku v accordion
		var icons = {
			header: "ui-icon ui-icon-circle-plus",
			headerSelected: "ui-icon ui-icon-circle-minus"
		};
		$("#accordion_gallery").accordion({
			collapsible: true,
			heightStyle: "content",
			icons: icons
		});

		$("a.no_acc").click(function(event) {
			event.stopPropagation();
		});
	});
</script>