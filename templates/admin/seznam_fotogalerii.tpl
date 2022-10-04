<div id="accordion_gallery">
    {foreach from=dbGallery::getAll(dbGallery::TYPE_FOTO) item=dbGallery}
        <h3 class="bg" data-id="{$dbGallery->id}">
            <div class="seznam_bg" id="galleryList_{$dbGallery->id}">
                <div class="seznam_nazev">
                    <a href="/admin/editace_fotogalerie/{$dbGallery->id}" class="no_acc" style="display: inline; color: white;">{$dbGallery->name} ({$dbGallery->getImages()|@count})</a>
                    {*					{$dbGallery->name}*}
                </div>
                <div class="seznam_zobrazit">
                    <input type="checkbox" {if $dbGallery->visible}checked="checked"{/if}  onclick="setGalleryVisibility(this, {$dbGallery->id})"/>
                </div>
                <div class="seznam_upravit_galerii">
                    <a href="/admin/editace_fotogalerie/{$dbGallery->id}" title="Upravit obsah fotogalerii" class="no_acc"></a>
                </div>
                <div class="seznam_upravit">
                    <a href="/admin/fotogalerie/{$dbGallery->id}" title="Upravit fotogalerii" class="no_acc"></a>
                </div>

                <div class="seznam_smazat">
                    <a href="javascript: void(0)" title="Smazat fotogalerii" rel="{$dbGallery->id}" class="galleryDelete" class="no_acc"></a>
                </div>
                <div class="seznam_datum">{$sub_dbGallery->datum|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
            </div>
        </h3>


    {/foreach}
</div>
<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>
