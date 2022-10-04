{foreach from=dbGallery::getAll(dbGallery::TYPE_FILES) item=item}
    <div class="seznam_bg" id="galleryList_{$item->id}">
        <div class="seznam_nazev">
            <a href="/admin/editace_dokumentu/{$item->id}">{$item->name}</a>
        </div>
        <div class="seznam_zobrazit">
            <input type="checkbox" {if $item->visible}checked="checked"{/if}  onclick="setGalleryVisibility(this, {$item->id})"/>
        </div>
        <div class="seznam_upravit_galerii">
            <a href="/admin/editace_dokumentu/{$item->id}" title="Upravit obsah fotogalerii"></a>
        </div>
        <div class="seznam_upravit">
            <a href="/admin/dokumenty/{$item->id}" title="Upravit fotogalerii"></a>
        </div>

        <div class="seznam_smazat">
            <a href="javascript: void(0)" title="Smazat fotogalerii" rel="{$item->id}" class="galleryDelete"></a>
        </div>
        <div class="seznam_datum">{$sub_item->datum|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
    </div>
{/foreach}
<script type="text/javascript" src="/js/admin/fotogalerie.js"></script>